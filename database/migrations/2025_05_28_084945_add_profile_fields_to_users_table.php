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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom-kolom ini jika belum ada
            $table->string('username')->unique()->nullable()->after('id'); // Tambahkan username jika belum ada
            $table->text('alamat')->nullable()->after('email');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable()->after('alamat');
            $table->string('telepon')->nullable()->after('jenis_kelamin');
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa')->after('password'); // Default role 'siswa'
            $table->string('guru_mata_pelajaran')->nullable()->after('role'); // Hanya relevan untuk role guru
            // Jika ada kolom lain yang Anda maksud untuk siswa (misal: nisn, tempat_lahir, tanggal_lahir), tambahkan juga di sini
            // $table->string('nisn')->unique()->nullable()->after('username');
            // $table->string('tempat_lahir')->nullable()->after('nisn');
            // $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop kolom-kolom ini saat rollback
            $table->dropColumn([
                'username',
                'alamat',
                'jenis_kelamin',
                'telepon',
                'role',
                'guru_mata_pelajaran',
                // 'nisn', 'tempat_lahir', 'tanggal_lahir' // Jika Anda tambahkan
            ]);
        });
    }
};
