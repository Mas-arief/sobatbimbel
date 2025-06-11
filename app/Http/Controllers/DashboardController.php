<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();

        // Tambahkan variabel $tipe
        $tipe = 'admin'; // Karena ini dashboard admin

        return view('admin.dashboard-admin', compact('totalSiswa', 'totalGuru', 'tipe'));
    }
}
