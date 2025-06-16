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
        'minggu',   // <--- TAMBAHKAN BARIS INI
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
        return $this->belongsTo(Mapel::class);
    }
}
