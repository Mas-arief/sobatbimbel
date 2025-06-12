<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AbsensiController extends Controller
{
    public function index()
    {
        $mingguKe = 2; // contoh, bisa diganti dari request nanti
        $tipe = 'guru';

        // Cek apakah tabel absensis ada
        if (!Schema::hasTable('absensis')) {
            return back()->withErrors('Tabel absensis tidak ditemukan di database.');
        }

        // Ambil mapel (sementara ambil pertama, idealnya berdasarkan login guru)
        $mapel = Mapel::first();
        if (!$mapel) {
            return back()->withErrors('Data mapel tidak ditemukan.');
        }

        // Ambil data absensi sesuai mapel dan minggu
        $absensi = Absensi::with('siswa')
            ->where('id_mapel', $mapel->id)
            ->where('minggu_ke', $mingguKe)
            ->get();

        return view('guru.absensi', compact('absensi', 'mapel', 'mingguKe', 'tipe'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|array',
            'mapel_id' => 'required|exists:mapel,id',
            'minggu_ke' => 'required|integer',
        ]);

        foreach ($request->siswa_id as $index => $siswaId) {
            Absensi::updateOrCreate(
                [
                    'id_siswa' => $siswaId,
                    'id_mapel' => $request->mapel_id,
                    'minggu_ke' => $request->minggu_ke,
                ],
                [
                    'kehadiran' => isset($request->kehadiran[$index]) ? true : false,
                    'keterangan' => $request->keterangan[$index] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }

    // Jika langsung dari tabel users
    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        return view('absensi.create', compact('siswa'));
    }
}
