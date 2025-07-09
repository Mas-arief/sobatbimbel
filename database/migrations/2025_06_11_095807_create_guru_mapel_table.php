<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel pivot `guru_mapel` untuk relasi many-to-many antara guru dan mata pelajaran.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'guru_mapel'
        // Tabel ini berfungsi sebagai tabel pivot (tabel perantara) untuk menghubungkan
        // guru dengan mata pelajaran yang diajarkannya, jika satu guru bisa mengajar banyak mapel
        // atau satu mapel diajar oleh banyak guru.
        Schema::create('guru_mapel', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key) untuk tabel pivot ini.

            // Menambahkan foreign key 'guru_id' yang merujuk ke kolom 'id' di tabel 'users'.
            // `constrained('users')` secara otomatis mengasumsikan nama tabel target adalah 'users'.
            // `onDelete('cascade')` berarti jika guru dihapus, semua entri terkait di tabel ini juga akan dihapus.
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');

            // Menambahkan foreign key 'mapel_id' yang merujuk ke kolom 'id' di tabel 'mapel'.
            // `constrained('mapel')` secara otomatis mengasumsikan nama tabel target adalah 'mapel'.
            // `onDelete('cascade')` berarti jika mata pelajaran dihapus, semua entri terkait di tabel ini juga akan dihapus.
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade');

            $table->timestamps(); // Kolom `created_at` dan `updated_at` untuk mencatat waktu pembuatan dan pembaruan record.

            // Opsional: Menambahkan unique constraint untuk mencegah duplikasi entri
            // (satu guru tidak bisa dikaitkan dengan mapel yang sama lebih dari sekali).
            // $table->unique(['guru_id', 'mapel_id']);
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel `guru_mapel` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mapel'); // Hapus tabel 'guru_mapel' jika ada.
    }
};
