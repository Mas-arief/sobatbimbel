<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // <-- Pastikan ini adalah App\Models\User

class SiswaController extends Controller
{
    public function index()
    {
        // Mengambil semua user dengan role 'siswa' dari tabel 'users'
        $dataSiswa = User::where('role', 'siswa')->get(); // <-- Gunakan User::where()

        $tipe = 'admin'; // Halaman ini diakses oleh admin

        return view('admin.profile_siswa', compact('dataSiswa', 'tipe'));
    }

    // ... metode lain jika ada, pastikan mereka juga menggunakan model User
}
