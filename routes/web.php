<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Diperlukan untuk Auth::routes() atau rute logout

// Pindahkan semua use statements ke bagian paling atas
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileeController; // Pertimbangkan untuk menggabungkan dengan ProfileController
use App\Http\Controllers\DaftarHadirController;
use App\Http\Controllers\DaftarNilaiController;
use App\Http\Controllers\KursusGuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\MateriController; // Ini adalah satu-satunya deklarasi use untuk MateriController
use App\Http\Controllers\KursussiswaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController; // Ditambahkan
use App\Http\Controllers\Auth\PasswordController; // Ditambahkan




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Rute Umum / Landing Page ---
Route::get('/', function () {
    return view('welcome');
});

// --- Rute Static yang Tidak Diatur Melalui Controller (Pertimbangkan untuk memindahkan ke controller jika ada logika) ---
Route::get('/ganti_sandi', function () {
    return view('ganti_sandi');
})->name('ganti_sandi'); // Ini bisa dihapus jika password.change digunakan secara eksklusif

Route::get('/daftar_hadir', function () {
    return view('daftar_hadir');
})->name('daftar_hadir');

Route::get('/profil_siswa', function () {
    return view('profil_siswa');
})->name('profil_siswa');

Route::middleware(['auth', 'role:siswa'])->group(function () {
    return view('siswa.daftar_nilai');
})->name('nilai_siswa');

Route::get('/kursus_siswa', function () {
    return view('kursus_siswa');
})->name('kursus_siswa');

Route::get('/ganti_pw_siswa', function () {
    return view('ganti_pw_siswa');
})->name('ganti_pw_siswa'); // Ini juga bisa dihapus jika password.change digunakan

// --- Rute Admin (Tanpa Auth Middleware Awal) ---
// Dashboard Admin
Route::get('/admin.dashboard-admin', [DashboardController::class, 'index'])->name('dashboard'); // Pertimbangkan untuk mengubah nama menjadi 'admin.dashboard' dan URI ke /admin/dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); // Ini duplikat dari yang di atas, pilih salah satu.

// Profil Guru (dari sisi Admin)
Route::get('/admin.profile_guru', [GuruController::class, 'index'])->name('guru.index'); // Nama rute 'guru.index' mungkin kurang jelas untuk tampilan admin
Route::get('/admin.profile_guru', [GuruController::class, 'index'])->name('admin.profile_guru'); // Ini duplikat dari yang di atas, pilih salah satu.

// Profil Siswa (dari sisi Admin)
Route::get('/admin.profile_siswa', function () {
    $tipe = 'admin';
    return view('admin.profile_siswa', compact('tipe'));
}); // Ini menggunakan closure, bisa dipindah ke SiswaController jika ada logika
Route::get('/admin.profile_siswa', [SiswaController::class, 'index'])->name('admin.profile_siswa'); // Ini duplikat, pilih salah satu.

// Guru Mata Pelajaran (dari sisi Admin)
Route::get('/admin.guru_mapel', function () {
    $tipe = 'admin';
    return view('admin.guru_mapel', compact('tipe'));
});

// --- Rute Autentikasi (Pendaftaran, Login, Logout) ---
Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/daftar', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// --- Rute yang Membutuhkan Autentikasi (Middleware 'auth') ---
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Ganti Password (Untuk semua peran yang terautentikasi)
    Route::get('/ganti-sandi', [PasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/ganti-sandi', [PasswordController::class, 'changePassword']);

    // --- Rute Admin (Membutuhkan Auth) ---
    // Verifikasi Pengguna (Guru dan Siswa)
    Route::get('/admin.verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::post('/verify-user/{userId}', [AdminController::class, 'verifyUser'])->name('admin.verify-user');

    // --- Rute Guru (Membutuhkan Auth) ---
    // Profil Guru (dari sisi Guru itu sendiri)
    Route::get('/guru.profile', [ProfileController::class, 'showProfile'])->name('guru.profile'); // Menggunakan nama 'guru.profile'
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update'); // Update profil umum

    //Route Guru

    Route::get('/guru/pengumpulan', [App\Http\Controllers\guru\TugasController::class, 'index'])->name('guru.pengumpulan');
    Route::get('/tugas/{id}/edit', [App\Http\Controllers\guru\TugasController::class, 'edit'])->name('guru.tugas.edit');

    Route::get('/guru.kursus', [KursusGuruController::class, 'index'])->name('guru.kursus');
    // Absensi
    Route::middleware(['auth'])->prefix('guru')->name('guru.')->group(function () {
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
        Route::get('/absensi/{mapel}', [AbsensiController::class, 'show'])->name('absensi.show'); // <== YANG INI
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    });

    // Penilaian
    Route::get('guru.penilaian/{mapelId}', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');


    // Tugas (untuk guru menambah tugas)
    Route::post('/guru.modal_tambah_tugas', [TugasController::class, 'index'])->name('tugas.store'); // Index biasanya untuk GET, pertimbangkan method 'store'

    // --- Rute Siswa (Membutuhkan Auth) ---
    // Profil Siswa (dari sisi Siswa itu sendiri)
    // Pertimbangkan untuk menggabungkan ProfileeController ke ProfileController
    Route::get('/siswa.profile', [ProfileeController::class, 'index'])->name('siswa.profile');
    Route::post('/siswa.profile', [ProfileeController::class, 'update'])->name('siswa.profile.update');

    // Daftar Hadir Siswa
    Route::get('/siswa.daftar_hadir', [DaftarHadirController::class, 'index'])->name('daftar_hadir.index');

    // Daftar Nilai Siswa
    Route::get('/siswa.daftar_nilai', [DaftarNilaiController::class, 'index'])->name('daftar_nilai.index');

    // Kursus Siswa (view)
    Route::get('/siswa.kursus', [KursusSiswaController::class, 'index'])->name('kursus.index'); // Ini sudah ada, tapi nama rute 'kursus.index' mungkin kurang spesifik
    // Perbaiki: Route::get('/kursus', [KursussiswaController::class, 'kursus.index'])->name('siswa.kursus');
    // Seharusnya: Route::get('/kursus', [KursussiswaController::class, 'index'])->name('siswa.kursus'); // Jika KursussiswaController->index() menangani ini
});



// Routes untuk materi
Route::prefix('materi')->name('materi.')->group(function () {
    Route::post('/store', [MateriController::class, 'store'])->name('store');
    Route::get('/minggu/{minggu}/mapel/{mapel}', [MateriController::class, 'getMateriByMingguMapel'])->name('by-minggu-mapel');
    Route::get('/download/{id}', [MateriController::class, 'download'])->name('download');
    Route::delete('/{id}', [MateriController::class, 'destroy'])->name('destroy');
});

// Jika Anda ingin menambahkan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::prefix('materi')->name('materi.')->group(function () {
        Route::post('/store', [MateriController::class, 'store'])->name('store');
        Route::get('/minggu/{minggu}/mapel/{mapel}', [MateriController::class, 'getMateriByMingguMapel'])->name('by-minggu-mapel');
        Route::get('/download/{id}', [MateriController::class, 'download'])->name('download');
        Route::delete('/{id}', [MateriController::class, 'destroy'])->name('destroy');
    });
});
