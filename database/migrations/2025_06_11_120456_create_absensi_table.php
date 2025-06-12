<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id(); // ID Absensi
            $table->unsignedBigInteger('id_siswa'); // FK ke siswa
            $table->unsignedBigInteger('id_mapel'); // FK ke mapel
            $table->string('nama'); // Nama siswa (optional)
            $table->integer('minggu_ke'); // Minggu ke berapa
            $table->boolean('kehadiran')->default(false); // Auto centang jika hadir
            $table->enum('keterangan', ['sakit', 'izin', 'alpha'])->nullable();
            $table->timestamps();

            // Foreign key constraints (optional, if you have these tables)
            $table->foreign('id_siswa')->references('id')->on('siswas')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id')->on('mapels')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
};
