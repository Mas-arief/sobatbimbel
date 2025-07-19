<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use Illuminate\Support\Facades\Auth; // Mengimpor Facade Auth untuk mendapatkan pengguna yang sedang login

class ProfileeController extends Controller
{
    /**
     * Menampilkan halaman profil untuk siswa yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data pengguna yang sedang login.
        $user = Auth::user();
        // Mengambil peran (role) dari pengguna yang sedang login (misalnya 'siswa', 'guru', 'admin').
        $tipe = $user->role;

        // Mengembalikan view 'siswa.profile' dengan data pengguna dan tipe (peran).
        return view('siswa.profile', compact('user', 'tipe'));
    }

    /**
     * Memperbarui profil siswa yang sedang login.
     * Metode ini menangani pembaruan informasi profil siswa dari formulir.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data pembaruan profil.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Mengambil data pengguna yang sedang login.
        $user = Auth::user();

        // Proses validasi input dari permintaan.
        $validated = $request->validate([
            'edit_nama' => 'required|string|max:255', // Nama wajib, string, maks 255 karakter.
            'edit_alamat' => 'nullable|string', // Alamat opsional, string.
            'edit_jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan', // Jenis kelamin opsional, hanya boleh 'Laki-laki' atau 'Perempuan'.
            'edit_telepon' => 'nullable|string|max:20', // Telepon opsional, string, maks 20 karakter.
            'edit_email' => 'required|email|unique:users,email,' . $user->id, // Email wajib, format email, dan harus unik kecuali untuk ID pengguna ini sendiri.
        ]);

        // Menyimpan perubahan ke database.
        // Menggunakan metode update() pada instance model User untuk memperbarui atribut.
        /** @var \App\Models\User $user */
        $user->update([
            'name' => $validated['edit_nama'], // Memperbarui nama.
            'alamat' => $validated['edit_alamat'], // Memperbarui alamat.
            'jenis_kelamin' => $validated['edit_jenis_kelamin'], // Memperbarui jenis kelamin.
            'telepon' => $validated['edit_telepon'], // Memperbarui nomor telepon.
            'email' => $validated['edit_email'], // Memperbarui email.
        ]);

        // Mengarahkan kembali ke halaman profil siswa dengan pesan sukses.
        return redirect()->route('siswa.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
