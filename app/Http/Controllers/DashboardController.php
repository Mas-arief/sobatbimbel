<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User diimpor

class DashboardController extends Controller
{
    public function index()
{
    $totalUnverifiedUsers = User::where(function ($q) {
        $q->where('is_verified', false)->orWhereNull('is_verified');
    })->count();

    $totalSiswa = User::where('role', 'siswa')
                      ->where(function ($q) {
                          $q->where('is_verified', true)->orWhere('is_verified', 1);
                      })->count();

    $totalGuru = User::where('role', 'guru')
                     ->where(function ($q) {
                         $q->where('is_verified', true)->orWhere('is_verified', 1);
                     })->count();

    $tipe = 'admin';

    return view('admin.dashboard-admin', compact('totalUnverifiedUsers', 'totalSiswa', 'totalGuru', 'tipe'));
}

}
