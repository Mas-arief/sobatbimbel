<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use App\Models\User; // Mengimpor model User untuk berinteraksi dengan data pengguna

class AdminController extends Controller
{
    /**
     * Menampilkan halaman verifikasi admin.
     * Halaman ini akan menampilkan daftar guru dan siswa yang belum diverifikasi.
     *
     * @return \Illuminate\View\View
     */
    public function verifikasi()
    {
        // Mengambil semua pengguna dengan peran 'guru' yang belum diverifikasi (is_verified = false atau null).
        $guru = User::where('role', 'guru')
            ->where('is_verified', false)
            ->get();

        // Mengambil semua pengguna dengan peran 'siswa' yang belum diverifikasi (is_verified = false atau null).
        $siswa = User::where('role', 'siswa')
            ->where('is_verified', false)
            ->get();

        // Menentukan tipe pengguna sebagai 'admin' untuk keperluan view.
        $tipe = 'admin';

        // Mengembalikan view 'admin.verifikasi' dengan data guru, siswa, dan tipe yang sudah diambil.
        return view('admin.verifikasi', compact('guru', 'siswa', 'tipe'));
    }

    /**
     * Verifikasi pengguna secara individual (dari tombol terima/tolak).
     * Metode ini digunakan untuk menerima atau menolak akun pengguna.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP.
     * @param  string  $userId ID pengguna yang akan diverifikasi atau ditolak.
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser(Request $request, string $userId)
    {
        // Memvalidasi input 'action' dari permintaan.
        // Memastikan 'action' wajib ada, berupa string, dan hanya boleh 'accept' atau 'reject'.
        $request->validate([
            'action' => ['required', 'string', 'in:accept,reject'],
        ]);

        // Mencari pengguna berdasarkan ID yang diberikan.
        $user = User::find($userId);

        // Memeriksa apakah pengguna ditemukan.
        if (!$user) {
            // Jika pengguna tidak ditemukan, kembalikan respons JSON dengan pesan error 404.
            return response()->json(['message' => 'Pengguna tidak ditemukan.'], 404);
        }

        // Melakukan aksi berdasarkan nilai 'action' yang diterima.
        if ($request->action === 'accept') {
            // Jika 'action' adalah 'accept', set 'is_verified' pengguna menjadi true.
            $user->is_verified = true;
            // Menyimpan perubahan ke database.
            $user->save();
            // Menyiapkan pesan sukses.
            $message = 'Pengguna ' . $user->name . ' berhasil diverifikasi.';
        } else {
            // Jika 'action' adalah 'reject', hapus pengguna dari database.
            $user->delete();
            // Menyiapkan pesan sukses untuk penolakan dan penghapusan.
            $message = 'Pengguna ' . $user->name . ' telah ditolak dan dihapus.';
        }

        // Mengembalikan respons JSON dengan pesan hasil operasi.
        return response()->json(['message' => $message]);
    }

    /**
     * Verifikasi semua guru dan siswa sekaligus.
     * Metode ini akan memverifikasi semua akun guru dan siswa yang belum diverifikasi.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifikasiSemua()
    {
        try {
            // Mencari semua pengguna dengan peran 'guru' atau 'siswa'.
            User::whereIn('role', ['guru', 'siswa'])
                // Menambahkan kondisi untuk hanya memilih pengguna yang 'is_verified' adalah null atau false.
                ->where(function ($query) {
                    $query->whereNull('is_verified')->orWhere('is_verified', false);
                })
                // Memperbarui kolom 'is_verified' menjadi true untuk semua pengguna yang cocok.
                ->update(['is_verified' => true]);

            // Mengarahkan kembali ke halaman sebelumnya dengan pesan sukses.
            return redirect()->back()->with('success', 'Semua guru dan siswa berhasil diverifikasi.');
        } catch (\Exception $e) {
            // Menangani pengecualian jika terjadi kesalahan selama proses verifikasi.
            // Mengarahkan kembali dengan pesan error yang berisi detail kesalahan.
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memverifikasi semua: ' . $e->getMessage());
        }
    }
}
