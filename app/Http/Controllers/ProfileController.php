<?php

namespace App\Http\Controllers;

use App\Models\User; // Mengimpor model User untuk berinteraksi dengan data pengguna
use App\Models\Mapel; // Pastikan Anda mengimpor model Mapel untuk daftar mata pelajaran

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use Illuminate\Support\Facades\Auth; // Mengimpor Facade Auth untuk mendapatkan pengguna yang sedang login

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna yang sedang login.
     * Metode ini dirancang untuk menampilkan detail profil guru atau siswa yang sedang terautentikasi.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile() // Jika ini profil user yang sedang login
    {
        // Mendapatkan instance pengguna yang sedang login.
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika Anda ingin menampilkan profil guru lain berdasarkan ID, ubah seperti ini:
        // public function showProfile($id) {
        //     $user = User::with('mapel')->findOrFail($id); // Mengambil user berdasarkan ID dan memuat relasi mapel.
        // }

        // Memastikan relasi 'mapel' dimuat (eager loading) jika pengguna memiliki mapel terkait.
        // Ini mencegah masalah N+1 query jika Anda mengakses $user->mapel di view.
        $user->load('mapel');

        // Mengambil daftar semua mata pelajaran dari database.
        // Ini biasanya digunakan untuk dropdown di formulir atau modal untuk memilih mata pelajaran.
        $mapelList = Mapel::all();
        // Menentukan tipe pengguna berdasarkan peran (role) dari user yang sedang login.
        $tipe = $user->role;
        // Meneruskan variabel $user, $mapelList, dan $tipe ke view 'guru.profile'.
        return view('guru.profile', compact('user', 'mapelList', 'tipe'));
    }

    /**
     * Memperbarui profil pengguna.
     * Metode ini menangani pembaruan informasi profil pengguna (nama, alamat, mapel_id, dll.).
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data pembaruan profil.
     * @param  int  $id ID pengguna yang profilnya akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request, $id)
    {
        // Validasi data yang diterima dari permintaan.
        $request->validate([
            'name' => 'required|string|max:255', // Nama wajib, string, maks 255 karakter.
            'alamat' => 'nullable|string|max:255', // Alamat opsional, string, maks 255 karakter.
            'mapel_id' => 'nullable|exists:mapel,id', // mapel_id opsional, dan jika ada, harus ada di tabel 'mapel'.
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan', // Jenis kelamin opsional, hanya boleh 'Laki-laki' atau 'Perempuan'.
            'telepon' => 'nullable|string|max:20', // Telepon opsional, string, maks 20 karakter.
            'email' => 'required|email|unique:users,email,' . $id, // Email wajib, format email, dan harus unik kecuali untuk ID pengguna ini sendiri.
        ]);

        // Mencari pengguna berdasarkan ID. Jika tidak ditemukan, akan melempar 404.
        $user = User::findOrFail($id);
        // Memperbarui atribut-atribut pengguna dengan data dari permintaan.
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->mapel_id = $request->mapel_id; // Menyimpan mapel_id yang dipilih.
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->telepon = $request->telepon;
        $user->email = $request->email;
        // Menyimpan perubahan ke database.
        $user->save();

        // Mengarahkan kembali ke halaman sebelumnya dengan pesan sukses.
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
