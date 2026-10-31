<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of all users (Admin only).
     */
    public function index(Request $request): View|RedirectResponse
    {
        $currentUser = Auth::user();

        // Enforce admin access
        if (! $currentUser || $currentUser->role !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak: Menu Data User hanya dapat diakses oleh Administrator.');
        }

        $query = User::with('workspace');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest('id')->get();

        $totalUsers = User::count();
        $totalAdmin = User::where('role', 'admin')->count();
        $totalUserBiasa = User::whereIn('role', ['operator', 'farm_manager', 'pakar'])->count();
        $totalAktif = User::where('is_active', true)->count();

        return view('users.index', compact(
            'users',
            'totalUsers',
            'totalAdmin',
            'totalUserBiasa',
            'totalAktif',
            'currentUser'
        ));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $currentUser = Auth::user();
        if (! $currentUser || $currentUser->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,farm_manager,pakar,operator'],
        ], [
            'nama.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar dalam sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'role.required' => 'Pilih peran pengguna.',
        ]);

        $workspace = Workspace::first();

        User::create([
            'workspace_id' => $workspace->id ?? 1,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->route('users.index')
            ->with('success', "Pengguna {$validated['nama']} berhasil ditambahkan.");
    }

    /**
     * Toggle active status of a user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        $currentUser = Auth::user();
        if (! $currentUser || $currentUser->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        if ($user->id === $currentUser->id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->nama} berhasil {$statusText}.");
    }
}
