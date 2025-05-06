<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $dataGuru = [
            [
                'id' => '001',
                'nama' => 'Nama Guru',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '01-01-1980',
                'jk' => 'L',
                'mapel' => 'Matematika',
                'email' => 'guru1@example.com',
            ],
            [
                'id' => '002',
                'nama' => 'Nama Guru',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '02-02-1985',
                'jk' => 'P',
                'mapel' => 'Bahasa Inggris',
                'email' => 'guru2@example.com',
            ],
            [
                'id' => '003',
                'nama' => 'Nama Guru',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '03-03-1990',
                'jk' => 'L',
                'mapel' => 'IPA',
                'email' => 'guru3@example.com',
            ],
        ];

        return view('profile_guru', compact('dataGuru'));
    }
}
