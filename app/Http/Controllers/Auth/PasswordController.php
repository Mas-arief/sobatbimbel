<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Mengimpor Facade Hash untuk hashing password
use Illuminate\Support\Facades\Auth; // Mengimpor Facade Auth untuk otentikasi pengguna
use Illuminate\Validation\ValidationException; // Mengimpor ValidationException untuk menangani kesalahan validasi

class PasswordController extends Controller
{
    /**
     * Menampilkan formulir ganti password.
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        // Mengembalikan view 'ganti_sandi' yang berisi formulir untuk mengubah kata sandi.
        return view('ganti_sandi');
    }

    /**
     * Memproses permintaan ganti password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        // Validasi input dari permintaan.
        // Memastikan 'current_password' ada, 'password' ada, string, minimal 8 karakter,
        // dan 'password_confirmation' cocok dengan 'password'.
        $request->validate([
            'current_password' => ['required', 'string'], // Password lama wajib diisi dan harus berupa string.
            'password' => ['required', 'string', 'min:8', 'confirmed'], // Password baru wajib diisi, string, minimal 8 karakter, dan harus dikonfirmasi.
        ]);

        // Memeriksa apakah password lama yang dimasukkan cocok dengan password yang tersimpan di database untuk pengguna yang sedang login.
        // Hash::check() membandingkan string plain-text dengan hash.
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            // Jika password lama tidak cocok, lempar pengecualian validasi dengan pesan kesalahan.
            throw ValidationException::withMessages([
                'current_password' => ['Password lama tidak cocok.'], // Pesan kesalahan spesifik untuk password lama.
            ]);
        }

        // Memperbarui password pengguna yang sedang login.
        // Auth::user() mendapatkan instance model User dari pengguna yang saat ini terautentikasi.
        // Hash::make() mengenkripsi password baru sebelum disimpan ke database.
        $user = Auth::user();
/** @var \App\Models\User $user */
$user->update([
    'password' => Hash::make($request->password),
]);


        // Mengarahkan pengguna kembali ke halaman login dengan pesan sukses.
        // Ini memastikan pengguna harus login kembali dengan password baru mereka.
        return redirect('/login')->with('success', 'Kata sandi Anda berhasil diperbarui!');
    }
}
