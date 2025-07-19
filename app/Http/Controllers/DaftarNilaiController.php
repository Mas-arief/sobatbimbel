<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP (meskipun tidak digunakan langsung di index ini)
use Illuminate\Support\Facades\Auth; // Mengimpor Facade Auth untuk mendapatkan pengguna yang sedang login
use App\Models\Mapel; // Mengimpor model Mapel untuk berinteraksi dengan data mata pelajaran
use App\Models\Penilaian; // Mengimpor model Penilaian untuk berinteraksi dengan data nilai siswa
use App\Models\User; // Pastikan model User di-import, meskipun tidak digunakan langsung di index ini, ini adalah praktik baik

class DaftarNilaiController extends Controller // Atau nama controller Anda
{
    /**
     * Menampilkan daftar nilai untuk siswa yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil instance pengguna yang sedang login.
        // Dalam kasus ini, diasumsikan pengguna yang login adalah seorang siswa.
        $siswa = Auth::user();

        // Mengambil semua data mata pelajaran dari database.
        $mapel = Mapel::all();

        // Mengambil data penilaian siswa berdasarkan ID siswa yang sedang login.
        // Data kemudian dikelompokkan berdasarkan 'mapel_id' (ID mata pelajaran).
        // UBAH DARI 'user_id' MENJADI 'siswa_id'
        // Karena di tabel Anda kolomnya bernama 'siswa_id' (sesuai komentar asli).
        $penilaianSiswa = Penilaian::where('siswa_id', $siswa->id) // <--- PENTING: Ganti 'user_id' menjadi 'siswa_id'
            ->get() // Mengambil semua record penilaian yang cocok.
            ->groupBy('mapel_id'); // Mengelompokkan hasil berdasarkan ID mata pelajaran.

        // Untuk skenario 16 pertemuan, Anda mungkin perlu mengelompokkan juga berdasarkan minggu
        // Jika Anda ingin mengelompokkan lebih lanjut berdasarkan minggu, Anda bisa menggunakan kode di bawah ini:
        // $penilaianSiswa = Penilaian::where('siswa_id', $siswa->id)
        //                            ->get()
        //                            ->groupBy(['mapel_id', 'minggu']); // Ini akan membuat struktur data yang lebih kompleks

        // Menentukan tipe pengguna sebagai 'siswa' untuk keperluan view.
        $tipe = 'siswa';
        // Mengembalikan view 'siswa.daftar_nilai' dengan data yang diperlukan.
        // Data yang dikirimkan meliputi: mapel (semua mata pelajaran), penilaianSiswa (nilai yang sudah dikelompokkan),
        // dan tipe (untuk penyesuaian tampilan di view).
        return view('siswa.daftar_nilai', compact('mapel', 'penilaianSiswa', 'tipe'));
    }
}
