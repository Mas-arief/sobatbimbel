<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request (meskipun tidak digunakan langsung di metode index ini)
use App\Models\Mapel; // Mengimpor model Mapel untuk berinteraksi dengan data mata pelajaran
use App\Models\Materi; // Mengimpor model Materi untuk berinteraksi dengan data materi pelajaran
use App\Models\Tugas;  // Mengimpor model Tugas untuk berinteraksi dengan data tugas
use Illuminate\Support\Facades\Storage; // Mengimpor Facade Storage untuk mengelola file yang disimpan
use Illuminate\Support\Facades\Log; // Mengimpor Facade Log untuk keperluan debugging

class KursussiswaController extends Controller
{
    /**
     * Menampilkan halaman kursus untuk siswa.
     * Halaman ini akan menampilkan materi dan tugas yang terorganisir per mata pelajaran dan per minggu.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mendapatkan semua mata pelajaran yang ada di database.
        $allMapels = Mapel::all();

        // Mengambil semua tugas dan materi dari database, dengan eager loading relasi 'mapel'.
        // Pastikan kolom 'mapel_id' di tabel 'tugas' dan 'materis' sudah benar dan relasi sudah didefinisikan.
        $allTugas = Tugas::with('mapel')->get();
        $allMateri = Materi::with('mapel')->get();

        // --- DEBUGGING POINT 1 ---
        // Baris-baris ini dapat diaktifkan untuk melihat isi dari $allTugas dan $allMateri di log Laravel.
        // Log::info('All Tugas:', $allTugas->toArray());
        // Log::info('All Materi:', $allMateri->toArray());

        // Inisialisasi struktur data dasar untuk 16 minggu dan 3 mata pelajaran utama (Indonesia, Inggris, Matematika).
        // Ini memastikan setiap minggu dan setiap mapel memiliki array 'materi' dan 'tugas' yang kosong secara default.
        $kursusData = [
            'indo' => [],    // Untuk Bahasa Indonesia
            'inggris' => [], // Untuk Bahasa Inggris
            'mtk' => [],     // Untuk Matematika
        ];

        // Inisialisasi 16 minggu (dari 1 hingga 16) untuk setiap mata pelajaran.
        // Setiap minggu akan memiliki sub-array untuk 'materi' dan 'tugas'.
        foreach (['indo', 'inggris', 'mtk'] as $mapelSlug) {
            for ($i = 1; $i <= 16; $i++) {
                $kursusData[$mapelSlug][$i] = [
                    'materi' => [], // Array untuk menyimpan materi di minggu ini
                    'tugas' => [],  // Array untuk menyimpan tugas di minggu ini
                ];
            }
        }

        // Mengorganisir data Tugas berdasarkan mata pelajaran dan minggu.
        foreach ($allTugas as $tugas) {
            $mapelSlug = '';
            // Memeriksa apakah tugas memiliki relasi mapel yang valid.
            if ($tugas->mapel) {
                // Mengambil nama mapel dan mengubahnya menjadi huruf kecil untuk perbandingan.
                $namaMapel = strtolower($tugas->mapel->nama);
                // Menentukan 'mapelSlug' berdasarkan nama mata pelajaran.
                if ($namaMapel === 'bahasa indonesia') {
                    $mapelSlug = 'indo';
                } elseif ($namaMapel === 'bahasa inggris') {
                    $mapelSlug = 'inggris';
                } elseif ($namaMapel === 'matematika') {
                    $mapelSlug = 'mtk';
                }
            }

            // Memeriksa apakah 'mapelSlug' valid dan 'minggu' tugas berada dalam rentang yang diinisialisasi (1-16).
            if ($mapelSlug && isset($kursusData[$mapelSlug][$tugas->minggu])) {
                // Menambahkan detail tugas ke struktur data $kursusData yang sesuai.
                $kursusData[$mapelSlug][$tugas->minggu]['tugas'][] = [
                    'id' => $tugas->id,
                    'judul' => $tugas->judul,
                    // Menggunakan Storage::url() untuk mendapatkan URL publik dari file yang disimpan.
                    'file_url' => Storage::url($tugas->file_path),
                    'deadline' => $tugas->deadline,
                ];
            } else {
                // Mencatat peringatan jika tugas memiliki mapel yang tidak dikenal atau minggu di luar jangkauan.
                Log::warning("Tugas dengan ID {$tugas->id} memiliki mapel yang tidak dikenal atau minggu ({$tugas->minggu}) di luar jangkauan (1-16).");
            }
        }

        // Mengorganisir data Materi berdasarkan mata pelajaran dan minggu.
        foreach ($allMateri as $materi) {
            $mapelSlug = '';
            // Memeriksa apakah materi memiliki relasi mapel yang valid.
            if ($materi->mapel) {
                // Mengambil nama mapel dan mengubahnya menjadi huruf kecil untuk perbandingan.
                $namaMapel = strtolower($materi->mapel->nama);
                // Menentukan 'mapelSlug' berdasarkan nama mata pelajaran.
                if ($namaMapel === 'bahasa indonesia') {
                    $mapelSlug = 'indo';
                } elseif ($namaMapel === 'bahasa inggris') {
                    $mapelSlug = 'inggris';
                } elseif ($namaMapel === 'matematika') {
                    $mapelSlug = 'mtk';
                }
            }

            // Memeriksa apakah 'mapelSlug' valid dan 'minggu_ke' materi berada dalam rentang yang diinisialisasi (1-16).
            if ($mapelSlug && isset($kursusData[$mapelSlug][$materi->minggu_ke])) {
                // Pastikan nama kolom di materi adalah 'file_materi' (sesuai komentar asli).
                // Menambahkan detail materi ke struktur data $kursusData yang sesuai.
                $kursusData[$mapelSlug][$materi->minggu_ke]['materi'][] = [
                    'id' => $materi->id,
                    'judul' => $materi->judul_materi,
                    // Menggunakan Storage::url() untuk mendapatkan URL publik dari file materi.
                    'file_url' => Storage::url($materi->file_materi),
                ];
            } else {
                // Mencatat peringatan jika materi memiliki mapel yang tidak dikenal atau minggu di luar jangkauan.
                Log::warning("Materi dengan ID {$materi->id} memiliki mapel yang tidak dikenal atau minggu ({$materi->minggu_ke}) di luar jangkauan (1-16).");
            }
        }

        // --- DEBUGGING POINT 2 ---
        // Baris ini dapat diaktifkan untuk melihat struktur data $kursusData yang sudah final di log Laravel.
        // Log::info('Final Kursus Data:', $kursusData); // Log data akhir

        // Mengkodekan data $kursusData menjadi format JSON string.
        // Ini sering digunakan ketika data perlu dilewatkan ke JavaScript di sisi klien (misalnya untuk Alpine.js).
        $jsonDataKursus = json_encode($kursusData);
        // Menentukan tipe pengguna sebagai 'siswa' untuk keperluan view.
        $tipe = 'siswa';
        // Mengembalikan view 'siswa.kursus' dengan data JSON kursus dan tipe pengguna.
        return view('siswa.kursus', compact('jsonDataKursus', 'tipe'));
    }
}
