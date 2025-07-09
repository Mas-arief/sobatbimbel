<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use App\Models\Mapel; // Mengimpor model Mapel untuk berinteraksi dengan data mata pelajaran
use App\Models\Materi; // Mengimpor model Materi untuk berinteraksi dengan data materi pelajaran
use App\Models\Tugas;  // Mengimpor model Tugas untuk berinteraksi dengan data tugas
use Illuminate\Support\Facades\Auth; // Mengimpor Facade Auth untuk mendapatkan pengguna yang sedang login
use Illuminate\Support\Str; // Mengimpor kelas Str untuk fungsi-fungsi string helper (misalnya Str::contains)

class KursusGuruController extends Controller
{
    /**
     * Menampilkan halaman kursus untuk guru.
     * Halaman ini akan menampilkan materi dan tugas yang terkait dengan mata pelajaran yang diajar guru.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Mengambil instance pengguna (guru) yang sedang login.
        $guru = Auth::user();

        // Asumsi: Relasi 'mapel' di model User mengembalikan satu objek Mapel.
        // Ini berarti setiap guru diasumsikan hanya mengajar satu mata pelajaran.
        // Jika guru bisa mengajar banyak mapel, logika ini perlu diubah untuk mengambil koleksi mapel.
        $mapelGuru = $guru->mapel; // Ini akan mengembalikan objek Mapel atau null jika guru belum dikaitkan dengan mapel.

        // Inisialisasi array kosong untuk menyimpan data yang akan dikirim ke view.
        $mapel = []; // Akan berisi data Mapel yang relevan (misalnya ['indo' => MapelObj]).
        $materials = []; // Akan berisi koleksi Materi yang dikelompokkan (misalnya ['indo' => Collection of Materi]).
        $assignments = []; // Akan berisi koleksi Tugas yang dikelompokkan (misalnya ['indo' => Collection of Tugas]).
        $defaultTab = 'indo'; // Menentukan tab default yang akan aktif di tampilan.

        // Memeriksa apakah guru memiliki mata pelajaran yang diajar.
        if ($mapelGuru) {
            $mapelName = $mapelGuru->nama; // Mengambil nama mata pelajaran dari objek Mapel.
            $mapelId = $mapelGuru->id; // Mengambil ID mata pelajaran.

            // Menentukan kunci array (misalnya 'indo', 'inggris', 'mtk') berdasarkan nama mata pelajaran.
            // Ini membantu dalam mengatur struktur data yang konsisten untuk tampilan Blade.
            $key = '';
            // Menggunakan Str::contains untuk memeriksa apakah nama mapel mengandung kata kunci tertentu (case-insensitive).
            if (Str::contains($mapelName, 'Indonesia', true)) {
                $key = 'indo';
            } elseif (Str::contains($mapelName, 'Inggris', true)) {
                $key = 'inggris';
            } elseif (Str::contains($mapelName, 'Matematika', true)) {
                $key = 'mtk';
            }

            // Jika kunci ditemukan (artinya mapel guru cocok dengan salah satu kategori),
            // simpan objek Mapel ke array $mapel dengan kunci yang sesuai.
            if ($key) {
                $mapel[$key] = $mapelGuru;
                // Mengatur tab default berdasarkan parameter query 'tab' atau kunci mapel guru.
                $defaultTab = $request->query('tab', $key);
            }

            // Mengambil semua materi untuk mata pelajaran yang diajar guru.
            // Hasilnya dikelompokkan berdasarkan 'minggu_ke' untuk memudahkan tampilan per minggu.
            $allMaterialsForGuruMapel = Materi::where('mapel_id', $mapelId)->get()->groupBy('minggu_ke');
            // Mengambil semua tugas untuk mata pelajaran yang diajar guru.
            // Hasilnya dikelompokkan berdasarkan 'minggu' untuk memudahkan tampilan per minggu.
            $allAssignmentsForGuruMapel = Tugas::where('mapel_id', $mapelId)->get()->groupBy('minggu');

            // Mengisi array $materials dan $assignments dengan data yang sudah diambil,
            // menggunakan kunci yang sesuai dengan kategori mata pelajaran.
            if ($key) {
                $materials[$key] = $allMaterialsForGuruMapel;
                $assignments[$key] = $allAssignmentsForGuruMapel;
            }
        }

        // Menentukan tipe pengguna sebagai 'guru' untuk keperluan view.
        $tipe = 'guru';

        // Mengembalikan view 'guru.kursus' dengan semua variabel yang diperlukan.
        // compact() adalah fungsi PHP yang membuat array dari variabel yang diberikan,
        // di mana kunci array adalah nama variabel dan nilainya adalah nilai variabel.
        return view('guru.kursus', compact('mapel', 'defaultTab', 'tipe', 'materials', 'assignments'));
    }
}
