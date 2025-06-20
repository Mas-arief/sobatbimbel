<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapel = [
            [
                'id' => 1,
                'nama_mapel' => 'Bahasa Indonesia',
                'kode_mapel' => 'INDO',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia'
            ],
            [
                'id' => 2,
                'nama_mapel' => 'Bahasa Inggris',
                'kode_mapel' => 'ENG',
                'deskripsi' => 'Mata pelajaran Bahasa Inggris'
            ],
            [
                'id' => 3,
                'nama_mapel' => 'Matematika',
                'kode_mapel' => 'MTK',
                'deskripsi' => 'Mata pelajaran Matematika'
            ]
        ];

        foreach ($mapel as $data) {
            Mapel::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
        }
    }
}
