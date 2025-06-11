<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan Anda mengimpor model User dengan benar

class AdminController extends Controller
{
    /**
     * Menampilkan halaman verifikasi admin.
     * Mengambil data guru dan siswa yang menunggu verifikasi.
     *
     * @return \Illuminate\View\View
     */
    public function verifikasi()
    {

        $guru = User::where('role', 'guru')
            ->where('is_verified', false)
            ->get(); // <-- Ini harus mengembalikan Collection

        // Ambil user yang berperan sebagai 'siswa' dan belum diverifikasi
        $siswa = User::where('role', 'siswa')
            ->where('is_verified', false)
            ->get(); // <-- Ini juga harus mengembalikan Collection

        // Lewatkan variabel $guru dan $siswa ke view
        // Pastikan variabel ini berupa Collection (hasil dari ->get())
        return view('admin.verifikasi', compact('guru', 'siswa'));
    }

    /**
     * Menangani proses verifikasi (menerima atau menolak) user melalui API.
     * Ini adalah bagian yang dipanggil oleh JavaScript Anda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser(Request $request, string $userId)
    {
        $request->validate([
            'action' => ['required', 'string', 'in:accept,reject'],
        ]);

        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan.'], 404);
        }

        if ($request->action === 'accept') {
            $user->is_verified = true;
            $user->save();
            $message = 'Pengguna ' . $user->name . ' berhasil diverifikasi.';
        } else { // 'reject'
            $user->delete();
            $message = 'Pengguna ' . $user->name . ' telah ditolak dan dihapus.';
        }

        return response()->json(['message' => $message]);
    }
}
