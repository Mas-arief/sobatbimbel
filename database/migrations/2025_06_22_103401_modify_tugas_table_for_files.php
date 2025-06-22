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
        Schema::table('tugas', function (Blueprint $table) {
            // 1. Hapus kolom 'deskripsi' yang lama (jika ada dan tidak digunakan)
            // Hati-hati: ini akan menghapus data di kolom 'deskripsi'
            if (Schema::hasColumn('tugas', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }

            // 2. Tambahkan kolom 'judul' (jika belum ada)
            if (!Schema::hasColumn('tugas', 'judul')) {
                $table->string('judul')->after('mapel_id');
            }

            // 3. Tambahkan kolom 'file_path'
            if (!Schema::hasColumn('tugas', 'file_path')) {
                $table->string('file_path')->nullable()->after('judul');
            }

            // 4. Tambahkan foreignId 'user_id' jika Anda ingin mengaitkan dengan guru
            if (!Schema::hasColumn('tugas', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->after('id');
                // Gunakan onDelete('set null') jika user_id bisa null
                // atau onDelete('cascade') jika tugas harus dihapus ketika guru dihapus
            }

            // Optional: Ubah tipe kolom 'deadline' jika sebelumnya bukan date
            // $table->date('deadline')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            // Revert changes in reverse order
            if (Schema::hasColumn('tugas', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('tugas', 'file_path')) {
                $table->dropColumn('file_path');
            }

            if (Schema::hasColumn('tugas', 'judul')) {
                $table->dropColumn('judul');
            }

            // Tambahkan kembali kolom 'deskripsi' jika Anda ingin mengembalikannya
            // $table->text('deskripsi')->nullable();
        });
    }
};
