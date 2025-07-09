<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini menambahkan atau memodifikasi kolom pada tabel 'tugas'.
     *
     * @return void
     */
    public function up(): void
    {
        // Mengubah tabel 'tugas' yang sudah ada
        Schema::table('tugas', function (Blueprint $table) {
            // 1. Hapus kolom 'deskripsi' yang lama (jika ada dan tidak digunakan).
            // Hati-hati: ini akan menghapus data di kolom 'deskripsi' secara permanen.
            // Pengecekan `Schema::hasColumn` memastikan migrasi tidak error jika kolom sudah dihapus sebelumnya.
            if (Schema::hasColumn('tugas', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }

            // 2. Tambahkan kolom 'judul' (jika belum ada).
            // Kolom ini akan menyimpan judul tugas.
            // Ditempatkan setelah kolom 'mapel_id'.
            if (!Schema::hasColumn('tugas', 'judul')) {
                $table->string('judul')->after('mapel_id');
            }

            // 3. Tambahkan kolom 'file_path'.
            // Kolom ini akan menyimpan path ke file tugas yang diunggah.
            // `nullable()` berarti tugas tidak harus selalu memiliki file.
            // Ditempatkan setelah kolom 'judul'.
            if (!Schema::hasColumn('tugas', 'file_path')) {
                $table->string('file_path')->nullable()->after('judul');
            }

            // 4. Tambahkan foreignId 'user_id' jika Anda ingin mengaitkan tugas dengan guru yang membuatnya.
            // `nullable()` berarti tugas bisa tidak memiliki guru pembuat yang terkait (misal jika guru dihapus).
            // `constrained('users')` secara otomatis merujuk ke tabel 'users'.
            // `onDelete('set null')` berarti jika guru dihapus, 'user_id' pada tugas akan diatur ke NULL.
            // Atau Anda bisa menggunakan `onDelete('cascade')` jika tugas harus dihapus ketika guru dihapus.
            // Ditempatkan setelah kolom 'id'.
            if (!Schema::hasColumn('tugas', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->after('id');
            }

            // Optional: Ubah tipe kolom 'deadline' jika sebelumnya bukan date.
            // Ini digunakan jika Anda perlu mengubah tipe kolom yang sudah ada.
            // $table->date('deadline')->change();
        });
    }

    /**
     * Balikkan migrasi.
     * Metode ini mengembalikan perubahan yang dilakukan di metode `up()`.
     *
     * @return void
     */
    public function down(): void
    {
        // Mengubah tabel 'tugas' yang sudah ada
        Schema::table('tugas', function (Blueprint $table) {
            // Mengembalikan perubahan dalam urutan terbalik dari metode `up()`.

            // Hapus foreign key 'user_id' terlebih dahulu sebelum menghapus kolomnya.
            if (Schema::hasColumn('tugas', 'user_id')) {
                $table->dropConstrainedForeignId('user_id'); // Menggunakan dropConstrainedForeignId untuk FK yang dibuat dengan constrained()
                $table->dropColumn('user_id');
            }

            // Hapus kolom 'file_path'.
            if (Schema::hasColumn('tugas', 'file_path')) {
                $table->dropColumn('file_path');
            }

            // Hapus kolom 'judul'.
            if (Schema::hasColumn('tugas', 'judul')) {
                $table->dropColumn('judul');
            }

            // Tambahkan kembali kolom 'deskripsi' jika Anda ingin mengembalikannya ke kondisi semula.
            // Pastikan tipe data dan atributnya sesuai dengan definisi asli.
            // if (!Schema::hasColumn('tugas', 'deskripsi')) {
            //     $table->text('deskripsi')->nullable();
            // }
        });
    }
};
