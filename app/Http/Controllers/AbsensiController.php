<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function show($mapelId, Request $request)
    {
        $mapel = Mapel::findOrFail($mapelId);
        $siswa = User::where('role', 'siswa')->get();

        // Ambil minggu dari query param (jika ada), default ke 1
        $minggu = $request->query('minggu', 1);

        $tipe = 'guru';
        return view('guru.absensi', compact('mapel', 'siswa', 'minggu', 'tipe'));
    }

    public function store(Request $request)
    {
        $mapelId = $request->input('mapel_id');
        $minggu = $request->input('minggu_ke');
        $kehadiranData = $request->input('kehadiran');
        $keteranganData = $request->input('keterangan');

        foreach ($kehadiranData as $siswaId => $status) {
            Absensi::create([
                'id_siswa' => $siswaId,
                'id_mapel' => $mapelId,
                'minggu_ke' => $minggu,
                'kehadiran' => $status,
                'keterangan' => $keteranganData[$siswaId] ?? null
            ]);
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }
}
