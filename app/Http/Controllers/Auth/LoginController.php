<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User; // Pastikan untuk mengimpor model User

class LoginController extends Controller
{
    /**
     * Menampilkan formulir login aplikasi.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Mengembalikan view 'login' yang berisi formulir untuk memasukkan kredensial login.
        return view('login');
    }

    /**
     * Menangani permintaan login ke aplikasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // 1. Memvalidasi data permintaan yang masuk.
        // Memastikan 'username', 'password', dan 'role' ada dan sesuai format yang diharapkan.
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'string', 'in:siswa,guru,admin'], // Memastikan role adalah salah satu dari 'siswa', 'guru', atau 'admin'.
        ]);

        // 2. Mencoba menemukan pengguna berdasarkan username dan role.
        // Ini dilakukan secara terpisah dari Auth::attempt() agar kita bisa memeriksa `is_verified` nanti.
        $user = User::where('username', $credentials['username'])
                     ->where('role', $credentials['role'])
                     ->first(); // Mengambil satu baris pertama yang cocok.

        // 3. Memeriksa apakah pengguna ada dan kata sandi benar.
        // Auth::attempt() mencoba mengautentikasi pengguna dengan kredensial yang diberikan.
        if (!$user || !Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            // Jika pengguna tidak ditemukan atau autentikasi gagal, lempar pengecualian validasi.
            throw ValidationException::withMessages([
                'username' => ['Username, kata sandi, atau peran salah.'], // Pesan kesalahan umum untuk keamanan.
            ]);
        }

        // 4. Jika autentikasi berhasil, periksa status verifikasi pengguna.
        if (!$user->is_verified) {
            // Jika akun belum diverifikasi, lakukan logout pengguna agar tidak tetap terautentikasi.
            Auth::logout();
            // Menghapus semua data sesi.
            $request->session()->invalidate();
            // Meregenerasi token CSRF untuk mencegah serangan CSRF pada sesi yang baru.
            $request->session()->regenerateToken();

            // Lempar pengecualian validasi dengan pesan khusus untuk akun yang belum diverifikasi.
            throw ValidationException::withMessages([
                'username' => ['Akun Anda belum diverifikasi oleh admin. Mohon tunggu.'],
            ]);
        }

        // 5. Jika pengguna terverifikasi, regenerasi sesi dan arahkan berdasarkan peran.
        // Meregenerasi ID sesi untuk mencegah serangan fiksasi sesi.
        $request->session()->regenerate();

        // Mengarahkan pengguna ke dashboard yang sesuai berdasarkan perannya.
        switch ($user->role) {
            case 'siswa':
                // Mengarahkan ke route 'siswa.profile' jika pengguna adalah siswa.
                // intended() akan mengarahkan ke URL yang sebelumnya ingin diakses pengguna sebelum login, jika ada.
                return redirect()->intended(route('siswa.profile'))->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
            case 'guru':
                // Mengarahkan ke route 'guru.profile' jika pengguna adalah guru.
                return redirect()->intended(route('guru.profile'))->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
            case 'admin':
                // Mengarahkan ke route 'admin.dashboard' jika pengguna adalah admin.
                // Disarankan menggunakan named routes seperti route('admin.dashboard') jika sudah didefinisikan.
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
            default:
                // Fallback jika peran tidak valid (seharusnya tidak terjadi jika validasi peran sudah ketat).
                Auth::logout(); // Logout pengguna.
                return redirect('/login')->withErrors(['role' => 'Role tidak valid.']);
        }
    }


    /**
     * Mencatat user keluar dari aplikasi (logout).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Melakukan logout pengguna saat ini. Ini akan menghapus informasi autentikasi dari sesi.
        Auth::logout();

        // Membatalkan sesi pengguna saat ini. Semua data sesi akan dihapus.
        $request->session()->invalidate();
        // Meregenerasi token CSRF baru setelah sesi dibatalkan untuk keamanan.
        $request->session()->regenerateToken();

        // Mengarahkan pengguna kembali ke halaman login dengan pesan sukses.
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
