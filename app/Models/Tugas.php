<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'user_id',         // id siswa
        'judul_tugas',
        'nilai',
        'tanggal_kumpul',
    ];

    protected $dates = ['tanggal_kumpul'];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
