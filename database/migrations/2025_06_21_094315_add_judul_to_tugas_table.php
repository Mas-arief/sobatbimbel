<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini menambahkan kolom `judul` ke tabel `tugas`.
     *
     * @return void
     */
    public function up(): void
    {
        // Mengubah tabel 'tugas' yang sudah ada
        Schema::table('tugas', function (Blueprint $table) {
            // Tambahkan kolom 'judul' dengan tipe string.
            // `after('mapel_id')` menempatkan kolom ini setelah kolom 'mapel_id' dalam struktur tabel.
            $table->string('judul')->after('mapel_id');
        });
    }

    /**
     * Balikkan migrasi (hapus kolom).
     * Metode ini menghapus kolom `judul` dari tabel `tugas` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        // Mengubah tabel 'tugas' yang sudah ada
        Schema::table('tugas', function (Blueprint $table) {
            // Menghapus kolom 'judul'.
            $table->dropColumn('judul');
        });
    }
};
