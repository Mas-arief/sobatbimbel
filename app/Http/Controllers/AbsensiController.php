<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Method 1: Ambil minggu dari parameter URL
     */
    public function index(Request $request, $mingguKe = null)
    {
        $tipe = 'guru';

        // Cek apakah tabel absensi ada
        if (!Schema::hasTable('absensi')) {
            return back()->withErrors('Tabel absensi tidak ditemukan di database.');
        }

        // Ambil mapel (sementara ambil pertama, idealnya berdasarkan login guru)
        $mapel = Mapel::first();
        if (!$mapel) {
            return back()->withErrors('Data mapel tidak ditemukan.');
        }

        // Tentukan minggu ke berapa
        if ($mingguKe) {
            // Jika ada parameter minggu dari URL
            $mingguKe = (int) $mingguKe;
        } elseif ($request->has('minggu_ke')) {
            // Jika ada dari request (form/query parameter)
            $mingguKe = (int) $request->minggu_ke;
        } else {
            // Default: ambil minggu terbaru dari database atau hitung otomatis
            $mingguKe = $this->getCurrentMingguKe($mapel->id);
        }

        // Ambil data absensi sesuai mapel dan minggu
        $absensi = Absensi::with('siswa')
            ->where('id_mapel', $mapel->id)
            ->where('minggu_ke', $mingguKe)
            ->get();

        // Ambil daftar minggu yang tersedia untuk dropdown
        $availableWeeks = $this->getAvailableWeeks($mapel->id);

        return view('guru.absensi', compact('absensi', 'mapel', 'mingguKe', 'tipe', 'availableWeeks'));
    }

    /**
     * Method 2: Index dengan dropdown minggu
     */
    public function indexWithDropdown(Request $request)
    {
        $tipe = 'guru';

        // Cek apakah tabel absensi ada
        if (!Schema::hasTable('absensi')) {
            return back()->withErrors('Tabel absensi tidak ditemukan di database.');
        }

        // Ambil mapel
        $mapel = Mapel::first();
        if (!$mapel) {
            return back()->withErrors('Data mapel tidak ditemukan.');
        }

        // Ambil minggu dari request atau default ke minggu terbaru
        $mingguKe = $request->get('minggu_ke', $this->getLatestMingguKe($mapel->id));

        // Ambil data absensi
        $absensi = Absensi::with('siswa')
            ->where('id_mapel', $mapel->id)
            ->where('minggu_ke', $mingguKe)
            ->get();

        // Ambil semua minggu yang tersedia
        $availableWeeks = $this->getAvailableWeeks($mapel->id);

        return view('guru.absensi', compact('absensi', 'mapel', 'mingguKe', 'tipe', 'availableWeeks'));
    }

    /**
     * Method 3: Create dengan minggu otomatis
     */
    public function create(Request $request, $mapelId = null)
    {
        $mapelId = $mapelId ?? $request->mapel_id;

        if (!$mapelId) {
            return back()->withErrors('ID Mapel tidak ditemukan.');
        }

        $mapel = Mapel::findOrFail($mapelId);

        // Hitung minggu ke berapa berdasarkan tanggal
        $mingguKe = $this->calculateCurrentWeek();

        // Atau ambil minggu terbaru + 1
        // $mingguKe = $this->getNextMingguKe($mapelId);

        // Ambil siswa dari kelas yang sama dengan mapel
        $siswa = User::where('role', 'siswa')
            ->where('kelas_id', $mapel->kelas_id) // asumsi ada kolom kelas_id
            ->get();

        // Buat atau ambil data absensi untuk minggu ini
        $absensi = collect();
        foreach ($siswa as $s) {
            $absenRecord = Absensi::firstOrCreate([
                'id_siswa' => $s->id,
                'id_mapel' => $mapelId,
                'minggu_ke' => $mingguKe
            ], [
                'kehadiran' => false,
                'keterangan' => ''
            ]);

            $absensi->push($absenRecord);
        }

        return view('guru.absensi', compact('absensi', 'mapel', 'mingguKe'));
    }

    /**
     * Store method yang sudah ada
     */
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

    /**
     * Helper Methods
     */

    /**
     * Ambil minggu terbaru dari database untuk mapel tertentu
     */
    private function getLatestMingguKe($mapelId)
    {
        $latest = Absensi::where('id_mapel', $mapelId)
            ->max('minggu_ke');

        return $latest ?? 1; // default ke minggu 1 jika belum ada data
    }

    /**
     * Ambil minggu berikutnya (untuk input baru)
     */
    private function getNextMingguKe($mapelId)
    {
        $latest = $this->getLatestMingguKe($mapelId);
        return $latest + 1;
    }

    /**
     * Ambil minggu saat ini berdasarkan tanggal atau default
     */
    private function getCurrentMingguKe($mapelId)
    {
        // Option 1: Berdasarkan minggu terbaru di database
        $latest = $this->getLatestMingguKe($mapelId);

        // Option 2: Berdasarkan perhitungan tanggal
        // $mingguSekarang = $this->calculateCurrentWeek();

        return $latest;
    }

    /**
     * Hitung minggu berdasarkan tanggal semester
     */
    private function calculateCurrentWeek()
    {
        // Asumsi semester dimulai tanggal tertentu
        $semesterStart = Carbon::create(2024, 8, 1); // Contoh: 1 Agustus 2024
        $now = Carbon::now();

        $weeksDiff = $semesterStart->diffInWeeks($now);

        return max(1, $weeksDiff + 1); // minimum minggu ke-1
    }

    /**
     * Ambil semua minggu yang tersedia untuk dropdown
     */
    private function getAvailableWeeks($mapelId)
    {
        $weeks = Absensi::where('id_mapel', $mapelId)
            ->distinct()
            ->pluck('minggu_ke')
            ->sort()
            ->values();

        // Jika belum ada data, buat default 1-16 minggu
        if ($weeks->isEmpty()) {
            $weeks = collect(range(1, 16));
        }

        return $weeks;
    }

    /**
     * Method untuk API/AJAX - ambil data berdasarkan minggu
     */
    public function getByWeek(Request $request)
    {
        $mapelId = $request->mapel_id;
        $mingguKe = $request->minggu_ke;

        $absensi = Absensi::with('siswa')
            ->where('id_mapel', $mapelId)
            ->where('minggu_ke', $mingguKe)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $absensi,
            'minggu_ke' => $mingguKe
        ]);
    }

    /**
     * Method untuk menampilkan semua minggu dalam satu mapel
     */
    public function showAllWeeks($mapelId)
    {
        $mapel = Mapel::findOrFail($mapelId);

        $absensiByWeeks = Absensi::with('siswa')
            ->where('id_mapel', $mapelId)
            ->get()
            ->groupBy('minggu_ke')
            ->sortKeys();

        return view('guru.absensi-all-weeks', compact('mapel', 'absensiByWeeks'));
    }
}
