<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'id_siswa', 'id_mapel', 'minggu_ke', 'kehadiran', 'keterangan',
    ];

    public function siswa() {
        return $this->belongsTo(User::class, 'id_siswa');
    }

    public function mapel() {
        return $this->belongsTo(Mapel::class, 'id_mapel');
}
}