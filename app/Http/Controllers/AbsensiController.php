<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Support\Facades\Log; // Tambahkan ini untuk debugging

class AbsensiController extends Controller
{
    /**
     * Menampilkan form absensi untuk guru.
     */
    public function show($mapelId, Request $request)
    {
        $mapel = Mapel::findOrFail($mapelId);
        $siswa = User::where('role', 'siswa')->get();

        // Ambil minggu dari query param (jika ada), default ke 1
        $minggu = $request->query('minggu', 1);

        // Ambil data absensi yang sudah ada untuk mapel dan minggu ini
        // untuk ditampilkan di form (jika ada)
        $absensiTersimpan = Absensi::where('id_mapel', $mapelId)
                                   ->where('minggu_ke', $minggu)
                                   ->get()
                                   ->keyBy('id_siswa'); // Kunci koleksi berdasarkan id_siswa

        $tipe = 'guru';
        return view('guru.absensi', compact('mapel', 'siswa', 'minggu', 'tipe', 'absensiTersimpan'));
    }

    /**
     * Menyimpan data absensi yang dikirim oleh guru.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'mapel_id' => ['required', 'integer', 'exists:mapel,id'],
            'minggu_ke' => ['required', 'integer', 'min:1', 'max:16'], // Asumsi minggu dari 1-16
            'kehadiran' => ['required', 'array'], // Pastikan 'kehadiran' adalah array
            // Setiap nilai dalam array 'kehadiran' harus salah satu dari enum
            'kehadiran.*' => ['required', 'string', 'in:hadir,izin,sakit,alpha'], // Perhatikan 'alpha' dengan 'h'
            'keterangan' => ['nullable', 'array'], // 'keterangan' juga bisa array
            'keterangan.*' => ['nullable', 'string', 'max:255'], // Setiap keterangan bersifat opsional
        ]);

        $mapelId = $request->input('mapel_id');
        $minggu = $request->input('minggu_ke');
        $kehadiranData = $request->input('kehadiran'); // Ini adalah array [siswa_id => status_kehadiran]
        $keteranganData = $request->input('keterangan'); // Ini adalah array [siswa_id => keterangan]

        // --- Logging untuk Debugging (bisa dihapus setelah yakin berfungsi) ---
        Log::info('Absensi Store Request:', [
            'mapel_id' => $mapelId,
            'minggu_ke' => $minggu,
            'kehadiranData' => $kehadiranData,
            'keteranganData' => $keteranganData,
        ]);
        // --- End Logging ---

        foreach ($kehadiranData as $siswaId => $status) {
            try {
                // 2. Gunakan updateOrCreate untuk mencegah duplikasi dan memperbarui yang sudah ada
                Absensi::updateOrCreate(
                    [
                        'id_siswa' => $siswaId,
                        'id_mapel' => $mapelId,
                        'minggu_ke' => $minggu,
                    ],
                    [
                        'kehadiran' => $status,
                        // Ambil keterangan spesifik untuk siswa ini. Jika tidak ada, gunakan null.
                        'keterangan' => $keteranganData[$siswaId] ?? null,
                    ]
                );
                Log::info("Absensi untuk Siswa ID: {$siswaId} berhasil disimpan/diperbarui dengan status: {$status}.");

            } catch (\Exception $e) {
                // Tangani kesalahan jika ada masalah saat menyimpan absensi untuk siswa tertentu
                Log::error("Gagal menyimpan/memperbarui absensi untuk Siswa ID: {$siswaId}. Error: " . $e->getMessage());
                // Anda bisa memilih untuk mengembalikan error di sini atau melanjutkan loop
                // Untuk sekarang, kita log dan melanjutkan agar tidak menghentikan proses untuk siswa lain.
                // return back()->with('error', 'Gagal menyimpan absensi untuk beberapa siswa.');
            }
        }

        // --- PERUBAHAN PENTING DI SINI ---
        // Alih-alih redirect()->back(), arahkan secara eksplisit kembali ke halaman input absensi untuk minggu yang sama
        return redirect()->route('guru.absensi.show', ['mapelId' => $mapelId, 'minggu' => $minggu])
                         ->with('success', 'Absensi berhasil disimpan.');
    }
}
