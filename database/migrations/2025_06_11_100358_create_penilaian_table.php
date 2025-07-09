<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel `penilaian` di database.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'penilaian'
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)

            // Foreign key ke tabel 'users' (untuk siswa yang dinilai).
            // Jika siswa dihapus, semua penilaiannya juga akan dihapus.
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');

            // Foreign key ke tabel 'mapel'.
            // Jika mata pelajaran dihapus, semua penilaian yang terkait dengan mapel tersebut juga akan dihapus.
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade');

            $table->integer('minggu'); // Kolom 'minggu' untuk menyimpan minggu ke berapa penilaian ini dilakukan
            $table->integer('nilai'); // Kolom untuk menyimpan nilai yang diberikan

            $table->timestamps(); // Kolom `created_at` dan `updated_at`

            // Opsional: Menambahkan unique constraint untuk mencegah duplikasi penilaian
            // (satu siswa hanya bisa memiliki satu nilai untuk mapel dan minggu tertentu).
            // $table->unique(['siswa_id', 'mapel_id', 'minggu']);
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel `penilaian` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian'); // Hapus tabel 'penilaian' jika ada
    }
};
