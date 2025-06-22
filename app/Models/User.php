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
        'is_verified', // <--- TAMBAHKAN INI UNTUK VERIFIKASI ADMIN
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
        'is_verified' => 'boolean', // <--- TAMBAHKAN INI UNTUK MENGUBAHNYA MENJADI TIPE BOOLEAN
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'user_id');
    }
    public function mapel()
{
    return $this->belongsTo(Mapel::class, 'mapel_id');
}
}
