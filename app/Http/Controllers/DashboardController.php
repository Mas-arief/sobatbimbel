<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User diimpor

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total siswa
        $totalSiswa = User::where('role', 'siswa')->count();

        // Hitung total guru
        $totalGuru = User::where('role', 'guru')->count();

        // === PERBAIKAN DI SINI: Hitung total user yang belum diverifikasi ===
        // Asumsi kolom 'is_verified' ada di tabel 'users' dan bernilai boolean (true/false) atau integer (1/0)
        $totalUnverifiedUsers = User::where('is_verified', false)->count();
        // Jika 'is_verified' adalah integer 0/1, gunakan: User::where('is_verified', 0)->count();

        // Kirim semua data yang diperlukan ke view
        $tipe='admin';
        return view('admin.dashboard-admin', compact('totalSiswa', 'totalGuru', 'totalUnverifiedUsers', 'tipe'));
    }
}
