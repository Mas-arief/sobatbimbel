<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Menampilkan halaman verifikasi admin.
     *
     * @return \Illuminate\View\View
     */
    public function verifikasi()
    {
        $guru = User::where('role', 'guru')
            ->where('is_verified', false)
            ->get();

        $siswa = User::where('role', 'siswa')
            ->where('is_verified', false)
            ->get();

        $tipe = 'admin';

        return view('admin.verifikasi', compact('guru', 'siswa', 'tipe'));
    }

    /**
     * Verifikasi individual user (dari tombol terima/tolak).
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
        } else {
            $user->delete();
            $message = 'Pengguna ' . $user->name . ' telah ditolak dan dihapus.';
        }

        return response()->json(['message' => $message]);
    }

    /**
     * Verifikasi semua guru dan siswa sekaligus.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifikasiSemua()
    {
        try {
            User::whereIn('role', ['guru', 'siswa'])
                ->where(function ($query) {
                    $query->whereNull('is_verified')->orWhere('is_verified', false);
                })
                ->update(['is_verified' => true]);

            return redirect()->back()->with('success', 'Semua guru dan siswa berhasil diverifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memverifikasi semua: ' . $e->getMessage());
        }
    }
}
