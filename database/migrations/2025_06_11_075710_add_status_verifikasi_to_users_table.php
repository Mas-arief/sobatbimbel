<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini menambahkan kolom `is_verified` ke tabel `users`.
     *
     * @return void
     */
    public function up(): void
    {
        // Mengubah tabel 'users' yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'is_verified' dengan tipe boolean.
            // Nilai defaultnya adalah `false`, yang berarti akun baru secara default belum diverifikasi.
            // `after('password')` menempatkan kolom ini setelah kolom 'password' dalam struktur tabel.
            $table->boolean('is_verified')->default(false)->after('password'); // Anda bisa sesuaikan posisi 'after' sesuai kebutuhan
        });
    }

    /**
     * Balikkan migrasi (hapus kolom).
     * Metode ini menghapus kolom `is_verified` dari tabel `users` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        // Mengubah tabel 'users' yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'is_verified'.
            $table->dropColumn('is_verified');
        });
    }
};
