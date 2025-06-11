<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-increment sebagai primary key
            $table->string('nama'); // Nama lengkap guru
            $table->string('nip')->unique()->nullable(); // Nomor Induk Pegawai, harus unik jika diisi
            $table->string('tempat_lahir')->nullable(); // Kota tempat lahir
            $table->date('tanggal_lahir')->nullable(); // Tanggal lahir
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable(); // Jenis Kelamin (menggunakan enum untuk konsistensi)
            $table->text('alamat')->nullable(); // Alamat lengkap guru
            $table->string('telepon')->nullable(); // Nomor telepon
            $table->string('email')->unique()->nullable(); // Email guru, harus unik jika diisi
            $table->string('bidang_studi')->nullable(); // Mata pelajaran yang diajar

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Rollback migrasi.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
