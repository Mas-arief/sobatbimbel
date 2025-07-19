<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory untuk menggunakan model factories
use Illuminate\Database\Eloquent\Model; // Mengimpor kelas dasar Model Eloquent

class PengumpulanTugas extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk memungkinkan pembuatan data dummy dengan factory

    /**
     * Nama tabel database yang terkait dengan model ini.
     * Secara default, Laravel akan mengasumsikan nama tabel adalah bentuk plural dari nama model (yaitu 'pengumpulan_tugas').
     * Karena nama tabel sudah sesuai dengan konvensi plural Laravel, kita tidak perlu menentukannya secara eksplisit,
     * namun menuliskannya tetap tidak masalah untuk kejelasan.
     *
     * @var string
     */
    protected $table = 'pengumpulan_tugas';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom tabel yang diizinkan untuk diisi menggunakan metode `create` atau `update`
     * dengan array data. Ini penting untuk mencegah kerentanan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siswa_id',         // Kolom untuk menyimpan ID siswa yang mengumpulkan tugas
        'mapel_id',         // Kolom untuk menyimpan ID mata pelajaran terkait tugas ini
        'tugas_id',         // Kolom untuk menyimpan ID tugas yang dikumpulkan
        'minggu_ke',        // Kolom untuk menyimpan minggu ke berapa tugas ini dikumpulkan
        'file_path',        // Kolom untuk menyimpan path file tugas yang diunggah siswa di storage
        'status',           // Kolom untuk menyimpan status pengumpulan (misalnya 'submitted', 'graded')
        'nilai',            // Kolom untuk menyimpan nilai yang diberikan untuk tugas ini (opsional, bisa null)
        'keterangan_siswa', // Kolom untuk menyimpan keterangan tambahan dari siswa saat mengumpulkan tugas
    ];

    /**
     * Mendefinisikan relasi "belongs to" dengan model User.
     * Ini berarti setiap record PengumpulanTugas dimiliki oleh satu User (siswa).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa()
    {
        // Relasi ini menunjukkan bahwa kolom 'siswa_id' di tabel 'pengumpulan_tugas'
        // merujuk pada kolom 'id' di tabel 'users'.
        return $this->belongsTo(User::class, 'siswa_id');
    }

    /**
     * Mendefinisikan relasi "belongs to" dengan model Mapel.
     * Ini berarti setiap record PengumpulanTugas terkait dengan satu Mapel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        // Relasi ini menunjukkan bahwa kolom 'mapel_id' di tabel 'pengumpulan_tugas'
        // merujuk pada kolom 'id' di tabel 'mapel'.
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    /**
     * Mendefinisikan relasi "belongs to" dengan model Tugas.
     * Ini berarti setiap record PengumpulanTugas terkait dengan satu Tugas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tugas()
    {
        // Relasi ini menunjukkan bahwa kolom 'tugas_id' di tabel 'pengumpulan_tugas'
        // merujuk pada kolom 'id' di tabel 'tugas'.
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}
