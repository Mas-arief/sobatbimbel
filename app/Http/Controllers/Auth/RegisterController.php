<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Mengimpor model User untuk berinteraksi dengan tabel users
use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use Illuminate\Support\Facades\Hash; // Mengimpor Facade Hash untuk mengenkripsi password
use Illuminate\Support\Facades\Validator; // Mengimpor Facade Validator untuk validasi data
use Illuminate\Validation\Rule; // Mengimpor kelas Rule untuk aturan validasi kustom (seperti in)

class RegisterController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Mengembalikan view 'daftar' yang berisi formulir pendaftaran pengguna baru.
        // View ini diharapkan berada di direktori 'resources/views/daftar.blade.php'.
        return view('daftar');
    }

    /**
     * Menangani permintaan registrasi pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Memvalidasi data yang diterima dari permintaan menggunakan metode validator().
        // Jika validasi gagal, secara otomatis akan melempar ValidationException dan mengarahkan kembali.
        $this->validator($request->all())->validate();

        // Membuat entri pengguna baru di database menggunakan data yang sudah divalidasi.
        // Metode create() akan memanggil model User untuk menyimpan data.
        $this->create($request->all());

        // Mengarahkan pengguna ke halaman login setelah pendaftaran berhasil.
        // Menambahkan pesan 'success' ke sesi yang akan tersedia di permintaan berikutnya (flash message).
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda akan diverifikasi oleh admin.');
    }

    /**
     * Memvalidasi data registrasi yang diberikan.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Membuat instance validator dengan aturan validasi yang ditentukan.
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'], // Username wajib, string, maks 255 karakter, dan harus unik di tabel 'users'.
            'name' => ['required', 'string', 'max:255'], // Nama wajib, string, maks 255 karakter.
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Email wajib, string, format email, maks 255 karakter, dan harus unik.
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Password wajib, string, minimal 8 karakter, dan harus cocok dengan field 'password_confirmation'.
            'role' => ['required', 'string', Rule::in(['siswa', 'guru'])], // Role wajib, string, dan hanya boleh 'siswa' atau 'guru' (admin tidak bisa daftar manual).
            'alamat' => ['nullable', 'string', 'max:255'], // Alamat opsional, string, maks 255 karakter.
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])], // Jenis kelamin opsional, hanya boleh 'Laki-laki' atau 'Perempuan'.
            'telepon' => ['nullable', 'string', 'max:20'], // Telepon opsional, string, maks 20 karakter.
        ]);
    }

    /**
     * Membuat instance user baru setelah validasi berhasil.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Membuat record baru di tabel 'users' dengan data yang sudah divalidasi.
        return User::create([
            'username' => $data['username'], // Mengambil username dari data.
            'name' => $data['name'], // Mengambil nama dari data.
            'email' => $data['email'], // Mengambil email dari data.
            'password' => Hash::make($data['password']), // Mengenkripsi password sebelum disimpan ke database.
            'role' => $data['role'], // Mengambil role dari data.
            'alamat' => $data['alamat'] ?? null, // Mengambil alamat, jika tidak ada akan null.
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null, // Mengambil jenis kelamin, jika tidak ada akan null.
            'telepon' => $data['telepon'] ?? null, // Mengambil telepon, jika tidak ada akan null.
            'is_verified' => false, // Secara default, akun baru belum diverifikasi oleh admin.
            'mapel_id' => null, // Field ini akan diisi oleh admin nanti, terutama untuk guru.
        ]);
    }
}
