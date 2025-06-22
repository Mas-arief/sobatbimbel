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
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->string('judul_materi');
            $table->string('file_materi'); // path ke file yang diupload
            $table->integer('minggu_ke'); // minggu 1-16
            $table->unsignedBigInteger('mapel_id'); // foreign key ke mata pelajaran
            $table->string('file_type')->nullable(); // pdf, docx, pptx
            $table->string('original_filename')->nullable(); // nama file asli
            $table->timestamps();

            // Index untuk query yang lebih cepat
            $table->index(['minggu_ke', 'mapel_id']);

            // Jika Anda memiliki tabel 'mapel' dan ingin relasi FK, tambahkan ini:
            // $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
