<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'minggu',    // Pastikan 'minggu' ada di sini
        'nilai',
    ];

    // Relasi ke user (siswa)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    // Relasi ke mapel
    public function mapel()
    {
        // PENTING: Jika tabel mapel Anda bernama 'mapel' (singular), ini mungkin perlu eksplisit
        // return $this->belongsTo(Mapel::class, 'mapel_id', 'id', 'mapel');
        // Jika tabel mapel Anda bernama 'mapels' (plural), ini sudah benar
        return $this->belongsTo(Mapel::class);
    }
}
