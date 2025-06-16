<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mapel;
use App\Models\Penilaian;
use App\Models\User; // Pastikan model User di-import

class DaftarNilaiController extends Controller // Atau nama controller Anda
{
    public function index()
    {
        $siswa = Auth::user();

        // Ambil semua mata pelajaran
        $mapel = Mapel::all();

        // UBAH DARI 'user_id' MENJADI 'siswa_id'
        // Karena di tabel Anda kolomnya bernama 'siswa_id'
        $penilaianSiswa = Penilaian::where('siswa_id', $siswa->id) // <--- PENTING: Ganti 'user_id' menjadi 'siswa_id'
            ->get()
            ->groupBy('mapel_id');

        // Untuk skenario 16 pertemuan, Anda mungkin perlu mengelompokkan juga berdasarkan minggu
        // $penilaianSiswa = Penilaian::where('siswa_id', $siswa->id)
        //                             ->get()
        //                             ->groupBy(['mapel_id', 'minggu']); // Ini akan membuat struktur data yang lebih kompleks
        $tipe = 'siswa';
        return view('siswa.daftar_nilai', compact('mapel', 'penilaianSiswa', 'tipe'));
    }
}
