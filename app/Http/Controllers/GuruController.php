<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mapel;

class GuruController extends Controller
{
    public function index() // Ini akan menampilkan daftar guru untuk admin
    {
        // === PERBAIKAN DI SINI: Gunakan paginate() untuk efisiensi data besar ===
        $dataGuru = User::where('role', 'guru')->with('mapel')->paginate(10); // Ambil 10 guru per halaman
        // Anda bisa menyesuaikan angka 10 sesuai kebutuhan performa dan desain UI Anda

        $mapelList = Mapel::all(); // Mengambil semua mata pelajaran untuk dropdown di modal
        $tipe = 'admin'; // Variabel 'tipe' ini akan tersedia di view, jika digunakan

        return view('admin.profile_guru', compact('dataGuru', 'mapelList', 'tipe'));
    }

    public function aturMapel(Request $request, $id) // Admin mengedit mapel guru
    {
        $request->validate([
            // Pastikan nama tabel di 'exists' sesuai dengan nama tabel di database Anda
            // Jika nama tabelnya 'mapel' (seperti yang Anda gunakan), itu sudah benar
            'mapel_id' => 'nullable|exists:mapel,id', // Diubah menjadi nullable karena guru bisa saja tidak memiliki mapel_id
        ], [
            'mapel_id.exists' => 'Mata pelajaran yang dipilih tidak valid.'
        ]);

        $guru = User::findOrFail($id);

        // Tambahkan pengecekan role untuk keamanan
        if ($guru->role !== 'guru') {
            return redirect()->back()->with('error', 'User yang Anda coba perbarui bukan seorang guru.');
        }

        $guru->mapel_id = $request->mapel_id;
        $guru->save();

        return redirect()->back()->with('success', 'Mata pelajaran guru berhasil diperbarui.');
    }

    public function destroy($id) // Admin menghapus guru
    {
        // Gunakan where('role', 'guru') untuk memastikan hanya guru yang dapat dihapus melalui rute ini
        $guru = User::where('role', 'guru')->findOrFail($id);

        $guru->delete();

        return redirect()->back()->with('success', 'Akun guru berhasil dihapus.');
    }
}
