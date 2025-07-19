<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Mengimpor interface untuk fitur verifikasi email
use Illuminate\Database\Eloquent\Factories\HasFactory; // Mengimpor trait HasFactory untuk menggunakan model factories
use Illuminate\Foundation\Auth\User as Authenticatable; // Mengimpor kelas dasar User dari Laravel Authentication
use Illuminate\Notifications\Notifiable; // Mengimpor trait Notifiable untuk notifikasi
use Laravel\Sanctum\HasApiTokens; // Mengimpor trait HasApiTokens untuk API token (misalnya untuk Laravel Sanctum)

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Menggunakan trait-trait yang diperlukan

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom tabel yang diizinkan untuk diisi menggunakan metode `create` atau `update`
     * dengan array data. Ini penting untuk mencegah kerentanan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',          // Kolom untuk username pengguna (misal: untuk login)
        'name',              // Kolom untuk nama lengkap pengguna
        'email',             // Kolom untuk alamat email pengguna
        'password',          // Kolom untuk password pengguna (akan di-hash)
        'alamat',            // Kolom untuk alamat fisik pengguna
        'jenis_kelamin',     // Kolom untuk jenis kelamin pengguna
        'telepon',           // Kolom untuk nomor telepon pengguna
        'role',              // Kolom untuk peran pengguna (misal: 'siswa', 'guru', 'admin')
        'guru_mata_pelajaran', // Kolom ini mungkin redundan jika 'mapel_id' digunakan untuk guru
        'is_verified',       // Kolom boolean untuk menandai apakah akun sudah diverifikasi admin
        'custom_identifier', // Kolom untuk ID unik kustom (misal: SBS001, SBG001)
        'mapel_id',          // Kolom foreign key ke tabel 'mapel' (untuk guru yang mengajar mapel tertentu)
    ];

    /**
     * Atribut yang harus disembunyikan dari serialisasi array.
     * Ketika model diubah menjadi array atau JSON, kolom-kolom ini tidak akan disertakan.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',       // Password harus selalu disembunyikan
        'remember_token', // Token "remember me" juga harus disembunyikan
    ];

    /**
     * Atribut yang harus di-cast ke tipe data asli.
     * Laravel akan secara otomatis mengonversi nilai kolom ini ke tipe yang ditentukan.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Mengonversi ke objek DateTime
        'password' => 'hashed',            // Mengonversi ke hash password secara otomatis saat disimpan
        'is_verified' => 'boolean',        // Mengonversi ke boolean
    ];

    /**
     * Metode "booted" akan dipanggil setelah model di-boot.
     * Ini adalah tempat yang baik untuk mendaftarkan event listener model.
     * Dalam kasus ini, digunakan untuk menghasilkan 'custom_identifier' sebelum model dibuat.
     */
    protected static function booted()
    {
        // Mendaftarkan event listener 'creating'.
        // Callback ini akan dijalankan sebelum record User baru disimpan ke database.
        static::creating(function ($user) {
            // Hanya menghasilkan custom_identifier jika belum ada dan peran adalah 'siswa' atau 'guru'.
            if (!$user->custom_identifier && in_array($user->role, ['siswa', 'guru'])) {
                // Menentukan prefix berdasarkan peran.
                $prefix = $user->role === 'siswa' ? 'SBS' : 'SBG';

                // Mencari pengguna terakhir dengan peran yang sama dan custom_identifier yang tidak null.
                // Ini untuk menentukan nomor urut berikutnya.
                $last = self::where('role', $user->role)
                            ->whereNotNull('custom_identifier')
                            ->orderByDesc('id') // Mengurutkan berdasarkan ID secara menurun untuk mendapatkan yang terakhir
                            ->first();

                $number = 1; // Nomor awal default.
                // Jika ada pengguna terakhir dan custom_identifier-nya cocok dengan pola nomor,
                // ambil nomornya dan tambahkan 1.
                if ($last && preg_match('/\d+$/', $last->custom_identifier, $matches)) {
                    $number = (int) $matches[0] + 1;
                }

                // Menetapkan custom_identifier baru.
                $user->custom_identifier = $prefix . $number;
            }
        });
    }

    /**
     * Mendefinisikan relasi "has many" dengan model Absensi.
     * Ini berarti satu User (siswa) dapat memiliki banyak record Absensi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absensi()
    {
        // Relasi ini menunjukkan bahwa kolom 'siswa_id' di tabel 'absensi'
        // merujuk pada kolom 'id' di tabel 'users'.
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    /**
     * Mendefinisikan relasi "has many" dengan model Tugas.
     * Ini berarti satu User (guru) dapat memiliki banyak record Tugas yang dibuat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tugas()
    {
        // Relasi ini menunjukkan bahwa kolom 'user_id' di tabel 'tugas'
        // merujuk pada kolom 'id' di tabel 'users'.
        return $this->hasMany(Tugas::class, 'user_id');
    }

    /**
     * Mendefinisikan relasi "belongs to" dengan model Mapel.
     * Ini berarti satu User (guru) dapat terkait dengan satu Mapel yang diajarnya.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mapel()
    {
        // Relasi ini menunjukkan bahwa kolom 'mapel_id' di tabel 'users'
        // merujuk pada kolom 'id' di tabel 'mapel'.
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
}
