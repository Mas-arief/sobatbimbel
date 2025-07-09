<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory untuk menggunakan model factories
use Illuminate\Database\Eloquent\Model; // Mengimpor kelas dasar Model Eloquent

class Tugas extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk memungkinkan pembuatan data dummy dengan factory

    // Tentukan nama tabel jika tidak sesuai konvensi Laravel (plural dari nama model).
    // Secara default, Laravel akan mencari tabel 'tugas' (plural dari 'Tugas' adalah 'tugases' atau 'tugas').
    // Jika tabel Anda bernama 'tugas' (singular), menentukan ini secara eksplisit adalah praktik yang baik.
    protected $table = 'tugas';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom tabel yang diizinkan untuk diisi menggunakan metode `create` atau `update`
     * dengan array data. Ini penting untuk mencegah kerentanan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mapel_id',  // Kolom untuk menyimpan ID mata pelajaran yang terkait dengan tugas ini
        'judul',     // Kolom untuk menyimpan judul tugas
        'file_path', // Kolom untuk menyimpan path file tugas yang diunggah di storage
        'deadline',  // Kolom untuk menyimpan tanggal batas waktu pengumpulan tugas
        'minggu',    // Kolom untuk menyimpan minggu ke berapa tugas ini diberikan
        'user_id',   // Kolom untuk menyimpan ID pengguna (guru) yang membuat tugas ini
    ];

    /**
     * Mendefinisikan relasi "belongs to" dengan model Mapel.
     * Ini berarti setiap record Tugas terkait dengan satu Mapel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        // Relasi ini menunjukkan bahwa kolom 'mapel_id' di tabel 'tugas'
        // merujuk pada kolom 'id' di tabel 'mapel'.
        // Karena nama model Mapel sesuai dengan konvensi, tidak perlu eksplisit menyebutkan foreign key.
        return $this->belongsTo(Mapel::class);
    }

    /**
     * Mendefinisikan relasi "belongs to" dengan model User (sebagai guru).
     * Ini berarti setiap record Tugas dibuat oleh satu User (guru).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru()
    {
        // Relasi ini menunjukkan bahwa kolom 'user_id' di tabel 'tugas'
        // merujuk pada kolom 'id' di tabel 'users'.
        // Kita secara eksplisit menyebutkan foreign key 'user_id' karena nama relasi adalah 'guru'.
        return $this->belongsTo(User::class, 'user_id');
    }
}
