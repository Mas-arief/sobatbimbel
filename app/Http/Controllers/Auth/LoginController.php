<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
        'role' => ['required', 'string', 'in:siswa,guru,admin'], // Validasi role
    ]);

    if (Auth::attempt([
        'username' => $credentials['username'],
        'password' => $credentials['password'],
        'role' => $credentials['role']
    ])) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'siswa':
                return redirect()->intended('/siswa.profile')->with('success', 'Login berhasil! Selamat datang, ' . $user->username);
            case 'guru':
                return redirect()->intended('/guru.profile')->with('success', 'Login berhasil! Selamat datang, ' . $user->username);
            case 'admin':
                return redirect()->intended('/admin.dashboard-admin')->with('success', 'Login berhasil! Selamat datang, ' . $user->username);
            default:
                Auth::logout(); // sebagai pengaman tambahan
                return redirect('/login')->withErrors(['role' => 'Role tidak valid.']);
        }
    }

    // Jika gagal login
    throw ValidationException::withMessages([
        'username' => ['Username atau kata sandi salah.'],
    ]);
}


    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate(); // Hapus sesi
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
