<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data mata pelajaran yang ingin Anda masukkan
        $mapels = [
            ['nama' => 'Bahasa Indonesia'],
            ['nama' => 'Bahasa Inggris'],
            ['nama' => 'Matematika'],
            // Tambahkan mata pelajaran lain jika diperlukan
        ];

        foreach ($mapels as $mapel) {
            // Memeriksa apakah mapel sudah ada untuk menghindari duplikasi
            // Anda bisa menggunakan findOrCreate atau updateOrCreate jika model Mapel sudah ada
            // Atau cukup insert jika Anda yakin tabel kosong atau ingin duplikasi
            DB::table('mapel')->insertOrIgnore($mapel);
        }
    }
}
