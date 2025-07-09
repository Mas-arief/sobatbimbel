<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel-tabel yang diperlukan untuk sistem caching Laravel.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'cache'
        // Tabel ini digunakan oleh driver cache 'database' untuk menyimpan data cache.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Kolom 'key' sebagai primary key, menyimpan kunci cache.
            $table->mediumText('value');     // Kolom 'value' untuk menyimpan nilai cache (data yang disimpan).
            $table->integer('expiration');   // Kolom 'expiration' untuk menyimpan timestamp kapan cache akan kedaluwarsa.
        });

        // Membuat tabel 'cache_locks'
        // Tabel ini digunakan untuk implementasi atomic locks dalam sistem caching,
        // mencegah kondisi balapan (race conditions) saat menulis atau membaca cache.
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Kolom 'key' sebagai primary key, kunci untuk lock.
            $table->string('owner');         // Kolom 'owner' untuk mengidentifikasi pemilik lock.
            $table->integer('expiration');   // Kolom 'expiration' untuk timestamp kapan lock akan kedaluwarsa.
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel-tabel cache jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cache');       // Hapus tabel 'cache' jika ada.
        Schema::dropIfExists('cache_locks'); // Hapus tabel 'cache_locks' jika ada.
    }
};
