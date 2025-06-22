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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            // PENTING: Pastikan nama tabel 'mapel' di sini sesuai dengan nama tabel mapel Anda yang sebenarnya.
            // Jika tabel Anda 'mapels' (plural), ubah 'mapel' menjadi 'mapels'.
            $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade');
            $table->integer('minggu'); // Kolom 'minggu'
            $table->integer('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
