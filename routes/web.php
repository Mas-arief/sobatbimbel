<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login'); // Asumsi file Blade bernama static_login.blade.php
})->name('login'); // Anda tetap bisa memberikan nama rute jika diperlukan

Route::get('/daftar', function () {
    return view('daftar');
})->name('daftarr');

Route::get('/ganti_sandi', function () {
    return view('ganti_sandi');
})->name('ganti_sandi');

Route::get('/daftar_hadir', function () {
    return view('daftar_hadir');
})->name('daftar_hadir');

Route::get('/profil_siswa', function () {
    return view('profil_siswa');
})->name('profil_siswa');

Route::get('/nilai_siswa', function () {
    return view('nilai_siswa');
})->name('nilai_siswa');

Route::get('/kursus_siswa', function () {
    return view('kursus_siswa');
})->name('kursus_siswa');

Route::get('/ganti_pw_siswa', function () {
    return view('ganti_pw_siswa');
})->name('ganti_pw_siswa');

use App\Http\Controllers\DashboardController;

Route::get('/admin.dashboard-admin', [DashboardController::class, 'index'])->name('dashboard');

// routes/web.php
use App\Http\Controllers\GuruController;

Route::get('/admin.profile_guru', [GuruController::class, 'index'])->name('guru.index');
Route::get('/admin.verifikasi', function () {
    $tipe = 'admin';
    return view('admin.verifikasi', compact('tipe'));
});

use App\Http\Controllers\ProfileController;

// Menampilkan profil
Route::get('/guru.profile', [ProfileController::class, 'show'])->name('guru.profile_guru');

// Memperbarui profil
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/guru.daftar_hadir', function () {
    $tipe = 'guru';
    return view('guru.daftar_hadir', compact('tipe'));
})->name('daftarhadir.index');

Route::get('/guru.daftar_nilai', function () {
    $tipe = 'guru';
    return view('guru.daftar_nilai', compact('tipe'));
})->name('daftarnilai.index');

Route::get('/guru.kursus', function () {
    $tipe = 'guru';
    return view('guru.kursus', compact('tipe'));
});

Route::get('/admin.guru_mapel', function () {
    $tipe = 'admin';
    return view('admin.guru_mapel', compact('tipe'));
});

Route::get('/siswa.profile', [App\Http\Controllers\ProfileeController::class, 'index'])->name('profile.index');
Route::get('/siswa.daftar_hadir', [App\Http\Controllers\DaftarHadirController::class, 'index'])->name('daftar_hadir.index');
Route::get('/siswa.daftar_nilai', [App\Http\Controllers\DaftarNilaiController::class, 'index'])->name('daftar_nilai.index');
Route::get('/siswa.kursus', [App\Http\Controllers\KursusController::class, 'index'])->name('kursus.index');

