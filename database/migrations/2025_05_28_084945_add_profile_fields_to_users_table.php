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
            // Tambahkan kolom 'username' HANYA JIKA belum ada
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('id');
            }
            // Tambahkan kolom 'alamat' HANYA JIKA belum ada
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('email');
            }
            // Tambahkan kolom 'jenis_kelamin' HANYA JIKA belum ada
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable()->after('alamat');
            }
            // Tambahkan kolom 'telepon' HANYA JIKA belum ada
            if (!Schema::hasColumn('users', 'telepon')) {
                $table->string('telepon')->nullable()->after('jenis_kelamin');
            }
            // Tambahkan kolom 'role' HANYA JIKA belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa')->after('password');
            }
            // Tambahkan kolom 'guru_mata_pelajaran' HANYA JIKA belum ada
            if (!Schema::hasColumn('users', 'guru_mata_pelajaran')) {
                $table->string('guru_mata_pelajaran')->nullable()->after('role');
            }
            // Jika Anda menambahkan kolom lain (misalnya 'nisn'), terapkan juga pemeriksaan yang sama:
            // if (!Schema::hasColumn('users', 'nisn')) {
            //     $table->string('nisn')->unique()->nullable();
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop kolom HANYA JIKA mereka ada
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
            if (Schema::hasColumn('users', 'telepon')) {
                $table->dropColumn('telepon');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'guru_mata_pelajaran')) {
                $table->dropColumn('guru_mata_pelajaran');
            }
            // Jika Anda menghapus kolom lain, terapkan juga pemeriksaan yang sama:
            // if (Schema::hasColumn('users', 'nisn')) {
            //     $table->dropColumn('nisn');
            // }
        });
    }
};
