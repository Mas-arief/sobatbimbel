<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai konvensi Laravel (plural dari nama model)
    protected $table = 'tugas';

    protected $fillable = [
        'mapel_id',
        'judul', // Sesuai kolom DB
        'file_path', // Sesuai kolom DB
        'deadline', // Sesuai kolom DB
        'minggu',   // Sesuai kolom DB
        'user_id',
    ];

    // Definisi relasi jika ada (misal dengan model Mapel dan User)
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id'); // Asumsi guru adalah User
    }
}
