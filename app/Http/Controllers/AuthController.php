<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the application login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login', ['initialMode' => 'login']);
    }

    /**
     * Show the application registration form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.login', ['initialMode' => 'register']);
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $workspace = Workspace::first();

        $user = User::create([
            'workspace_id' => $workspace->id ?? 1,
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            'role' => 'operator',
            'is_active' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', "Pendaftaran berhasil! Selamat datang di AXION, {$user->nama}.");
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun Anda berstatus nonaktif. Silakan hubungi Administrator.',
                ])->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            $roleLabel = $user->role === 'admin' ? 'Administrator' : 'Peternak / User';

            return redirect()->intended(route('dashboard'))
                ->with('success', "Selamat datang kembali, {$user->nama}! Masuk sebagai {$roleLabel}.");
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Quick login helper for demo / testing role switching.
     */
    public function quickLogin(string $role, Request $request): RedirectResponse
    {
        $targetUser = match ($role) {
            'admin' => User::where('role', 'admin')->first(),
            'user', 'operator' => User::where('role', 'operator')->first() ?? User::where('role', 'farm_manager')->first(),
            'manager', 'farm_manager' => User::where('role', 'farm_manager')->first(),
            default => null,
        };

        if (! $targetUser) {
            return redirect()->route('login')->withErrors(['email' => "Akun demo untuk peran {$role} tidak ditemukan."]);
        }

        Auth::login($targetUser);
        $request->session()->regenerate();

        $roleLabel = $targetUser->role === 'admin' ? 'Administrator' : 'Peternak / User';

        return redirect()->route('dashboard')
            ->with('success', "Berhasil masuk sebagai {$roleLabel} ({$targetUser->nama})");
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem AXION.');
    }
}
