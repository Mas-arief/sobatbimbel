<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'siswa_id',
        'mapel_id', // Pastikan kolom ini ada di migrasi Anda
        'tugas_id',
        'minggu_ke', // Pastikan kolom ini ada di migrasi Anda
        'file_path', // Pastikan kolom ini ada di migrasi Anda
        'status',    // Pastikan kolom ini ada di migrasi Anda
        'nilai',     // Pastikan kolom ini ada di migrasi Anda
        'keterangan_siswa', // Pastikan kolom ini ada di migrasi Anda
    ];

    // Relasi ke User (Siswa)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // Relasi ke Mapel
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    // Relasi ke Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}
