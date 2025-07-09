<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini membuat tabel-tabel yang diperlukan untuk fungsionalitas antrean (queue) Laravel.
     *
     * @return void
     */
    public function up(): void
    {
        // Membuat tabel 'jobs'
        // Tabel ini digunakan untuk menyimpan pekerjaan (jobs) yang akan diproses oleh antrean.
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)
            $table->string('queue')->index(); // Kolom untuk nama antrean, diindeks untuk pencarian cepat
            $table->longText('payload'); // Kolom untuk menyimpan data serial dari pekerjaan
            $table->unsignedTinyInteger('attempts'); // Kolom untuk jumlah percobaan eksekusi pekerjaan
            $table->unsignedInteger('reserved_at')->nullable(); // Kolom timestamp kapan pekerjaan dicadangkan (sedang diproses), bisa null
            $table->unsignedInteger('available_at'); // Kolom timestamp kapan pekerjaan tersedia untuk diproses
            $table->unsignedInteger('created_at'); // Kolom timestamp kapan pekerjaan dibuat
        });

        // Membuat tabel 'job_batches'
        // Tabel ini digunakan oleh fitur "job batching" Laravel, yang memungkinkan pengelompokan pekerjaan.
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // Kolom ID batch sebagai primary key
            $table->string('name'); // Kolom untuk nama batch
            $table->integer('total_jobs'); // Kolom untuk total pekerjaan dalam batch
            $table->integer('pending_jobs'); // Kolom untuk pekerjaan yang masih tertunda
            $table->integer('failed_jobs'); // Kolom untuk pekerjaan yang gagal
            $table->longText('failed_job_ids'); // Kolom untuk ID pekerjaan yang gagal dalam format serial
            $table->mediumText('options')->nullable(); // Kolom untuk opsi batch, bisa null
            $table->integer('cancelled_at')->nullable(); // Kolom timestamp kapan batch dibatalkan, bisa null
            $table->integer('created_at'); // Kolom timestamp kapan batch dibuat
            $table->integer('finished_at')->nullable(); // Kolom timestamp kapan batch selesai, bisa null
        });

        // Membuat tabel 'failed_jobs'
        // Tabel ini digunakan untuk menyimpan pekerjaan yang gagal dieksekusi oleh antrean,
        // memungkinkan untuk inspeksi dan percobaan ulang.
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-incrementing (primary key)
            $table->string('uuid')->unique(); // Kolom UUID unik untuk identifikasi pekerjaan gagal
            $table->text('connection'); // Kolom untuk nama koneksi antrean yang digunakan
            $table->text('queue'); // Kolom untuk nama antrean tempat pekerjaan gagal
            $table->longText('payload'); // Kolom untuk data serial dari pekerjaan yang gagal
            $table->longText('exception'); // Kolom untuk menyimpan detail pengecualian/error yang terjadi
            $table->timestamp('failed_at')->useCurrent(); // Kolom timestamp kapan pekerjaan gagal, menggunakan waktu saat ini secara default
        });
    }

    /**
     * Balikkan migrasi (hapus tabel).
     * Metode ini menghapus tabel-tabel antrean jika migrasi dibalikkan.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');         // Hapus tabel 'jobs' jika ada
        Schema::dropIfExists('job_batches');  // Hapus tabel 'job_batches' jika ada
        Schema::dropIfExists('failed_jobs');  // Hapus tabel 'failed_jobs' jika ada
    }
};
