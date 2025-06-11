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
        // Jika dashboard guru sama dengan profil, bisa langsung redirect atau panggil showProfile
        return $this->showProfile();
    }

    /**
     * Menampilkan profil guru yang sedang login.
     */
    public function showProfile()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $tipe = $user->role; // Mendefinisikan $tipe agar tidak ada error compact()
        return view('guru.profile', compact('user', 'tipe'));
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
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])], // Sesuaikan dengan nilai di DB
            'telepon' => ['nullable', 'string', 'max:20'],
            // 'mapel' (guru_mata_pelajaran) tidak divalidasi atau diupdate di sini, sesuai permintaan.
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'telepon' => $request->telepon,
        ]);

        // Pastikan 'guru.profile' adalah nama route yang benar ke showProfile
        return redirect()->route('guru.profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
