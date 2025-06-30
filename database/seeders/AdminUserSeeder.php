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
                'name' => 'Administrator', // <-- TAMBAHKAN BARIS INI
                'email' => 'admin@example.com',
                'password' => Hash::make('admin1234'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_verified' => true,
            ]);
            $this->command->info('Akun admin berhasil dibuat dan diverifikasi secara otomatis!');
        } else {
            $this->command->info('Akun admin sudah ada.');
        }
    }
}
