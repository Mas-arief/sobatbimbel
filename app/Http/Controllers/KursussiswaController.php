<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class KursussiswaController extends Controller
{
    public function index()
    {
        $dataKursus = [
            'indo' => [
                1 => [
                    'materi' => 'Pengantar Bahasa Indonesia',
                    'materi_link' => '#',
                    'tugas' => 'Tugas 1: Membuat Paragraf',
                    'tugas_deskripsi' => ['Tulis paragraf naratif', 'Gunakan EYD yang benar']
                ],
                // dst...
            ],
            'inggris' => [
                // isi data minggu ke-1 sampai ke-16
            ],
            'mtk' => [
                // isi data minggu ke-1 sampai ke-16
            ],
        ];

        return view('siswa.kursus', compact('dataKursus'));
    }
}
