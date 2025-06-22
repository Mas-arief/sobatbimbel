<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Sudah Anda tambahkan, bagus!

class KursussiswaController extends Controller
{
    public function index()
    {
        // Mendapatkan semua mata pelajaran yang ada di database
        $allMapels = Mapel::all();

        // Ambil semua tugas dan materi dengan relasi mapel
        // Pastikan kolom 'mapel_id' di tabel 'tugas' dan 'materis' sudah benar
        $allTugas = Tugas::with('mapel')->get();
        $allMateri = Materi::with('mapel')->get();

        // --- DEBUGGING POINT 1 ---
        // Log::info('All Tugas:', $allTugas->toArray());
        // Log::info('All Materi:', $allMateri->toArray());

        // Inisialisasi struktur data dasar untuk 16 minggu dan 3 mata pelajaran
        // Ini memastikan setiap minggu dan setiap mapel memiliki array 'materi' dan 'tugas' yang kosong secara default.
        $kursusData = [
            'indo' => [],
            'inggris' => [],
            'mtk' => [],
        ];

        // Inisialisasi 16 minggu untuk setiap mata pelajaran
        foreach (['indo', 'inggris', 'mtk'] as $mapelSlug) {
            for ($i = 1; $i <= 16; $i++) {
                $kursusData[$mapelSlug][$i] = [
                    'materi' => [],
                    'tugas' => [],
                ];
            }
        }

        // Organisasikan Tugas berdasarkan mapel dan minggu
        foreach ($allTugas as $tugas) {
            $mapelSlug = '';
            if ($tugas->mapel) {
                $namaMapel = strtolower($tugas->mapel->nama);
                if ($namaMapel === 'bahasa indonesia') {
                    $mapelSlug = 'indo';
                } elseif ($namaMapel === 'bahasa inggris') {
                    $mapelSlug = 'inggris';
                } elseif ($namaMapel === 'matematika') {
                    $mapelSlug = 'mtk';
                }
            }

            if ($mapelSlug && isset($kursusData[$mapelSlug][$tugas->minggu])) {
                $kursusData[$mapelSlug][$tugas->minggu]['tugas'][] = [
                    'id' => $tugas->id,
                    'judul' => $tugas->judul,
                    'file_url' => Storage::url($tugas->file_path),
                    'deadline' => $tugas->deadline,
                ];
            } else {
                Log::warning("Tugas dengan ID {$tugas->id} memiliki mapel yang tidak dikenal atau minggu ({$tugas->minggu}) di luar jangkauan (1-16).");
            }
        }

        // Organisasikan Materi berdasarkan mapel dan minggu
        foreach ($allMateri as $materi) {
            $mapelSlug = '';
            if ($materi->mapel) {
                $namaMapel = strtolower($materi->mapel->nama);
                if ($namaMapel === 'bahasa indonesia') {
                    $mapelSlug = 'indo';
                } elseif ($namaMapel === 'bahasa inggris') {
                    $mapelSlug = 'inggris';
                } elseif ($namaMapel === 'matematika') {
                    $mapelSlug = 'mtk';
                }
            }

            if ($mapelSlug && isset($kursusData[$mapelSlug][$materi->minggu_ke])) {
                // Pastikan nama kolom di materi adalah 'file_materi'
                $kursusData[$mapelSlug][$materi->minggu_ke]['materi'][] = [
                    'id' => $materi->id,
                    'judul' => $materi->judul_materi,
                    'file_url' => Storage::url($materi->file_materi),
                ];
            } else {
                Log::warning("Materi dengan ID {$materi->id} memiliki mapel yang tidak dikenal atau minggu ({$materi->minggu_ke}) di luar jangkauan (1-16).");
            }
        }

        // --- DEBUGGING POINT 2 ---
        // Log::info('Final Kursus Data:', $kursusData); // Log data akhir

        // Encode data agar bisa digunakan oleh Alpine.js
        $jsonDataKursus = json_encode($kursusData);
        $tipe = 'siswa';
        return view('siswa.kursus', compact('jsonDataKursus', 'tipe'));
    }
}
