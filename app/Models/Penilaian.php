<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory untuk menggunakan model factories
use Illuminate\Database\Eloquent\Model; // Mengimpor kelas dasar Model Eloquent

class Penilaian extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk memungkinkan pembuatan data dummy dengan factory

    /**
     * Nama tabel database yang terkait dengan model ini.
     * Secara default, Laravel akan mengasumsikan nama tabel adalah bentuk plural dari nama model (yaitu 'penilaians').
     * Karena tabel Anda bernama 'penilaian' (singular), kita perlu menentukannya secara eksplisit.
     *
     * @var string
     */
    protected $table = 'penilaian';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom tabel yang diizinkan untuk diisi menggunakan metode `create` atau `update`
     * dengan array data. Ini penting untuk mencegah kerentanan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'siswa_id', // Kolom untuk menyimpan ID siswa yang dinilai
        'mapel_id', // Kolom untuk menyimpan ID mata pelajaran yang dinilai
        'minggu',   // Kolom untuk menyimpan minggu ke berapa penilaian ini dilakukan
        'nilai',    // Kolom untuk menyimpan nilai yang diberikan
    ];

    /**
     * Mendefinisikan relasi "belongs to" dengan model User.
     * Ini berarti setiap record Penilaian dimiliki oleh satu User (siswa).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa()
    {
        // Relasi ini menunjukkan bahwa kolom 'siswa_id' di tabel 'penilaian'
        // merujuk pada kolom 'id' di tabel 'users'.
        return $this->belongsTo(User::class, 'siswa_id');
    }

    /**
     * Mendefinisikan relasi "belongs to" dengan model Mapel.
     * Ini berarti setiap record Penilaian terkait dengan satu Mapel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        // Relasi ini menunjukkan bahwa kolom 'mapel_id' di tabel 'penilaian'
        // merujuk pada kolom 'id' di tabel 'mapel'.
        // Karena model Mapel Anda sudah secara eksplisit mendefinisikan
        // protected $table = 'mapel'; maka Laravel akan secara otomatis
        // menemukan tabel yang benar. Anda bisa menyertakan foreign key
        // secara eksplisit untuk kejelasan, tapi tidak wajib jika konvensi diikuti.
        return $this->belongsTo(Mapel::class, 'mapel_id'); // Lebih eksplisit dan jelas
    }
}
