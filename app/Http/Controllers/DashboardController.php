<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request (meskipun tidak digunakan langsung di metode index ini)
use App\Models\User; // Pastikan model User diimpor untuk berinteraksi dengan tabel pengguna

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk admin.
     * Metode ini mengumpulkan statistik penting seperti jumlah pengguna yang belum diverifikasi,
     * total siswa, dan total guru.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menghitung total pengguna yang belum diverifikasi.
        // Query ini mencari pengguna di mana 'is_verified' adalah false ATAU 'is_verified' adalah null.
        $totalUnverifiedUsers = User::where(function ($q) {
            $q->where('is_verified', false)->orWhereNull('is_verified');
        })->count(); // Menggunakan count() untuk mendapatkan jumlah total.

        // Menghitung total siswa yang sudah diverifikasi.
        // Query ini mencari pengguna dengan 'role' 'siswa' DAN 'is_verified' adalah true (atau 1).
        $totalSiswa = User::where('role', 'siswa')
                          ->where(function ($q) {
                              $q->where('is_verified', true)->orWhere('is_verified', 1);
                          })->count();

        // Menghitung total guru yang sudah diverifikasi.
        // Query ini mencari pengguna dengan 'role' 'guru' DAN 'is_verified' adalah true (atau 1).
        $totalGuru = User::where('role', 'guru')
                         ->where(function ($q) {
                             $q->where('is_verified', true)->orWhere('is_verified', 1);
                         })->count();

        // Menentukan tipe pengguna sebagai 'admin' untuk keperluan view.
        $tipe = 'admin';

        // Mengembalikan view 'admin.dashboard-admin' dengan data statistik yang sudah dihitung.
        // Data yang dikirimkan meliputi: totalUnverifiedUsers, totalSiswa, totalGuru, dan tipe.
        return view('admin.dashboard-admin', compact('totalUnverifiedUsers', 'totalSiswa', 'totalGuru', 'tipe'));
    }
}
