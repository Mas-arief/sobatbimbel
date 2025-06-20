<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_mapel');

            $table->integer('minggu_ke');

            // Ubah kehadiran jadi enum (bukan boolean)
            $table->enum('kehadiran', ['hadir', 'izin', 'sakit', 'alpha'])->default('alpha');

            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_siswa')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id')->on('mapel')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
}
};