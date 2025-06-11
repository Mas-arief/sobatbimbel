<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User; // Make sure to import the User model

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
        // 1. Validate the incoming request data
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'string', 'in:siswa,guru,admin'],
        ]);

        // 2. Attempt to find the user by username and role
        // We'll manually check the password later to ensure we can also check `is_verified`
        $user = User::where('username', $credentials['username'])
                    ->where('role', $credentials['role'])
                    ->first();

        // 3. Check if user exists and password is correct
        if (!$user || !Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            throw ValidationException::withMessages([
                'username' => ['Username, kata sandi, atau peran salah.'], // More generic error message
            ]);
        }

        // 4. If authentication passes, check verification status
        if (!$user->is_verified) {
            // Log out the user if they somehow got partially authenticated
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'username' => ['Akun Anda belum diverifikasi oleh admin. Mohon tunggu.'],
            ]);
        }

        // 5. If user is verified, regenerate session and redirect based on role
        $request->session()->regenerate();

        switch ($user->role) {
            case 'siswa':
                return redirect()->intended(route('siswa.profile'))->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
            case 'guru':
                return redirect()->intended(route('guru.profile'))->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
            case 'admin':
                // Note: It's good practice to use named routes here if they exist, e.g., route('admin.dashboard')
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
            default:
                Auth::logout(); // Fallback for invalid role
                return redirect('/login')->withErrors(['role' => 'Role tidak valid.']);
        }
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
