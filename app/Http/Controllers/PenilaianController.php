<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Mapel; // Pastikan ini di-import
use App\Models\User;  // Pastikan ini di-import (asumsi siswa adalah User dengan role 'siswa')

class PenilaianController extends Controller
{
    public function index($mapelId, Request $request)
    {
        $mapel = Mapel::findOrFail($mapelId);
        // Ambil hanya user dengan role 'siswa'
        $siswa = User::where('role', 'siswa')->get();

        // Ambil minggu dari request, default ke 1 jika tidak ada
        $selectedMinggu = $request->input('minggu', 1);

        // Ambil semua penilaian yang relevan
        $penilaianData = Penilaian::where('mapel_id', $mapelId)
            ->where('minggu', $selectedMinggu)
            ->get();

        // Buat koleksi yang dikunci oleh siswa_id untuk akses mudah di Blade
        $penilaian = $penilaianData->keyBy('siswa_id');

        return view('guru.penilaian', compact('mapel', 'siswa', 'penilaian', 'selectedMinggu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id',
            'minggu' => 'required|integer|min:1|max:16',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        $mapelId = $request->input('mapel_id');
        $minggu = $request->input('minggu');
        $nilaiData = $request->input('nilai');

        foreach ($nilaiData as $siswaId => $nilai) {
            // Jika nilai kosong atau null, lewati (tidak simpan/update)
            if (is_null($nilai) || $nilai === '') {
                continue;
            }

            Penilaian::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $mapelId,
                    'minggu' => $minggu,
                ],
                [
                    'nilai' => $nilai,
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }
}
