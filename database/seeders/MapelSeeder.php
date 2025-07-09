<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Mengimpor trait ini, meskipun tidak digunakan dalam seeder ini
use Illuminate\Database\Seeder; // Mengimpor kelas dasar Seeder
use Illuminate\Support\Facades\DB; // Mengimpor Facade DB untuk interaksi langsung dengan database

class MapelSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     * Metode ini akan memasukkan data mata pelajaran ke dalam tabel 'mapel'.
     *
     * @return void
     */
    public function run(): void
    {
        // Data mata pelajaran yang ingin Anda masukkan ke tabel 'mapel'.
        // Setiap elemen array adalah baris yang akan dimasukkan ke tabel.
        $mapels = [
            ['nama' => 'Bahasa Indonesia'],
            ['nama' => 'Bahasa Inggris'],
            ['nama' => 'Matematika'],
            // Tambahkan mata pelajaran lain jika diperlukan di sini.
        ];

        // Melakukan iterasi pada setiap data mata pelajaran yang telah didefinisikan.
        foreach ($mapels as $mapel) {
            // Menggunakan DB::table('mapel')->insertOrIgnore($mapel);
            // Metode `insertOrIgnore` akan mencoba memasukkan baris data.
            // Jika ada kendala unik (misalnya, jika Anda memiliki constraint UNIQUE pada kolom 'nama'
            // dan nama tersebut sudah ada), maka baris tersebut akan diabaikan (tidak akan dimasukkan).
            // Ini membantu menghindari duplikasi data saat seeder dijalankan berkali-kali.
            DB::table('mapel')->insertOrIgnore($mapel);
        }
    }
}
