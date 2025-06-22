<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengumpulan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            // PENTING: Pastikan nama tabel 'mapel' di sini sesuai dengan nama tabel mapel Anda yang sebenarnya.
            // Jika tabel Anda 'mapels' (plural), ubah 'mapel' menjadi 'mapels'.
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade'); // Kolom yang sebelumnya TIDAK ADA
            $table->foreignId('tugas_id')->constrained('tugas')->onDelete('cascade');
            $table->integer('minggu_ke'); // Kolom yang sebelumnya TIDAK ADA
            $table->string('file_path')->nullable(); // Diubah dari 'file' menjadi 'file_path' dan nullable
            $table->enum('status', ['submitted', 'graded', 'pending'])->default('pending'); // Kolom status yang sebelumnya TIDAK ADA
            $table->integer('nilai')->nullable(); // Kolom nilai yang sebelumnya TIDAK ADA
            $table->text('keterangan_siswa')->nullable(); // Diubah dari 'catatan' menjadi 'keterangan_siswa'
            $table->timestamps();

            // Menambahkan unique constraint untuk mencegah duplikasi pengumpulan
            // Satu siswa hanya bisa mengumpulkan satu tugas spesifik (mapel, tugas_id, minggu)
            $table->unique(['siswa_id', 'tugas_id', 'mapel_id', 'minggu_ke'], 'unique_pengumpulan_tugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumpulan_tugas');
    }
};
