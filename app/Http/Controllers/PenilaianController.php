<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PenilaianController extends Controller
{
    /**
     * Menampilkan form input nilai untuk guru.
     */
    public function index($mapelId, Request $request)
    {
        $mapel = Mapel::findOrFail($mapelId);
        // Ambil hanya user dengan role 'siswa'
        $siswa = User::where('role', 'siswa')->get();

        // Ambil minggu dari query param (jika ada), default ke 1
        $minggu = $request->query('minggu', 1);

        // Ambil semua penilaian yang relevan untuk mapel dan minggu ini
        $penilaianData = Penilaian::where('mapel_id', $mapelId)
            ->where('minggu', $minggu) // Menggunakan kolom 'minggu'
            ->get();

        // Buat koleksi yang dikunci oleh siswa_id untuk akses mudah di Blade
        // Ini memungkinkan kita menggunakan $penilaian->get($s->id)?->nilai
        $penilaian = $penilaianData->keyBy('siswa_id');

        $tipe = 'guru'; // Variabel untuk menentukan tipe user di layout
        return view('guru.penilaian', compact('mapel', 'siswa', 'penilaian', 'minggu', 'tipe'));
    }

    /**
     * Menyimpan atau memperbarui nilai yang dikirim oleh guru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id',
            'minggu' => 'required|integer|min:1|max:16',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|integer|min:0|max:100',
        ]);

        $mapelId = $request->input('mapel_id');
        $minggu = $request->input('minggu');
        $nilaiData = $request->input('nilai');

        Log::info('Penilaian Store Request:', [
            'mapel_id' => $mapelId,
            'minggu' => $minggu,
            'nilaiData' => $nilaiData,
        ]);

        foreach ($nilaiData as $siswaId => $nilai) {
            if (is_null($nilai) || $nilai === '') {
                Log::info("Melewati nilai kosong untuk Siswa ID: {$siswaId}.");
                continue;
            }

            try {
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
                Log::info("Nilai untuk Siswa ID: {$siswaId} berhasil disimpan/diperbarui: {$nilai}.");

            } catch (\Exception $e) {
                Log::error("Gagal menyimpan/memperbarui nilai untuk Siswa ID: {$siswaId}. Error: " . $e->getMessage());
                return redirect()->back()->with('error', 'Gagal menyimpan nilai. Error: ' . $e->getMessage());
            }
        }

        // --- PERUBAHAN PENTING DI SINI ---
        // Alih-alih redirect()->back(), arahkan secara eksplisit kembali ke halaman input nilai untuk minggu yang sama
        return redirect()->route('penilaian.index', ['mapelId' => $mapelId, 'minggu' => $minggu])
                         ->with('success', 'Nilai berhasil disimpan!');
    }
}
