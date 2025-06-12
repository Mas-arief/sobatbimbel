<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\User; // <-- WAJIB ditambahkan
use App\Models\Penilaian; // <-- WAJIB ditambahkan

class PenilaianController extends Controller
{
    public function index($mapelId)
    {
        $mapel = Mapel::findOrFail($mapelId);
        $siswa = User::where('role', 'siswa')->get();

        // Ambil data penilaian jika sudah pernah dinilai
        $penilaian = Penilaian::where('mapel_id', $mapelId)->get()->groupBy('user_id');

        return view('guru.penilaian.index', compact('mapel', 'siswa', 'penilaian'));
    }

    public function store(Request $request)
    {
        $mapelId = $request->input('mapel_id');
        $nilaiData = $request->input('nilai'); // nilai adalah array: [user_id => nilai]

        foreach ($nilaiData as $userId => $nilai) {
            Penilaian::updateOrCreate(
                ['user_id' => $userId, 'mapel_id' => $mapelId], // kondisi update
                ['nilai' => $nilai]                             // data yang diisi
            );
        }

        return redirect()->route('penilaian.index', ['mapelId' => $mapelId])
            ->with('success', 'Penilaian berhasil disimpan.');
    }
}
