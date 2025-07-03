<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Mapel;
use App\Models\User;
use App\Models\PengumpulanTugas;

class PenilaianController extends Controller
{
    /**
     * Menampilkan form input nilai untuk semua siswa dalam 1 mapel & minggu
     */
    public function index($mapelId, Request $request)
    {
        $mapel = Mapel::findOrFail($mapelId);
        $siswa = User::where('role', 'siswa')->get();
        $minggu = $request->query('minggu', 1);

        $penilaianData = Penilaian::where('mapel_id', $mapelId)
            ->where('minggu', $minggu)
            ->get();

        $penilaian = $penilaianData->keyBy('siswa_id');

        $tipe = 'guru';

        return view('guru.penilaian', compact('mapel', 'siswa', 'penilaian', 'minggu', 'tipe'));
    }

    /**
     * Menyimpan atau memperbarui nilai secara massal
     */
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
            if ($nilai !== null && $nilai !== '') {
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
        }

        return redirect()->route('penilaian.index', ['mapelId' => $mapelId, 'minggu' => $minggu])
                         ->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Menampilkan form edit nilai satu siswa dari halaman rekap tugas
     */
    public function edit($siswaId, $tugasId, $minggu)
    {
        $pengumpulan = PengumpulanTugas::where('siswa_id', $siswaId)
            ->where('minggu_ke', $minggu)
            ->firstOrFail();

        $penilaian = Penilaian::where('siswa_id', $siswaId)
            ->where('minggu', $minggu)
            ->first();

        return view('guru.edit_tugas', compact('pengumpulan', 'penilaian'));
    }

    /**
     * Menyimpan nilai dari form edit nilai satu siswa
     */
    public function simpan(Request $request)
{
    $request->validate([
        'siswa_id' => 'required|integer|exists:users,id',
        'minggu' => 'required|integer|min:1|max:16',
        'nilai' => 'required|integer|min:0|max:100',
    ]);

    // Ambil mapel_id dari model tugas
    $tugas = \App\Models\Tugas::findOrFail($request->tugas_id);
    $mapelId = $tugas->mapel_id;

    Penilaian::updateOrCreate(
        [
            'siswa_id' => $request->siswa_id,
            'minggu' => $request->minggu,
        ],
        [
            'mapel_id' => $mapelId,
            'nilai' => $request->nilai,
        ]
    );

    return redirect()->route('guru.pengumpulan', [
        'mapelId' => $mapelId,
        'minggu' => $request->minggu,
    ])->with('success', 'Nilai berhasil disimpan.');
}

}
