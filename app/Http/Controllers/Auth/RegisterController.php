<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Make sure to import the User model
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
        // 1. Validate the incoming request data
        $this->validator($request->all())->validate();

        // 2. Create the new user with is_verified set to false
        $user = $this->create($request->all());

        // 3. Instead of logging in, redirect to login with a success message
        // The message will inform the user about admin verification.
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Akun Anda akan diverifikasi oleh admin. Mohon tunggu.');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', Rule::in(['siswa', 'guru'])], // 'admin' should not be an option for public registration
            'alamat' => ['nullable', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'telepon' => ['nullable', 'string', 'max:20'],
            // Add validation for 'nisn' and 'kelas' if they are submitted from the form
            // 'nisn' => ['nullable', 'string', 'max:20', 'unique:users'],
            // 'kelas' => ['nullable', 'string', 'max:50'],
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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'alamat' => $data['alamat'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'telepon' => $data['telepon'] ?? null,
            'is_verified' => false, // <--- PENTING: Set ke false secara default
            // 'nisn' => $data['nisn'] ?? null,
            // 'kelas' => $data['kelas'] ?? null,
            'guru_mata_pelajaran' => null, // Ini umumnya diisi admin untuk guru
        ]);
    }
}
