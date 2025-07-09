<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory untuk menggunakan model factories
use Illuminate\Database\Eloquent\Model; // Mengimpor kelas dasar Model Eloquent

class Materi extends Model
{
    use HasFactory; // Menggunakan trait HasFactory untuk memungkinkan pembuatan data dummy dengan factory

    /**
     * Nama tabel database yang terkait dengan model ini.
     * Secara default, Laravel akan mengasumsikan nama tabel adalah bentuk plural dari nama model (yaitu 'materis').
     * Namun, karena tabel Anda bernama 'materi' (singular), kita perlu menentukannya secara eksplisit.
     *
     * @var string
     */
    protected $table = 'materi';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom tabel yang diizinkan untuk diisi menggunakan metode `create` atau `update`
     * dengan array data. Ini penting untuk mencegah kerentanan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul_materi',      // Kolom untuk menyimpan judul materi
        'file_materi',       // Kolom untuk menyimpan nama file materi yang disimpan di storage
        'minggu_ke',         // Kolom untuk menyimpan minggu ke berapa materi ini
        'mapel_id',          // Kolom untuk menyimpan ID mata pelajaran yang terkait
        'file_type',         // Kolom untuk menyimpan tipe file (ekstensi)
        'original_filename'  // Kolom untuk menyimpan nama asli file saat diunggah
    ];

    /**
     * Mendefinisikan relasi "belongs to" dengan model Mapel.
     * Ini berarti setiap record Materi dimiliki oleh satu Mapel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        // Relasi ini menunjukkan bahwa kolom 'mapel_id' di tabel 'materi'
        // merujuk pada kolom 'id' di tabel 'mapel'.
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    /**
     * Scope query untuk memfilter materi berdasarkan minggu.
     * Memungkinkan penulisan query seperti `Materi::minggu(5)->get()`.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $minggu
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMinggu($query, $minggu)
    {
        return $query->where('minggu_ke', $minggu);
    }

    /**
     * Scope query untuk memfilter materi berdasarkan mata pelajaran.
     * Memungkinkan penulisan query seperti `Materi::mapel(1)->get()`.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $mapelId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMapel($query, $mapelId)
    {
        return $query->where('mapel_id', $mapelId);
    }

    /**
     * Accessor untuk mendapatkan URL publik dari file materi.
     * Ini memungkinkan Anda mengakses URL file seperti `$materi->file_url`.
     * Penting: Pastikan Anda telah menjalankan `php artisan storage:link`
     * agar direktori `storage/app/public` dapat diakses melalui `public/storage`.
     *
     * @return string
     */
    public function getFileUrlAttribute()
    {
        // Mengembalikan URL lengkap untuk mengakses file materi yang disimpan di direktori 'public/materi'.
        // Asumsi: file_materi hanya berisi nama file (misal: 'materi_12345.pdf')
        // dan file tersebut disimpan di 'storage/app/public/materi/'.
        return asset('storage/materi/' . $this->file_materi);
    }
}
