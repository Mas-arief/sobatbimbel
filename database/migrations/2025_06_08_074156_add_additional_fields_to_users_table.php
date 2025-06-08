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
            // Tambahkan kolom-kolom baru di sini
            $table->string('name')->nullable()->after('username'); // Setelah username
            $table->string('alamat')->nullable()->after('telepon'); // Sesuaikan posisi
            $table->string('jenis_kelamin')->nullable()->after('alamat'); // Sesuaikan posisi
            $table->string('telepon')->nullable()->after('jenis_kelamin'); // Sesuaikan posisi
            $table->string('nisn')->nullable()->after('telepon'); // Setelah telepon atau sesuaikan
            $table->string('kelas')->nullable()->after('nisn'); // Setelah nisn atau sesuaikan
            $table->string('guru_mata_pelajaran')->nullable()->after('kelas'); // Setelah kelas atau sesuaikan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom-kolom jika migrasi di-rollback
            $table->dropColumn([
                'name',
                'alamat',
                'jenis_kelamin',
                'telepon',
                'guru_mata_pelajaran',
            ]);
        });
    }
};
