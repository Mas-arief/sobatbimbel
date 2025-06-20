<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'judul_materi',
        'file_materi',
        'minggu_ke',
        'mapel_id',
        'file_type',
        'original_filename'
    ];

    /**
     * Relasi ke mata pelajaran
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }

    /**
     * Scope untuk filter berdasarkan minggu
     */
    public function scopeMinggu($query, $minggu)
    {
        return $query->where('minggu_ke', $minggu);
    }

    /**
     * Scope untuk filter berdasarkan mata pelajaran
     */
    public function scopeMapel($query, $mapelId)
    {
        return $query->where('mapel_id', $mapelId);
    }

    /**
     * Accessor untuk mendapatkan URL file
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_materi);
    }
}
