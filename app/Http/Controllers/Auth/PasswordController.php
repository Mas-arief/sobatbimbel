<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Tampilkan form ganti password.
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Proses permintaan ganti password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Cek apakah password lama cocok
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Password lama tidak cocok.'],
            ]);
        }

        // Update password pengguna
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Kata sandi Anda berhasil diperbarui!');
    }
}
