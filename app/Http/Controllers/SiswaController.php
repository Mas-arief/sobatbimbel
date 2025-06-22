<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan model User diimpor

class SiswaController extends Controller
{
    public function index()
    {
        // Gunakan paginate() untuk efisiensi saat menampung banyak data
        $dataSiswa = User::where('role', 'siswa')->paginate(10); // Tampilkan 10 siswa per halaman
        // $tipe tidak digunakan dalam konteks ini, bisa dihapus jika tidak ada logika khusus yang memerlukannya di view
        // Jika Anda masih memerlukannya, pastikan variabel $tipe sudah didefinisikan sebelumnya
        // Contoh: $tipe = 'admin';
$tipe='admin';
        return view('admin.profile_siswa', compact('dataSiswa', 'tipe')); // Kirim $dataSiswa ke view
    }

    public function destroy(User $siswa) // Menggunakan Route Model Binding
    {
        // Validasi tambahan untuk memastikan yang dihapus adalah siswa
        // Type hinting User $siswa sudah otomatis menemukan siswa berdasarkan ID
        if ($siswa->role !== 'siswa') {
            return redirect()->route('admin.profile_siswa.index')->with('error', 'Hanya siswa yang dapat dihapus dari daftar ini.');
        }

        $siswa->delete();
        // Redirect ke rute index siswa yang sudah dinamakan
        return redirect()->route('admin.profile_siswa.index')->with('success', 'Akun siswa berhasil dihapus.');
    }
}
