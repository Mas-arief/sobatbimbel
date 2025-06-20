<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'deskripsi'
    ];

    /**
     * Relasi ke materi
     */
    public function materi()
    {
        return $this->hasMany(Materi::class, 'mapel_id');
    }

    /**
     * Konstanta untuk ID mata pelajaran
     */
    const BAHASA_INDONESIA = 1;
    const BAHASA_INGGRIS = 2;
    const MATEMATIKA = 3;

    /**
     * Mendapatkan nama mata pelajaran berdasarkan tab
     */
    public static function getMapelByTab($tab)
    {
        $mapelMap = [
            'indo' => self::BAHASA_INDONESIA,
            'inggris' => self::BAHASA_INGGRIS,
            'mtk' => self::MATEMATIKA
        ];

        return $mapelMap[$tab] ?? null;
    }
}
