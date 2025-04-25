<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login'); // Asumsi file Blade bernama static_login.blade.php
})->name('login'); // Anda tetap bisa memberikan nama rute jika diperlukan
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
