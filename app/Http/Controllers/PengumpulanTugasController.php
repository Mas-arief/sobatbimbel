<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengumpulanTugasController extends Controller
{
    public function index()
    {
        // Logika untuk menampilkan halaman pengumpulan tugas
        // Misalnya, Anda bisa menampilkan daftar tugas yang bisa dikumpulkan oleh siswa
        // atau formulir untuk mengunggah tugas.
        return view('siswa.pengumpulan_tugas'); // Pastikan Anda memiliki view ini
    }
}
