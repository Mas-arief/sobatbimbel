<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileeController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Ambil data user yang sedang login
        $tipe = $user->role;  // Ambil role (siswa/guru/admin)

        return view('siswa.profile', compact('user', 'tipe'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Proses validasi input
        $validated = $request->validate([
            'edit_nama' => 'required|string|max:255',
            'edit_alamat' => 'nullable|string',
            'edit_jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'edit_telepon' => 'nullable|string|max:20',
            'edit_email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Simpan perubahan ke database
        $user->update([
            'name' => $validated['edit_nama'],
            'alamat' => $validated['edit_alamat'],
            'jenis_kelamin' => $validated['edit_jenis_kelamin'],
            'telepon' => $validated['edit_telepon'],
            'email' => $validated['edit_email'],
        ]);

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('siswa.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
