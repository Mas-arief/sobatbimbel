<?php

// database/migrations/2025_06_22_XXXXXX_add_custom_fields_to_users_table.php (timestamp akan otomatis paling baru)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'username'
            $table->string('username')->unique()->nullable()->after('id');
            // Tambahkan kolom 'alamat'
            $table->text('alamat')->nullable()->after('email'); // Sesuaikan posisi after
            // Tambahkan kolom 'jenis_kelamin'
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable()->after('alamat');
            // Tambahkan kolom 'telepon'
            $table->string('telepon')->nullable()->after('jenis_kelamin');
            // Tambahkan kolom 'role'
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa')->after('password');
            // Tambahkan kolom 'is_verified'


            // Ini yang PALING PENTING: Foreign key untuk mapel_id
            // Migrasi ini akan berjalan SETELAH create_mapel_table
            $table->foreignId('mapel_id')->nullable()->constrained('mapel')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key dulu
            $table->dropConstrainedForeignId('mapel_id');
            // Drop kolom-kolom tambahan lainnya
            $table->dropColumn([
                'username',
                'alamat',
                'jenis_kelamin',
                'telepon',
                'role',

            ]);
        });
    }
};
