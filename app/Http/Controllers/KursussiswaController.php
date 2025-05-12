<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class KursussiswaController extends Controller
{
    public function index(): View
    {
        // Opsi 1: Menggunakan Array Statis
        $dataKursus = [
            'indo' => [
                1 => [
                    'materi' => '[PDF] Materi Bahasa Indonesia Minggu 1',
                    'materi_link' => '#',
                    'tugas' => 'Tugas Bahasa Indonesia Minggu 1',
                    'tugas_deskripsi' => ['Contoh kalimat...', 'Jelaskan perbedaan antara...'],
                    'link_pengumpulan' => 'admin/modal_pengumpulan_tugas?minggu=1&mapel=indo',
                ],
                // ... data untuk minggu lainnya
            ],
            'inggris' => [
                // ...
            ],
            'mtk' => [
                // ...
            ],
        ];

        // Opsi 2: Menggunakan File Konfigurasi
        // $dataKursus = Config::get('kursus');

        // Opsi 3: Menggunakan File JSON
        // $jsonData = File::get(base_path('data/kursus.json'));
        // $dataKursus = json_decode($jsonData, true);

        return view('kursus.index', ['dataKursus' => $dataKursus]); // Pastikan ini ada
    }
}
