<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class ProfileeController extends Controller
{
    public function index()
    {
        $user = (object) [
            'id' => '12345',
            'name' => 'John Doe',
            'alamat' => 'Jl. Mawar No. 1',
            'jenis_kelamin' => 'Laki-laki',
            'telepon' => '08123456789',
            'email' => 'johndoe@example.com',
        ];

        $tipe = 'siswa'; // Asumsikan ini adalah profil siswa, sesuaikan jika perlu

        return view('siswa.profile', compact('user', 'tipe'));
    }
}
