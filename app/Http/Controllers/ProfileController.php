<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting: Import Auth
use Illuminate\Validation\Rule; // Penting: Import Rule untuk validasi unique

class ProfileController extends Controller
{
    /**
     * Menampilkan dashboard untuk guru (opsional, jika ada dashboard terpisah).
     */
    public function dashboard()
    {
        return view('guru.profile'); // Pastikan Anda memiliki view ini
    }

    /**
     * Menampilkan profil guru yang sedang login.
     */
    public function showProfile()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        // Pastikan Anda mempassing objek $user, bukan array hardcode
        return view('guru.profile', compact('user'));
    }

    /**
     * Memperbarui profil guru (Hanya untuk field yang boleh diubah guru).
     * guru_mata_pelajaran TIDAK DIUBAH DI SINI.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'alamat' => ['nullable', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'telepon' => ['nullable', 'string', 'max:20'],
            // guru_mata_pelajaran TIDAK ADA DI SINI
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('guru.profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
