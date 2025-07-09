<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel `absensi` di database.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'absensi'
        Schema::create('absensi', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)

            $table->unsignedBigInteger('id_siswa'); // Kolom untuk menyimpan ID siswa (akan menjadi foreign key)
            $table->unsignedBigInteger('id_mapel'); // Kolom untuk menyimpan ID mata pelajaran (akan menjadi foreign key)

            $table->integer('minggu_ke'); // Kolom untuk menyimpan minggu ke berapa absensi ini

            // Mengubah tipe kolom 'kehadiran' menjadi ENUM.
            // Ini akan membatasi nilai yang bisa disimpan hanya pada 'hadir', 'izin', 'sakit', atau 'alpha'.
            // Nilai defaultnya adalah 'alpha' (tidak hadir tanpa keterangan).
            // PASTIKAN NAMA 'alpha' KONSISTEN DENGAN YANG DIKIRIM DARI FORM dan logika aplikasi.
            $table->enum('kehadiran', ['hadir', 'izin', 'sakit', 'alpha'])->default('alpha');

            $table->string('keterangan')->nullable(); // Kolom opsional untuk keterangan tambahan, bisa null
            $table->timestamps(); // Kolom `created_at` dan `updated_at`

            // Mendefinisikan foreign key ke tabel 'users' (untuk siswa).
            // Jika siswa dihapus, semua record absensinya juga akan dihapus.
            $table->foreign('id_siswa')->references('id')->on('users')->onDelete('cascade');
            // Mendefinisikan foreign key ke tabel 'mapel'.
            // Pastikan nama tabel mapel Anda adalah 'mapels' atau 'mapel' (sesuai database Anda).
            // Jika mata pelajaran dihapus, semua record absensi yang terkait juga akan dihapus.
            $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');

            // Opsional: Menambahkan unique constraint untuk mencegah duplikasi absensi
            // (satu siswa hanya bisa memiliki satu status absensi untuk mapel dan minggu tertentu).
            // $table->unique(['id_siswa', 'id_mapel', 'minggu_ke']);
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel `absensi` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi'); // Hapus tabel 'absensi' jika ada
    }
};
