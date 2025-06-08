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
            // Periksa jika kolom 'name' belum ada, tambahkan
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('username');
            }
            // Tambahkan kolom-kolom lainnya setelah kolom yang sesuai
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->string('alamat')->nullable()->after('email');
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
            $table->dropColumn([
                'name',
                'alamat',
                'jenis_kelamin',
                'telepon',
                'nisn',
                'kelas',
                'guru_mata_pelajaran',
            ]);
        });
    }
};
