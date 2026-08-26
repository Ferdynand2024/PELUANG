<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TpiController extends Controller
{
    public function create()
    {
        return view('tpi.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'phone'     => 'nullable|string|max:20',
            'alamat'    => 'nullable|string',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $request->user();
        $dinasId = ($user && $user->isDinas()) ? $user->id : $request->dinas_id;

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'alamat'    => $request->alamat,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'role'      => 'tpi',
            'dinas_id'  => $dinasId,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('tpi.index')->with('success', 'TPI berhasil ditambahkan.');
    }

    public function index()
    {
        $users = User::where('role', 'tpi')->get();
        return view('tpi.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('tpi.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'     => 'nullable|string|max:20',
            'alamat'    => 'nullable|string',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name      = $request->name;
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        $user->alamat    = $request->alamat;
        $user->latitude  = $request->latitude;
        $user->longitude = $request->longitude;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('tpi.index')->with('success', 'TPI berhasil diperbarui.');
    }

    public function toggleStatus(User $user)
    {
        $user->status = !$user->status;
        $user->save();

        return redirect()->route('tpi.index')->with('success', 'Status TPI berhasil diubah.');
    }

    /**
     * Halaman publik pencarian TPI terdekat (tanpa login).
     */
    public function cariTerdekat()
    {
        return view('tpi.cari-terdekat');
    }

    /**
     * Endpoint JSON pencarian TPI terdekat menggunakan rumus Haversine di query MySQL.
     * FITUR BARU: setiap TPI juga menyertakan `lelang_aktif_count` — jumlah produk
     * dengan status_lelang = 'dibuka' milik TPI tersebut, dipakai untuk badge
     * "Lelang Aktif" dan tombol "Lihat Lelang" di halaman cari-tpi.
     */
    public function getTerdekatJson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Koordinat latitude atau longitude tidak valid.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $lat = (float) $request->latitude;
        $lng = (float) $request->longitude;

        $tpiList = User::query()
            ->where('role', 'tpi')
            ->where('status', 1)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            // FITUR BARU: hitung produk yang sedang dilelang (status_lelang = dibuka)
            // per TPI. Relasi 'produk' didefinisikan di model User (hasMany ke Produk,
            // foreign key tpi_id) — lihat catatan di bawah kalau belum ada.
            ->withCount(['produk as lelang_aktif_count' => function ($q) {
                $q->where('status_lelang', 'dibuka');
            }])
            ->selectRaw("
                id, name, email, phone, alamat, latitude, longitude, status,
                (6371 * acos(
                    LEAST(1.0, GREATEST(-1.0,
                        cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?))
                        + sin(radians(?)) * sin(radians(latitude))
                    ))
                )) AS jarak
            ", [$lat, $lng, $lat])
            ->orderBy('jarak', 'asc')
            ->get()
            ->map(function ($tpi) {
                return [
                    'id'                 => $tpi->id,
                    'name'               => $tpi->name,
                    'email'              => $tpi->email,
                    'phone'              => $tpi->phone,
                    'alamat'             => $tpi->alamat,
                    'latitude'           => (float) $tpi->latitude,
                    'longitude'          => (float) $tpi->longitude,
                    'jarak_km'           => round($tpi->jarak, 2),
                    'lelang_aktif_count' => (int) $tpi->lelang_aktif_count,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data'   => $tpiList,
        ]);
    }
}