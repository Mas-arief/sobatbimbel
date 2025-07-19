<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel 'personal_access_tokens' yang digunakan oleh Laravel Sanctum
     * untuk mengelola token API pribadi.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'personal_access_tokens'
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)
            $table->morphs('tokenable'); // Kolom polimorfik untuk mengaitkan token dengan model apa pun (misal: User)
            $table->string('name'); // Nama token (misal: "API Token untuk Aplikasi Mobile")
            $table->string('token', 64)->unique(); // String token yang unik, diindeks untuk pencarian cepat
            $table->text('abilities')->nullable(); // Kemampuan atau cakupan token (misal: "['read', 'write']"), bisa null
            $table->timestamp('last_used_at')->nullable(); // Waktu terakhir token digunakan, bisa null
            $table->timestamp('expires_at')->nullable(); // Waktu kedaluwarsa token, bisa null
            $table->timestamps(); // Kolom `created_at` dan `updated_at`
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel 'personal_access_tokens' jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens'); // Hapus tabel 'personal_access_tokens' jika ada
    }
};
