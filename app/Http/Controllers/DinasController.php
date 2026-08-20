<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DinasController extends Controller
{
    // ── Dinas management (hanya admin) ───────────────────────────

    public function index()
    {
        $dinas = User::where('role', 'dinas')
            ->withCount(['tpiList as jumlah_tpi'])
            ->latest()
            ->paginate(15);

        return view('dinas.index', compact('dinas'));
    }

    public function create()
    {
        return view('dinas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'alamat'   => $request->alamat,
            'role'     => 'dinas',
            'status'   => 1,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dinas.index')
            ->with('success', 'Akun dinas berhasil dibuat.');
    }

    public function edit(User $dinas)
    {
        abort_if($dinas->role !== 'dinas', 404);
        return view('dinas.edit', compact('dinas'));
    }

    public function update(Request $request, User $dinas)
    {
        abort_if($dinas->role !== 'dinas', 404);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'email', Rule::unique('users')->ignore($dinas->id)],
            'phone'  => 'nullable|numeric|max:20',
            'alamat' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'alamat']);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $dinas->update($data);

        return redirect()->route('dinas.index')
            ->with('success', 'Data dinas berhasil diperbarui.');
    }

    public function toggleStatus(User $dinas)
    {
        abort_if($dinas->role !== 'dinas', 404);
        $dinas->update(['status' => !$dinas->status]);

        return back()->with('success', 'Status dinas berhasil diubah.');
    }

    // ── TPI management (admin lihat semua, dinas lihat miliknya) ─

    public function tpiIndex(Request $request)
    {
        $user = $request->user();

        $query = User::where('role', 'tpi')->with('dinas');

        // Dinas hanya lihat TPI miliknya
        if ($user->isDinas()) {
            $query->where('dinas_id', $user->id);
        }

        $tpiList = $query->latest()->paginate(15);

        return view('dinas.tpi-index', compact('tpiList'));
    }

    public function tpiCreate()
    {
        $dinas = User::where('role', 'dinas')->where('status', 1)->get();
        return view('dinas.tpi-create', compact('dinas'));
    }

    public function tpiStore(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|string|max:20',
            'alamat'    => 'nullable|string',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'password'  => 'required|string|min:8|confirmed',
            'dinas_id'  => 'required_if:role,admin|nullable|exists:users,id',
        ]);

        // Jika yang membuat adalah dinas, paksa dinas_id = id mereka sendiri
        $dinasId = $user->isDinas() ? $user->id : $request->dinas_id;

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'alamat'    => $request->alamat,
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
            'role'      => 'tpi',
            'dinas_id'  => $dinasId,
            'status'    => 1,
            'password'  => Hash::make($request->password),
        ]);

        return redirect()->route('tpi.index')
            ->with('success', 'Akun TPI berhasil dibuat.');
    }

    public function tpiEdit(User $tpi)
    {
        abort_if($tpi->role !== 'tpi', 404);

        $user = auth()->user();

        // Dinas hanya bisa edit TPI miliknya
        if ($user->isDinas() && $tpi->dinas_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke TPI ini.');
        }

        $dinas = User::where('role', 'dinas')->where('status', 1)->get();

        return view('dinas.tpi-edit', compact('tpi', 'dinas'));
    }

    public function tpiUpdate(Request $request, User $tpi)
    {
        abort_if($tpi->role !== 'tpi', 404);

        $user = $request->user();

        // Dinas hanya bisa update TPI miliknya
        if ($user->isDinas() && $tpi->dinas_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke TPI ini.');
        }

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'email', Rule::unique('users')->ignore($tpi->id)],
            'phone'     => 'nullable|string|max:20',
            'alamat'    => 'nullable|string',
            'latitude'  => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'alamat', 'latitude', 'longitude']);

        // Hanya admin yang bisa pindah TPI ke dinas lain
        if ($user->isAdmin() && $request->filled('dinas_id')) {
            $data['dinas_id'] = $request->dinas_id;
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $tpi->update($data);

        return redirect()->route('tpi.index')   // ← FIXED
            ->with('success', 'Data TPI berhasil diperbarui.');
    }

    public function tpiToggleStatus(User $tpi)
    {
        abort_if($tpi->role !== 'tpi', 404);

        $user = auth()->user();

        if ($user->isDinas() && $tpi->dinas_id !== $user->id) {
            abort(403);
        }

        $tpi->update(['status' => !$tpi->status]);

        return back()->with('success', 'Status TPI berhasil diubah.');
    }
}