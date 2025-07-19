<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // Mengimpor kelas Controller dasar
use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use App\Models\User; // Mengimpor model User untuk berinteraksi dengan data pengguna

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa yang sudah diverifikasi untuk admin.
     * Metode ini juga mendukung fungsionalitas pencarian berdasarkan ID kustom atau nama siswa.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang mungkin berisi parameter pencarian.
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Memulai query untuk mengambil pengguna dengan peran 'siswa' yang sudah diverifikasi.
        $query = User::where('role', 'siswa')
                     ->where('is_verified', true); // Hanya siswa yang sudah diverifikasi yang akan ditampilkan.

        // Memeriksa jika ada input pencarian dari pengguna.
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search; // Mengambil nilai pencarian.

            // Menambahkan kondisi WHERE untuk mencari di kolom 'custom_identifier' atau 'name'.
            $query->where(function ($q) use ($search) {
                $q->where('custom_identifier', 'like', "%{$search}%") // Mencari ID kustom yang mengandung string pencarian.
                  ->orWhere('name', 'like', "%{$search}%"); // Atau mencari nama yang mengandung string pencarian.
            });
        }

        // Mengambil data siswa dengan paginasi (10 item per halaman).
        $dataSiswa = $query->paginate(10);
        // Menentukan tipe pengguna sebagai 'admin' untuk keperluan view.
        $tipe = 'admin';

        // Mengembalikan view 'admin.profile_siswa' dengan data siswa dan tipe.
        return view('admin.profile_siswa', compact('dataSiswa', 'tipe'));
    }

    /**
     * Menghapus akun siswa.
     * Metode ini digunakan oleh admin untuk menghapus akun siswa dari sistem.
     *
     * @param  \App\Models\User  $siswa Instance model User yang akan dihapus (Route Model Binding).
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $siswa)
    {
        // Memastikan bahwa pengguna yang akan dihapus memiliki peran 'siswa'.
        if ($siswa->role !== 'siswa') {
            // Jika bukan siswa, arahkan kembali dengan pesan error.
            return redirect()->route('admin.profile_siswa.index')->with('error', 'Hanya siswa yang dapat dihapus dari daftar ini.');
        }

        // Menghapus record siswa dari database.
        $siswa->delete();

        // Mengarahkan kembali ke halaman daftar siswa dengan pesan sukses.
        return redirect()->route('admin.profile_siswa.index')->with('success', 'Akun siswa berhasil dihapus.');
    }
}
