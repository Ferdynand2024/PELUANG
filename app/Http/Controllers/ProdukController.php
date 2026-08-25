<?php
namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProdukController extends Controller
{
    // ── Helper: scope produk milik TPI yang sedang login ─────────

    /**
     * Kembalikan query Produk yang hanya milik TPI yang login.
     * Dipakai di semua method TPI agar TPI lain tidak bisa
     * mengakses / mengubah produk yang bukan miliknya.
     */
    private function ownedProduk()
    {
        return Produk::where('tpi_id', Auth::id());
    }

    // ── TPI: CRUD Produk ──────────────────────────────────────────

    /**
     * Daftar produk milik TPI yang login.
     */
    public function index(): View
    {
        $produk = $this->ownedProduk()->latest()->get();
        return view('produk.index', compact('produk'));
    }

    /**
     * Form tambah produk baru.
     */
    public function create(): View
    {
        return view('produk.create');
    }

    /**
     * Simpan produk baru — tpi_id otomatis dari Auth::id().
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'foto'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jenis_ikan' => 'required|string|max:255',
            'berat'      => 'required|numeric|min:0',
            'harga_awal' => 'required|numeric|min:0',
            'deskripsi'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto     = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $fotoPath = 'uploads/' . $fotoName;
            Storage::disk('public')->put($fotoPath, file_get_contents($foto));
        }

        Produk::create([
            'tpi_id'     => Auth::id(),
            'foto'       => $fotoPath,
            'jenis_ikan' => $request->jenis_ikan,
            'berat'      => $request->berat,
            'harga_awal' => $request->harga_awal,
            'deskripsi'  => $request->deskripsi,
        ]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk — hanya milik TPI yang login.
     */
    public function edit(int $id): View
    {
        $produk = $this->ownedProduk()->findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    /**
     * Update produk — hanya milik TPI yang login.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $produk = $this->ownedProduk()->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'foto'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'jenis_ikan' => 'required|string|max:255',
            'berat'      => 'required|numeric|min:0',
            'harga_awal' => 'required|numeric|min:0',
            'deskripsi'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $foto     = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            $fotoPath = 'uploads/' . $fotoName;
            Storage::disk('public')->put($fotoPath, file_get_contents($foto));
            $produk->foto = $fotoPath;
        }

        $produk->jenis_ikan = $request->jenis_ikan;
        $produk->berat      = $request->berat;
        $produk->harga_awal = $request->harga_awal;
        $produk->deskripsi  = $request->deskripsi;
        $produk->save();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk — hanya milik TPI yang login.
     */
    public function destroy(int $id): RedirectResponse
    {
        $produk = $this->ownedProduk()->findOrFail($id);

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // ── TPI: Manajemen Lelang ─────────────────────────────────────

    /**
     * Mulai lelang — hanya produk milik TPI yang login.
     */
    public function mulai(Produk $produk): RedirectResponse
    {
        abort_if($produk->tpi_id !== Auth::id(), 403, 'Akses ditolak.');

        if ($produk->status_lelang !== 'belum_dimulai') {
            return redirect()->back()
                ->with('error', 'Lelang sudah dimulai atau ditutup.');
        }

        $produk->update([
            'status_lelang' => 'dibuka',
            'waktu_mulai'   => now(),
            'waktu_selesai' => now()->addMinutes(5),
        ]);

        return redirect()->back()
            ->with('success', 'Lelang untuk ' . $produk->jenis_ikan . ' telah dimulai.');
    }

    /**
     * Selesaikan lelang dan tentukan pemenang — hanya milik TPI yang login.
     */
    public function selesaiLelang(Produk $produk): RedirectResponse
    {
        abort_if($produk->tpi_id !== Auth::id(), 403, 'Akses ditolak.');

        if ($produk->status_lelang !== 'dibuka') {
            return redirect()->back()
                ->with('error', 'Lelang tidak dalam status dibuka.');
        }

        DB::transaction(function () use ($produk) {
            $highestBids = Penawaran::where('produk_id', $produk->id)
                ->orderBy('jumlah_penawaran', 'desc')
                ->take(2)
                ->get();

            $winnerId       = null;
            $backupWinnerId = null;

            if ($highestBids->isNotEmpty()) {
                $winnerId                   = $highestBids[0]->user_id;
                $produk->pemenang_lelang_id = $winnerId;
                $produk->harga_akhir        = $highestBids[0]->jumlah_penawaran;

                if ($highestBids->count() > 1) {
                    $backupWinnerId               = $highestBids[1]->user_id;
                    $produk->pemenang_cadangan_id = $backupWinnerId;
                }
            }

            $produk->status_lelang = 'ditutup';
            if (is_null($produk->waktu_selesai)) {
                $produk->waktu_selesai = now();
            }
            $produk->save();

            $allBidders = Penawaran::where('produk_id', $produk->id)
                ->distinct('user_id')
                ->pluck('user_id');

            foreach ($allBidders as $bidderId) {
                if ($bidderId == $winnerId) {
                    Session::flash('lelang_status_' . $bidderId, [
                        'type'    => 'success',
                        'message' => 'Selamat! Anda pemenang utama "' . $produk->jenis_ikan . '".',
                        'status'  => 'won',
                    ]);
                } elseif ($bidderId == $backupWinnerId) {
                    Session::flash('lelang_status_' . $bidderId, [
                        'type'    => 'info',
                        'message' => 'Anda pemenang cadangan "' . $produk->jenis_ikan . '".',
                        'status'  => 'backup',
                    ]);
                } else {
                    Session::flash('lelang_status_' . $bidderId, [
                        'type'    => 'warning',
                        'message' => 'Anda kalah di lelang "' . $produk->jenis_ikan . '".',
                        'status'  => 'lost',
                    ]);
                }
            }
        });

        return redirect()->back()
            ->with('success', 'Lelang ditutup. Pemenang sudah ditentukan.');
    }

    /**
     * Tampilkan daftar penawaran untuk produk milik TPI yang login.
     */
    public function showPenawaran(int $id): View
    {
        $produk     = $this->ownedProduk()->findOrFail($id);
        $penawarans = $produk->penawaran()
            ->with('user')
            ->orderBy('jumlah_penawaran', 'desc')
            ->get();

        return view('produk.penawaran', compact('produk', 'penawarans'));
    }

    /**
     * Tutup lelang yang sudah lewat waktu (dipanggil cron job).
     */
    public function tutupLelangOtomatis()
    {
        $produks = Produk::where('status_lelang', 'dibuka')
            ->where('waktu_selesai', '<=', now())
            ->get();

        foreach ($produks as $produk) {
            $highestBids = Penawaran::where('produk_id', $produk->id)
                ->orderBy('jumlah_penawaran', 'desc')
                ->take(2)
                ->get();

            if ($highestBids->isNotEmpty()) {
                $produk->update([
                    'status_lelang'        => 'ditutup',
                    'pemenang_lelang_id'   => $highestBids[0]->user_id,
                    'harga_akhir'          => $highestBids[0]->jumlah_penawaran,
                    'pemenang_cadangan_id' => $highestBids->count() > 1
                        ? $highestBids[1]->user_id
                        : null,
                ]);
            } else {
                $produk->update(['status_lelang' => 'ditutup']);
            }
        }

        return response()->json([
            'message' => 'Tutup otomatis selesai.',
            'total'   => $produks->count(),
        ]);
    }

    /**
     * Kirim notifikasi WhatsApp ke pemenang cadangan via Fonnte.
     */
    public function kirimNotifCadangan($id)
    {
        $produk = $this->ownedProduk()
            ->with(['penawaran.user'])
            ->findOrFail($id);

        $penawarans    = $produk->penawaran->sortByDesc('jumlah_penawaran')->values();
        $pemenangUtama = $penawarans->get(0);
        $pemenangKedua = $penawarans->get(1);

        if (! $pemenangUtama || ! $pemenangKedua) {
            return back()->with('error', 'Data penawar tidak lengkap.');
        }

        if ($pemenangUtama->status !== 'gugur') {
            return back()->with('error', 'Pemenang utama belum dinyatakan gugur.');
        }

        $nomor = preg_replace('/[^0-9]/', '', $pemenangKedua->user->phone);
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        $text = "Halo {$pemenangKedua->user->name},\n\n"
        . "🎉 Selamat! Anda menjadi *penawar kedua* untuk:\n\n"
        . "🐟 Jenis Ikan: {$produk->jenis_ikan}\n"
        . "⚖️ Berat: {$produk->berat} kg\n"
        . "💰 Tawaran Anda: Rp " . number_format($pemenangKedua->jumlah_penawaran, 0, ',', '.') . "\n\n"
            . "Pemenang utama telah *didiskualifikasi*. Segera lakukan pembayaran.\n"
            . "Terima kasih telah mengikuti lelang di TPI Digital 🎣";

        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target'  => $nomor,
            'message' => $text,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Notifikasi berhasil dikirim ke ' . $pemenangKedua->user->name);
        }

        return back()->with('error', 'Gagal mengirim pesan WhatsApp.');
    }

    // ── Cek pemenang otomatis (dipanggil dari show pembeli) ───────

    public function cekPemenang($produk)
    {
        $penawarans = $produk->penawaran()
            ->orderBy('jumlah_penawaran', 'desc')
            ->get();

        if ($penawarans->isEmpty()) {
            return null;
        }

        $pemenang1 = $penawarans[0];

        if (
            $pemenang1->status === 'belum'
            && now()->gt($produk->waktu_selesai->copy()->addMinutes(2))
        ) {
            $pemenang1->status = 'gugur';
            $pemenang1->save();

            $produk->waktu_gugur_pemenang1 = now();
            $produk->save();

            if (isset($penawarans[1])) {
                $pemenang2 = $penawarans[1];

                if ($pemenang2->status !== 'sudah') {
                    $pemenang2->status = 'belum';
                    $pemenang2->save();

                    $produk->pemenang_lelang_id = $pemenang2->user_id;
                    $produk->save();
                }

                // Reload dari DB agar cek status berikutnya tidak terpengaruh
                // nilai yang baru saja di-set di atas (race condition fix).
                $pemenang2->refresh();

                if (
                    $pemenang2->status === 'belum'
                    && now()->gt($produk->waktu_gugur_pemenang1->copy()->addMinutes(2))
                ) {
                    $pemenang2->status = 'gugur';
                    $pemenang2->save();

                    $produk->pemenang_lelang_id = null;
                    $produk->save();

                    return null;
                }

                return $pemenang2;
            }

            return null;
        }

        return $pemenang1;
    }

    // ── Pembeli: tampilkan produk lelang aktif ────────────────────

    /**
     * Daftar lelang aktif dengan pencarian & filter.
     */
    public function index2(Request $request): View
    {
        $query = Produk::where('status_lelang', 'dibuka')->with('tpi');

        // Pencarian berdasarkan nama ikan
        if ($request->filled('search')) {
            $query->where('jenis_ikan', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan rentang harga awal
        if ($request->filled('harga_min')) {
            $query->where('harga_awal', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_awal', '<=', $request->harga_max);
        }

        // Filter berdasarkan berat minimum
        if ($request->filled('berat_min')) {
            $query->where('berat', '>=', $request->berat_min);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'harga_asc'  => $query->orderBy('harga_awal', 'asc'),
            'harga_desc' => $query->orderBy('harga_awal', 'desc'),
            'berat_asc'  => $query->orderBy('berat', 'asc'),
            'berat_desc' => $query->orderBy('berat', 'desc'),
            'waktu_asc'  => $query->orderBy('waktu_selesai', 'asc'),
            default      => $query->latest(),
        };

        $produk = $query->get();

        // Daftar jenis ikan aktif untuk autocomplete
        $jenisIkanList = Produk::where('status_lelang', 'dibuka')
            ->distinct()
            ->pluck('jenis_ikan');

        return view('pembeli.lelang', compact('produk', 'jenisIkanList'));
    }

    public function show(int $id): View
    {
        $produk = Produk::with('tpi')->findOrFail($id);
        $this->cekPemenang($produk);
        return view('pembeli.lelangshow', compact('produk'));
    }

    // ── Public: Landing page (search + lelang terbaru) ───────────────

/**
 * Tampilkan landing page.
 * Default: 3 lelang terbaru yang sedang berlangsung.
 * Jika ada keyword 'q', tampilkan hasil pencarian (lelang yg sedang dibuka).
 */
    public function landing(Request $request): View
    {
        $query = Produk::where('status_lelang', 'dibuka')->with('tpi');

        $searched = false;
        $keyword  = $request->get('q');

        if ($request->filled('q')) {
            $searched = true;
            $query->where('jenis_ikan', 'like', '%' . $request->q . '%');
        }

        $produk = $searched
            ? $query->latest()->get()
            : $query->latest()->take(3)->get();

        return view('landingpage', compact('produk', 'searched', 'keyword'));
    }

}
