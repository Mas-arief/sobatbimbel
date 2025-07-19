<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // Mengimpor kelas dasar Seeder
use App\Models\User; // Mengimpor model User untuk membuat data pengguna
use Illuminate\Support\Facades\Hash; // Mengimpor Facade Hash untuk mengenkripsi password

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     * Metode ini akan membuat akun admin jika belum ada di database.
     *
     * @return void
     */
    public function run()
    {
        // Memeriksa apakah akun admin dengan username 'admin' sudah ada di database.
        // `doesntExist()` akan mengembalikan true jika tidak ada record yang cocok.
        if (User::where('username', 'admin')->doesntExist()) {
            // Jika akun admin belum ada, buat akun baru.
            User::create([
                'username' => 'admin',           // Username untuk login
                'name' => 'Administrator',       // Nama lengkap admin
                'email' => 'admin@example.com',  // Alamat email admin
                'password' => Hash::make('admin1234'), // Password yang di-hash
                'role' => 'admin',               // Peran pengguna sebagai 'admin'
                'email_verified_at' => now(),    // Menetapkan waktu verifikasi email ke waktu saat ini
                'is_verified' => true,           // Menetapkan status verifikasi menjadi true secara otomatis
            ]);
            // Menampilkan pesan informasi di konsol Artisan bahwa akun admin berhasil dibuat.
            $this->command->info('Akun admin berhasil dibuat dan diverifikasi secara otomatis!');
        } else {
            // Menampilkan pesan informasi di konsol Artisan bahwa akun admin sudah ada.
            $this->command->info('Akun admin sudah ada.');
        }
    }
}
