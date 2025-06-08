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
            // Hapus baris 'name' di sini karena sudah ada dari migrasi create_users_table
            // $table->string('name')->nullable()->after('username'); // <--- BARIS INI HARUS DIHAPUS

            // Tambahkan kolom-kolom baru secara berurutan dan logis
            // Mulai dari kolom yang sudah ada seperti 'email' atau 'username'
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->string('alamat')->nullable()->after('email'); // Gunakan 'email' sebagai referensi awal
            }
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('users', 'telepon')) {
                $table->string('telepon')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('users', 'nisn')) {
                $table->string('nisn')->nullable()->unique()->after('telepon');
            }
            if (!Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas')->nullable()->after('nisn');
            }
            if (!Schema::hasColumn('users', 'guru_mata_pelajaran')) {
                $table->string('guru_mata_pelajaran')->nullable()->after('kelas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Pastikan semua kolom yang ditambahkan di up() juga dihapus di down()
            $table->dropColumn([
                // 'name', // Hapus ini juga dari down() jika Anda menghapusnya dari up() migrasi ini
                'alamat',
                'jenis_kelamin',
                'telepon',
                'nisn', // Tambahkan
                'kelas', // Tambahkan
                'guru_mata_pelajaran', // Tambahkan
            ]);
        });
    }
};
