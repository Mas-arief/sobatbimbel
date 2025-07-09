<?php

// database/migrations/2025_06_22_XXXXXX_add_custom_fields_to_users_table.php (timestamp akan otomatis paling baru)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini menambahkan kolom-kolom kustom ke tabel 'users' yang sudah ada.
     *
     * @return void
     */
    public function up(): void
    {
        // Mengubah tabel 'users' yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'username'
            // Kolom ini akan menjadi unik dan bisa null (jika tidak semua user memiliki username).
            // Ditempatkan setelah kolom 'id'.
            $table->string('username')->unique()->nullable()->after('id');

            // Tambahkan kolom 'alamat'
            // Kolom ini akan menyimpan alamat pengguna dan bisa null.
            // Ditempatkan setelah kolom 'email'.
            $table->text('alamat')->nullable()->after('email'); // Sesuaikan posisi after

            // Tambahkan kolom 'jenis_kelamin'
            // Kolom ini akan menyimpan jenis kelamin dengan pilihan 'Laki-Laki' atau 'Perempuan', dan bisa null.
            // Ditempatkan setelah kolom 'alamat'.
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->nullable()->after('alamat');

            // Tambahkan kolom 'telepon'
            // Kolom ini akan menyimpan nomor telepon pengguna dan bisa null.
            // Ditempatkan setelah kolom 'jenis_kelamin'.
            $table->string('telepon')->nullable()->after('jenis_kelamin');

            // Tambahkan kolom 'role'
            // Kolom ini akan menyimpan peran pengguna (admin, guru, atau siswa) dengan default 'siswa'.
            // Ditempatkan setelah kolom 'password'.
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa')->after('password');

            // Catatan: Kolom 'is_verified' sudah ditambahkan di migrasi terpisah sebelumnya.
            // Jika belum, Anda bisa menambahkannya di sini:
            // $table->boolean('is_verified')->default(false)->after('role');


            // Ini yang PALING PENTING: Foreign key untuk mapel_id
            // Kolom ini akan menjadi kunci asing yang merujuk ke kolom 'id' di tabel 'mapel'.
            // `nullable()` berarti seorang user (terutama admin atau siswa yang tidak terkait langsung dengan satu mapel)
            // bisa memiliki nilai null di kolom ini.
            // `constrained('mapel')` secara otomatis mengasumsikan nama tabel target adalah 'mapel'.
            // `onDelete('set null')` berarti jika mata pelajaran yang terkait dihapus,
            // nilai 'mapel_id' pada user yang merujuk ke mapel tersebut akan diatur menjadi NULL.
            // Migrasi ini akan berjalan SETELAH create_mapel_table untuk memastikan tabel 'mapel' sudah ada.
            $table->foreignId('mapel_id')->nullable()->constrained('mapel')->onDelete('set null');
        });
    }

    /**
     * Balikkan migrasi.
     * Metode ini menghapus kolom-kolom kustom yang ditambahkan di metode `up()`.
     *
     * @return void
     */
    public function down(): void
    {
        // Mengubah tabel 'users' yang sudah ada
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key terlebih dahulu sebelum menghapus kolomnya.
            // Ini penting untuk menjaga integritas database.
            $table->dropConstrainedForeignId('mapel_id');

            // Drop kolom-kolom tambahan lainnya yang telah ditambahkan.
            // Pastikan urutan drop column tidak menyebabkan masalah dependensi.
            $table->dropColumn([
                'username',
                'alamat',
                'jenis_kelamin',
                'telepon',
                'role',
                // Catatan: Jika 'is_verified' ditambahkan di migrasi ini,
                // pastikan juga untuk menghapusnya di sini:
                // 'is_verified',
            ]);
        });
    }
};
