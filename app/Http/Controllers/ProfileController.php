<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Menampilkan profil
    public function show()
    {
        // Tentukan tipe pengguna (guru)
        $tipe = 'guru';

        // Data pengguna yang di-hardcode (bisa diganti dengan data dari session atau API)
        $user = [
            'id' => '12345',
            'nama' => 'John Doe',
            'guru_mata_pelajaran' => 'Matematika',
            'jenis_kelamin' => 'Laki-laki',
            'telepon' => '08123456789',
            'email' => 'johndoe@example.com',
        ];

        // Kirimkan data profil dan tipe pengguna ke view
        return view('guru.profile', compact('user', 'tipe'));
    }

    // Memperbarui profil (tidak disimpan di database, hanya validasi form)
    public function update(Request $request)
    {
        // Validasi input form
        $request->validate([
            'nama' => 'required|string|max:255',
            'guru_mata_pelajaran' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        // Biasanya, data profil yang diperbarui akan disimpan di sini, tetapi sekarang hanya mensimulasikan pembaruan

        return redirect()->route('guru.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
