<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory untuk menggunakan model factories
use Illuminate\Database\Eloquent\Model; // Mengimpor kelas dasar Model Eloquent

class Absensi extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk memungkinkan pembuatan data dummy dengan factory

    /**
     * Nama tabel database yang terkait dengan model ini.
     * Secara default, Laravel akan mengasumsikan nama tabel adalah bentuk plural dari nama model (yaitu 'absensis').
     * Namun, karena tabel Anda bernama 'absensi' (singular), kita perlu menentukannya secara eksplisit.
     *
     * @var string
     */
    protected $table = 'absensi';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom tabel yang diizinkan untuk diisi menggunakan metode `create` atau `update`
     * dengan array data. Ini penting untuk mencegah kerentanan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_siswa',   // Kolom untuk menyimpan ID siswa
        'id_mapel',   // Kolom untuk menyimpan ID mata pelajaran
        'minggu_ke',  // Kolom untuk menyimpan minggu ke berapa absensi ini
        'kehadiran',  // Kolom untuk menyimpan status kehadiran (misalnya 'hadir', 'izin', 'sakit', 'alpha')
        'keterangan', // Kolom opsional untuk keterangan tambahan mengenai absensi
    ];

    /**
     * Mendefinisikan relasi "belongs to" dengan model User.
     * Ini berarti setiap record Absensi dimiliki oleh satu User (siswa).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa()
    {
        // Relasi ini menunjukkan bahwa kolom 'id_siswa' di tabel 'absensi'
        // merujuk pada kolom 'id' di tabel 'users'.
        return $this->belongsTo(User::class, 'id_siswa');
    }

    /**
     * Mendefinisikan relasi "belongs to" dengan model Mapel.
     * Ini berarti setiap record Absensi dimiliki oleh satu Mapel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        // Relasi ini menunjukkan bahwa kolom 'id_mapel' di tabel 'absensi'
        // merujuk pada kolom 'id' di tabel 'mapel'.
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
