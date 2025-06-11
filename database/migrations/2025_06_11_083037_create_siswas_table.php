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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-increment sebagai primary key
            $table->string('nama'); // Nama lengkap siswa
            $table->string('nisn')->unique()->nullable(); // Nomor Induk Siswa Nasional, harus unik jika diisi
            $table->string('tempat_lahir')->nullable(); // Kota tempat lahir
            $table->date('tanggal_lahir')->nullable(); // Tanggal lahir
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable(); // Jenis Kelamin
            $table->text('alamat')->nullable(); // Alamat lengkap siswa
            $table->string('telepon')->nullable(); // Nomor telepon siswa/wali
            $table->string('email')->unique()->nullable(); // Email siswa, harus unik jika diisi

            // Jika Anda memiliki tabel 'kelas', Anda bisa menambahkan foreign key seperti ini:
            // $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');

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
        Schema::dropIfExists('siswas');
    }
};
