<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        $dataSiswa = [
            [
                'id' => '001',
                'nama' => 'Budi Santoso',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2006-03-15',
                'jenis_kelamin' => 'Laki-Laki',
                'alamat' => 'Jl. Kenanga No. 10',
                'email' => 'budi.s@example.com',
            ],
            [
                'id' => '002',
                'nama' => 'Siti Aminah',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2005-11-20',
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Gg. Mawar No. 5',
                'email' => 'siti.a@example.com',
            ],
            [
                'id' => '003',
                'nama' => 'Rizky Pratama',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2007-01-05',
                'jenis_kelamin' => 'Laki-Laki',
                'alamat' => 'Jl. Anggrek No. 123',
                'email' => 'rizky.p@example.com',
            ],
            // Tambahkan data siswa lainnya di sini
        ];

        return view('siswa.index', compact('dataSiswa'));
    }

    // ...
}
