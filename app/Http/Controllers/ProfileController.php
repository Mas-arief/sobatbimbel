<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mapel; // Pastikan Anda mengimpor model Mapel

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Jika profil guru adalah profil user yang sedang login

class ProfileController extends Controller
{
    public function showProfile() // Jika ini profil user yang sedang login
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Jika Anda ingin menampilkan profil guru lain berdasarkan ID, ubah seperti ini:
        // public function showProfile($id) {
        //    $user = User::with('mapel')->findOrFail($id);
        // }

        // Pastikan Anda memuat relasi 'mapel' jika user memiliki mapel
        $user->load('mapel');

        // Ambil daftar semua mata pelajaran untuk dropdown di modal
        $mapelList = Mapel::all();
$tipe = $user->role;
        // Teruskan $user dan $mapelList ke view
        return view('guru.profile', compact('user', 'mapelList', 'tipe'));
    }

    // ... metode lain jika ada (misal updateProfile)
    public function updateProfile(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'mapel_id' => 'nullable|exists:mapel,id', // Pastikan mapel_id ada di tabel mapel
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->mapel_id = $request->mapel_id; // Simpan mapel_id
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->telepon = $request->telepon;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
