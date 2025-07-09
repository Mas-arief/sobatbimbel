<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel `materi` di database.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'materi'
        Schema::create('materi', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)
            $table->string('judul_materi'); // Kolom untuk menyimpan judul materi pelajaran
            $table->string('file_materi'); // Kolom untuk menyimpan path atau nama file materi yang diunggah di storage
            $table->integer('minggu_ke'); // Kolom untuk menyimpan minggu ke berapa materi ini diajarkan (misal: 1-16)
            $table->unsignedBigInteger('mapel_id'); // Kolom foreign key ke tabel 'mapel' (ID mata pelajaran)
            $table->string('file_type')->nullable(); // Kolom opsional untuk menyimpan tipe file (misal: 'pdf', 'docx', 'pptx')
            $table->string('original_filename')->nullable(); // Kolom opsional untuk menyimpan nama asli file saat diunggah

            $table->timestamps(); // Kolom `created_at` dan `updated_at` untuk mencatat waktu pembuatan dan pembaruan record

            // Menambahkan indeks untuk query yang lebih cepat.
            // Indeks komposit pada 'minggu_ke' dan 'mapel_id' akan mempercepat pencarian materi
            // berdasarkan minggu dan mata pelajaran.
            $table->index(['minggu_ke', 'mapel_id']);

            // Jika Anda memiliki tabel 'mapel' dan ingin relasi Foreign Key (FK), tambahkan ini:
            // Ini akan memastikan integritas referensial: jika sebuah mapel dihapus,
            // materi yang terkait dengan mapel tersebut juga akan dihapus (cascade).
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel `materi` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('materi'); // Hapus tabel 'materi' jika ada
    }
};
