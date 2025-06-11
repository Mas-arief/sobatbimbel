<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('username', 'admin')->doesntExist()) {
            User::create([
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(), // Opsional, tambahkan jika Anda ingin email juga terverifikasi
                'is_verified' => true,      // <-- PENTING: Set ini menjadi TRUE untuk admin
            ]);
            $this->command->info('Akun admin berhasil dibuat dan diverifikasi secara otomatis!');
        } else {
            $this->command->info('Akun admin sudah ada.');
        }
    }
}
