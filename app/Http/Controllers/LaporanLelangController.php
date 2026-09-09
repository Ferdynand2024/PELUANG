<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use App\Exports\TpiLaporanExport;
use App\Exports\DinasLaporanExport;

class LaporanLelangController extends Controller
{
    /**
     * Laporan umum (lintas TPI) — dipakai untuk Admin.
     * Tetap dipertahankan seperti semula.
     */
    public function index(Request $request)
    {
        $query = Produk::with(['penawaran' => function ($q) {
                $q->where('status', 'sudah')->with('user');
            }])
            ->whereNotNull('waktu_selesai')
            ->whereHas('penawaran', function ($q) {
                $q->where('status', 'sudah');
            });

        $this->applyPeriodFilter($query, $request);

        $produkList = $query->orderBy('waktu_selesai', 'desc')->get();

        $totalPenjualan = $this->hitungTotal($produkList);

        return view('laporan.laporan', compact('produkList', 'totalPenjualan'));
    }

    public function export(Request $request)
    {
        return Excel::download(
            new LaporanExport($request->tahun, $request->bulan),
            'laporan_lelang.xlsx'
        );
    }

    /**
     * ──────────────────────────────────────────────────────────
     * FITUR 1: Laporan khusus TPI yang sedang login.
     * Hanya menampilkan produk miliknya sendiri, dengan
     * penawaran yang statusnya sudah dibayar ("sudah").
     * Filter tersedia: Tahun, Bulan.
     * ──────────────────────────────────────────────────────────
     */
    public function tpiIndex(Request $request)
    {
        abort_unless(Auth::user()->isTpi(), 403, 'Halaman ini khusus untuk role TPI.');

        $tpiId = Auth::id();

        $query = Produk::with(['penawaran' => function ($q) {
                $q->where('status', 'sudah')->with('user');
            }])
            ->where('tpi_id', $tpiId)
            ->whereNotNull('waktu_selesai')
            ->whereHas('penawaran', function ($q) {
                $q->where('status', 'sudah');
            });

        $this->applyPeriodFilter($query, $request);

        $produkList = $query->orderBy('waktu_selesai', 'desc')->get();

        $totalPenjualan = $this->hitungTotal($produkList);

        return view('laporan.tpi', compact('produkList', 'totalPenjualan'));
    }

    public function tpiExport(Request $request)
    {
        abort_unless(Auth::user()->isTpi(), 403, 'Halaman ini khusus untuk role TPI.');

        return Excel::download(
            new TpiLaporanExport(Auth::id(), $request->tahun, $request->bulan),
            'laporan_lelang_tpi.xlsx'
        );
    }

    /**
     * ──────────────────────────────────────────────────────────
     * FITUR 2: Laporan untuk Dinas — bisa melihat laporan dari
     * seluruh TPI yang berada di bawah dinas tersebut, atau
     * memilih satu TPI tertentu saja.
     * Filter tersedia: Tahun, Bulan, TPI (khusus dinas).
     * ──────────────────────────────────────────────────────────
     */
    public function dinasIndex(Request $request)
    {
        $dinas = Auth::user();
        abort_unless($dinas->isDinas(), 403, 'Halaman ini khusus untuk role Dinas.');

        // Semua TPI di bawah dinas ini
        $tpiOptions = $dinas->tpiList()->orderBy('name')->get();
        $tpiIds     = $tpiOptions->pluck('id');

        // Jika dinas memilih TPI tertentu (dan itu benar-benar miliknya)
        if ($request->filled('tpi_id') && $tpiIds->contains((int) $request->tpi_id)) {
            $tpiIds = collect([(int) $request->tpi_id]);
        }

        $query = Produk::with([
                'tpi',
                'penawaran' => function ($q) {
                    $q->where('status', 'sudah')->with('user');
                },
            ])
            ->whereIn('tpi_id', $tpiIds)
            ->whereNotNull('waktu_selesai')
            ->whereHas('penawaran', function ($q) {
                $q->where('status', 'sudah');
            });

        $this->applyPeriodFilter($query, $request);

        $produkList = $query->orderBy('waktu_selesai', 'desc')->get();

        $totalPenjualan = $this->hitungTotal($produkList);

        return view('laporan.dinas', compact('produkList', 'totalPenjualan', 'tpiOptions'));
    }

    public function dinasExport(Request $request)
    {
        $dinas = Auth::user();
        abort_unless($dinas->isDinas(), 403, 'Halaman ini khusus untuk role Dinas.');

        $tpiIds = $dinas->tpiList()->pluck('id');

        if ($request->filled('tpi_id') && $tpiIds->contains((int) $request->tpi_id)) {
            $tpiIds = collect([(int) $request->tpi_id]);
        }

        return Excel::download(
            new DinasLaporanExport($tpiIds->toArray(), $request->tahun, $request->bulan),
            'laporan_lelang_dinas.xlsx'
        );
    }

    /**
     * Helper: terapkan filter periode (tahun & bulan) ke query,
     * baik dipakai sendiri-sendiri maupun kombinasi keduanya.
     */
    private function applyPeriodFilter($query, Request $request, string $column = 'waktu_selesai')
    {
        if ($request->filled('tahun') && $request->filled('bulan')) {
            $start = Carbon::create($request->tahun, $request->bulan, 1)->startOfMonth();
            $end   = Carbon::create($request->tahun, $request->bulan, 1)->endOfMonth();

            $query->whereBetween($column, [$start, $end]);
        } elseif ($request->filled('tahun')) {
            $query->whereYear($column, $request->tahun);
        } elseif ($request->filled('bulan')) {
            $query->whereMonth($column, $request->bulan);
        }

        return $query;
    }

    /**
     * Helper: hitung total penjualan dari koleksi produk
     * (menjumlahkan seluruh penawaran yang sudah dibayar).
     */
    private function hitungTotal($produkList)
    {
        return $produkList->reduce(function ($total, $produk) {
            return $total + $produk->penawaran->sum('jumlah_penawaran');
        }, 0);
    }
}
