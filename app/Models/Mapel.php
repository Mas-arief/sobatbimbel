<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory untuk menggunakan model factories
use Illuminate\Database\Eloquent\Model; // Mengimpor kelas dasar Model Eloquent

class Mapel extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk memungkinkan pembuatan data dummy dengan factory

    /**
     * Nama tabel database yang terkait dengan model ini.
     * Secara default, Laravel akan mengasumsikan nama tabel adalah bentuk plural dari nama model (yaitu 'mapels').
     * Namun, karena tabel Anda bernama 'mapel' (singular), kita perlu menentukannya secara eksplisit.
     *
     * @var string
     */
    protected $table = 'mapel';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom tabel yang diizinkan untuk diisi menggunakan metode `create` atau `update`
     * dengan array data. Ini penting untuk mencegah kerentanan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama', // Kolom untuk menyimpan nama mata pelajaran
    ];

    /**
     * Mendefinisikan relasi "has many" dengan model Materi.
     * Ini berarti satu mata pelajaran (Mapel) dapat memiliki banyak materi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materi()
    {
        // Relasi ini menunjukkan bahwa kolom 'mapel_id' di tabel 'materis'
        // merujuk pada kolom 'id' di tabel 'mapel'.
        return $this->hasMany(Materi::class, 'mapel_id');
    }

    // Definisi konstanta untuk ID mata pelajaran tertentu.
    // Ini membantu dalam membuat kode lebih mudah dibaca dan dikelola,
    // terutama ketika berinteraksi dengan ID mata pelajaran yang spesifik.
    const BAHASA_INDONESIA = 1;
    const BAHASA_INGGRIS = 2;
    const MATEMATIKA = 3;

    /**
     * Metode statis untuk mendapatkan ID mata pelajaran berdasarkan slug tab.
     * Berguna untuk memetakan nama tab di UI ke ID mata pelajaran di database.
     *
     * @param string $tab Slug tab (misalnya 'indo', 'inggris', 'mtk').
     * @return int|null ID mata pelajaran atau null jika tidak ditemukan.
     */
    public static function getMapelByTab($tab)
    {
        // Array pemetaan antara slug tab dan konstanta ID mata pelajaran.
        $mapelMap = [
            'indo' => self::BAHASA_INDONESIA,
            'inggris' => self::BAHASA_INGGRIS,
            'mtk' => self::MATEMATIKA
        ];

        // Mengembalikan ID mata pelajaran yang sesuai dengan $tab,
        // atau null jika $tab tidak ditemukan dalam pemetaan.
        return $mapelMap[$tab] ?? null;
    }
}
