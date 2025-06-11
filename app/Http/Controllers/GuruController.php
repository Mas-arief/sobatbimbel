<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GuruController extends Controller
{
    public function index()
    {
        // Mengambil semua user dengan role 'guru' dari tabel 'users'
        $dataGuru = User::where('role', 'guru')->get(); // <--- Ubah $dataSiswa menjadi $dataGuru

        $tipe = 'admin'; // Halaman ini diakses oleh admin

        return view('admin.profile_guru', compact('dataGuru', 'tipe')); // Sudah benar: meneruskan $dataGuru
    }

    // ... metode lain jika ada
}
