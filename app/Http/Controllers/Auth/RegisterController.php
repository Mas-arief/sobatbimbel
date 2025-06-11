<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('daftar'); // Pastikan ini mengarah ke file Blade Anda
    }

    public function register(Request $request)
    {
        // Panggil validator
        $this->validator($request->all())->validate();

        // Buat user baru
        $user = $this->create($request->all());

        // Otomatis login user setelah registrasi
        Auth::login($user);

        // Arahkan user sesuai dengan perannya
        if ($user->role === 'siswa') {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $user->name . '. Silakan lengkapi profil Anda.');
        } elseif ($user->role === 'guru') {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $user->name . '. Silakan lengkapi profil Anda.');
        }

        // Redirect default jika ada masalah atau role tidak terdefinisi
        return redirect('/')->with('success', 'Pendaftaran berhasil!');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'], // 'name' kini wajib diisi di form registrasi
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['siswa', 'guru'])],
            // Field berikut dibuat nullable karena mungkin diisi belakangan atau oleh admin
            'alamat' => ['nullable', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'telepon' => ['nullable', 'string', 'max:20'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'name' => $data['name'], // Simpan nama lengkap
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'alamat' => $data['alamat'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'telepon' => $data['telepon'] ?? null,
            'nisn' => $data['nisn'] ?? null, // Simpan NISN jika ada
            'kelas' => $data['kelas'] ?? null, // Simpan Kelas jika ada
            'guru_mata_pelajaran' => null, // Ini umumnya diisi admin untuk guru
        ]);
    }
}
