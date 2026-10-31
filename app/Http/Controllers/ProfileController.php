<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil pengguna.
     */
    public function index(): View
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        return view('profile.index', compact('currentUser'));
    }

    /**
     * Perbarui data profil dan/atau foto profil.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:120', 'unique:users,email,'.$user->id],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email sudah digunakan oleh pengguna lain.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];

        // Proses unggah foto baru jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'avatar_'.$user->id.'_'.time().'.'.$file->getClientOriginalExtension();

            // Hapus foto lama jika ada
            if ($user->foto && File::exists(public_path('uploads/avatars/'.$user->foto))) {
                File::delete(public_path('uploads/avatars/'.$user->foto));
            }

            $file->move(public_path('uploads/avatars'), $filename);
            $user->foto = $filename;
        }

        // Perbarui password jika diisi
        if (! empty($validated['password'])) {
            $user->password_hash = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil dan foto berhasil diperbarui!');
    }

    /**
     * Hapus foto profil dan kembali menggunakan avatar inisial.
     */
    public function destroyPhoto(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->foto && File::exists(public_path('uploads/avatars/'.$user->foto))) {
            File::delete(public_path('uploads/avatars/'.$user->foto));
        }

        $user->foto = null;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil dihapus.');
    }
}
