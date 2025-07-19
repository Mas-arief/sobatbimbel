<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini menambahkan kolom `custom_identifier` ke tabel `users`.
     *
     * @return void
     */
    public function up()
    {
        // Mengubah tabel 'users' yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'custom_identifier' dengan tipe string.
            // Kolom ini akan bersifat unik (tidak boleh ada dua pengguna dengan identifier yang sama).
            // `nullable()` berarti kolom ini bisa kosong (tidak semua pengguna harus memiliki custom_identifier).
            $table->string('custom_identifier')->unique()->nullable();
        });
    }

    /**
     * Balikkan migrasi (hapus kolom).
     * Metode ini menghapus kolom `custom_identifier` dari tabel `users` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        // Mengubah tabel 'users' yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'custom_identifier'.
            $table->dropColumn('custom_identifier');
        });
    }
};
