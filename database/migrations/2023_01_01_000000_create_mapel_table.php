<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel 'mapel' di database.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'mapel'
        Schema::create('mapel', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)
            $table->string('nama'); // Kolom untuk menyimpan nama mata pelajaran (misal: "Matematika", "Bahasa Indonesia")
            $table->timestamps(); // Kolom `created_at` dan `updated_at` untuk mencatat waktu pembuatan dan pembaruan record
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel 'mapel' jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel'); // Hapus tabel 'mapel' jika ada
    }
};
