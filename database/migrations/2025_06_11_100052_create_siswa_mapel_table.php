<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel pivot `siswa_mapel` untuk relasi many-to-many antara siswa dan mata pelajaran.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'siswa_mapel'
        // Tabel ini berfungsi sebagai tabel pivot (tabel perantara) untuk menghubungkan
        // siswa dengan mata pelajaran yang mereka ambil. Ini memungkinkan satu siswa mengambil banyak mapel
        // dan satu mapel diambil oleh banyak siswa.
        Schema::create('siswa_mapel', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key) untuk tabel pivot ini.

            // Menambahkan foreign key 'siswa_id' yang merujuk ke kolom 'id' di tabel 'users'.
            // `constrained('users')` secara otomatis mengasumsikan nama tabel target adalah 'users'.
            // `onDelete('cascade')` berarti jika siswa dihapus, semua entri terkait di tabel ini juga akan dihapus.
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');

            // Menambahkan foreign key 'mapel_id' yang merujuk ke kolom 'id' di tabel 'mapel'.
            // `constrained('mapel')` secara otomatis mengasumsikan nama tabel target adalah 'mapel'.
            // `onDelete('cascade')` berarti jika mata pelajaran dihapus, semua entri terkait di tabel ini juga akan dihapus.
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade');

            $table->timestamps(); // Kolom `created_at` dan `updated_at` untuk mencatat waktu pembuatan dan pembaruan record.

            // Opsional: Menambahkan unique constraint untuk mencegah duplikasi entri
            // (satu siswa tidak bisa dikaitkan dengan mapel yang sama lebih dari sekali).
            // $table->unique(['siswa_id', 'mapel_id']);
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel `siswa_mapel` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_mapel'); // Hapus tabel 'siswa_mapel' jika ada.
    }
};
