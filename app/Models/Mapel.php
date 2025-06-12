<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel'; // sesuaikan dengan nama tabel
    public $timestamps = false;

    protected $fillable = ['nama', 'deskripsi']; // kolom yang ada di tabel
}
