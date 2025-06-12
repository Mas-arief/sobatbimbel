<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Tugas;

class TugasController extends Controller
{
    public function index()
    {
        // Ambil semua data tugas dan siswa yang mengumpulkan
        $tugas = Tugas::with('siswa')->latest()->get();

        return view('guru.pengumpulan', [
            'tugas' => $tugas,
            'tipe' => 'guru' // untuk navbar
        ]);
    }

    public function edit($id)
    {
        $tugas = Tugas::with('siswa')->findOrFail($id);

        return view('guru.tugas.edit', [
            'tugas' => $tugas,
            'tipe' => 'guru'
        ]);
    }
}
