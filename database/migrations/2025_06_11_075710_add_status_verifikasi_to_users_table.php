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
            // Menambahkan kolom 'is_verified' dengan tipe boolean dan nilai default false
            // Ini akan menandakan apakah user sudah diverifikasi oleh admin atau belum.
            $table->boolean('is_verified')->default(false)->after('password'); // Anda bisa sesuaikan posisi 'after' sesuai kebutuhan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
};
