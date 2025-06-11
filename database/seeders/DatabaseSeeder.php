<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserSeeder::class, // Memastikan AdminUserSeeder dipanggil
            // Jika Anda memiliki seeder lain (misalnya StudentSeeder, TeacherSeeder),
            // pastikan untuk menambahkannya di sini juga:
            // StudentSeeder::class,
            // TeacherSeeder::class,
        ]);
    }
}
