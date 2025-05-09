<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarHadirController extends Controller
{
    public function index()
    {
        $tipe = 'siswa'; // Atau logika lain untuk menentukan tipe pengguna
        return view('siswa.daftar_hadir', compact('tipe'));
    }
}
