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
        'username',
        'name',
        'email',
        'password',
        'alamat',
        'jenis_kelamin',
        'telepon',
        'role',
        'guru_mata_pelajaran',
        'is_verified',
        'custom_identifier',
        'mapel_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
    ];

    // Generate custom_identifier hanya untuk siswa dan guru
    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->custom_identifier && in_array($user->role, ['siswa', 'guru'])) {
                $prefix = $user->role === 'siswa' ? 'SBS' : 'SBG';

                $last = self::where('role', $user->role)
                            ->whereNotNull('custom_identifier')
                            ->orderByDesc('id')
                            ->first();

                $number = 1;
                if ($last && preg_match('/\d+$/', $last->custom_identifier, $matches)) {
                    $number = (int) $matches[0] + 1;
                }

                $user->custom_identifier = $prefix . $number;
            }
        });
    }

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
