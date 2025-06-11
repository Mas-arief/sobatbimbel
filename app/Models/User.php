<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username', // Pastikan kolom ini juga ada di migrasi
        'name', // Ini default 'name' dari Laravel, bisa juga Anda ubah jadi 'nama_lengkap' jika mau
        'email',
        'password',
        'alamat',
        'jenis_kelamin',
        'telepon',
        'role',
        'guru_mata_pelajaran',
        // Jika ada kolom lain untuk siswa (nisn, tempat_lahir, tanggal_lahir), tambahkan di sini juga
        // 'nisn',
        // 'tempat_lahir',
        // 'tanggal_lahir',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
