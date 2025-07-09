<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel `pengumpulan_tugas` di database.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'pengumpulan_tugas'
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)

            // Foreign key ke tabel 'users' (untuk siswa yang mengumpulkan tugas).
            // Jika siswa dihapus, semua pengumpulan tugasnya juga akan dihapus.
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');

            // Foreign key ke tabel 'mapel'.
            // PENTING: Pastikan nama tabel 'mapel' di sini sesuai dengan nama tabel mapel Anda yang sebenarnya.
            // Jika tabel Anda 'mapels' (plural), ubah 'mapel' menjadi 'mapels'.
            // Jika mata pelajaran dihapus, semua pengumpulan tugas yang terkait dengan mapel tersebut juga akan dihapus.
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade'); // Kolom yang sebelumnya TIDAK ADA

            // Foreign key ke tabel 'tugas'.
            // Jika tugas dihapus, semua pengumpulan tugas yang terkait dengan tugas tersebut juga akan dihapus.
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');

            $table->integer('minggu_ke'); // Kolom untuk menyimpan minggu ke berapa tugas ini dikumpulkan (Kolom yang sebelumnya TIDAK ADA)
            $table->string('file_path')->nullable(); // Kolom untuk menyimpan path file tugas yang diunggah, bisa null (Diubah dari 'file' menjadi 'file_path' dan nullable)
            $table->enum('status', ['submitted', 'graded', 'pending'])->default('pending'); // Kolom untuk status pengumpulan (dikumpulkan, dinilai, tertunda), default 'pending' (Kolom yang sebelumnya TIDAK ADA)
            $table->integer('nilai')->nullable(); // Kolom untuk menyimpan nilai yang diberikan untuk tugas ini, bisa null (Kolom yang sebelumnya TIDAK ADA)
            $table->text('keterangan_siswa')->nullable(); // Kolom untuk keterangan tambahan dari siswa, bisa null (Diubah dari 'catatan' menjadi 'keterangan_siswa')

            $table->timestamps(); // Kolom `created_at` dan `updated_at`

            // Menambahkan unique constraint untuk mencegah duplikasi pengumpulan.
            // Satu siswa hanya bisa mengumpulkan satu tugas spesifik (berdasarkan tugas_id, mapel_id, dan minggu_ke)
            // agar tidak ada duplikasi pengumpulan untuk tugas yang sama di minggu yang sama oleh siswa yang sama.
            $table->unique(['siswa_id', 'tugas_id', 'mapel_id', 'minggu_ke'], 'unique_pengumpulan_tugas');
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel `pengumpulan_tugas` jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas'); // Hapus tabel 'pengumpulan_tugas' jika ada
    }
};
