<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel `tugas` di database.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'tugas'
        Schema::create('tugas', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)

            // Menambahkan foreign key 'mapel_id' yang merujuk ke kolom 'id' di tabel 'mapel'.
            // `constrained('mapel')` secara otomatis mengasumsikan nama tabel target adalah 'mapel'.
            // `onDelete('cascade')` berarti jika mata pelajaran dihapus, semua tugas yang terkait dengan mapel tersebut juga akan dihapus.
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade');

            $table->integer('minggu'); // Kolom untuk menyimpan minggu ke berapa tugas ini diberikan (misal: 1-16)
            $table->text('deskripsi'); // Kolom untuk menyimpan deskripsi atau judul tugas
            $table->date('deadline')->nullable(); // Kolom untuk tanggal batas waktu pengumpulan tugas, bisa null

            $table->timestamps(); // Kolom `created_at` dan `updated_at` untuk mencatat waktu pembuatan dan pembaruan record
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel `tugas` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas'); // Hapus tabel 'tugas' jika ada
    }
};
