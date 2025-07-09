<?php

// database/migrations/0001_01_01_000000_create_users_table.php
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
        // Membuat tabel 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)
            $table->string('name'); // Kolom untuk nama pengguna
            $table->string('email')->unique(); // Kolom untuk email, harus unik
            $table->timestamp('email_verified_at')->nullable(); // Kolom untuk waktu verifikasi email, bisa null
            $table->string('password'); // Kolom untuk password pengguna
            $table->rememberToken(); // Kolom untuk token "remember me"
            $table->timestamps(); // Kolom `created_at` dan `updated_at`

            // Komentar: Baris-baris berikut telah dihapus dari migrasi ini
            // dan seharusnya ditambahkan dalam migrasi terpisah
            // (misalnya, 'add_custom_fields_to_users_table')
            // untuk memperpanjang tabel 'users' bawaan Laravel.
            // $table->string('username')->unique(); // Username untuk login, harus unik
            // $table->text('alamat')->nullable(); // Alamat pengguna, bisa null
            // $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable(); // Jenis kelamin, bisa null
            // $table->string('telepon', 20)->nullable(); // Nomor telepon, bisa null
            // $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa'); // Peran pengguna, default 'siswa'
            // $table->boolean('is_verified')->default(false); // Status verifikasi, default false
            // $table->string('custom_identifier')->unique()->nullable(); // ID kustom unik, bisa null
            // $table->unsignedBigInteger('mapel_id')->nullable(); // Foreign key ke tabel mapel, bisa null
            // $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('set null'); // Definisi foreign key
        });

        // Membuat tabel 'password_reset_tokens'
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Kolom email sebagai primary key
            $table->string('token'); // Kolom untuk token reset password
            $table->timestamp('created_at')->nullable(); // Kolom waktu pembuatan token
        });

        // Membuat tabel 'sessions'
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Kolom ID sesi sebagai primary key
            $table->foreignId('user_id')->nullable()->index(); // Foreign key ke tabel users, bisa null, diindeks
            $table->string('ip_address', 45)->nullable(); // Alamat IP, bisa null
            $table->text('user_agent')->nullable(); // User agent browser, bisa null
            $table->longText('payload'); // Data sesi yang diserialisasi
            $table->integer('last_activity')->index(); // Waktu aktivitas terakhir, diindeks
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions'); // Hapus tabel 'sessions' jika ada
        Schema::dropIfExists('password_reset_tokens'); // Hapus tabel 'password_reset_tokens' jika ada
        Schema::dropIfExists('users'); // Hapus tabel 'users' jika ada
    }
};
