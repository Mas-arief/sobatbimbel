<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mapel;

class GuruController extends Controller
{
    /**
     * Tampilkan daftar guru yang sudah diverifikasi untuk admin.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'guru')
                     ->where('is_verified', true); // Hanya guru yang sudah diverifikasi

        // Pencarian berdasarkan ID kustom atau nama
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('custom_identifier', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $dataGuru = $query->with('mapel')->paginate(10); // Paginasi dan relasi mapel
        $mapelList = Mapel::all(); // Ambil semua mata pelajaran
        $tipe = 'admin'; // Digunakan di view jika diperlukan

        return view('admin.profile_guru', compact('dataGuru', 'mapelList', 'tipe'));
    }

    /**
     * Admin mengatur mapel yang diajarkan oleh guru.
     */
    public function aturMapel(Request $request, $id)
    {
        $request->validate([
            'mapel_id' => 'nullable|exists:mapel,id',
        ], [
            'mapel_id.exists' => 'Mata pelajaran yang dipilih tidak valid.'
        ]);

        $guru = User::findOrFail($id);

        // Pastikan hanya guru yang bisa diubah
        if ($guru->role !== 'guru') {
            return redirect()->back()->with('error', 'User yang Anda coba perbarui bukan seorang guru.');
        }

        $guru->mapel_id = $request->mapel_id;
        $guru->save();

        return redirect()->back()->with('success', 'Mata pelajaran guru berhasil diperbarui.');
    }

    /**
     * Admin menghapus akun guru.
     */
    public function destroy($id)
    {
        // Pastikan yang dihapus adalah guru
        $guru = User::where('role', 'guru')->findOrFail($id);

        $guru->delete();

        return redirect()->back()->with('success', 'Akun guru berhasil dihapus.');
    }
}
