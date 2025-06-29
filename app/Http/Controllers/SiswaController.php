<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa')
                     ->where('is_verified', true);

        // Cek jika ada input pencarian dari user
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('custom_identifier', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $dataSiswa = $query->paginate(10);
        $tipe = 'admin';

        return view('admin.profile_siswa', compact('dataSiswa', 'tipe'));
    }

    public function destroy(User $siswa)
    {
        if ($siswa->role !== 'siswa') {
            return redirect()->route('admin.profile_siswa.index')->with('error', 'Hanya siswa yang dapat dihapus dari daftar ini.');
        }

        $siswa->delete();

        return redirect()->route('admin.profile_siswa.index')->with('success', 'Akun siswa berhasil dihapus.');
    }
}
