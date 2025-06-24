<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Tugas; // Import Model Tugas
use App\Models\PengumpulanTugas; // Import Model PengumpulanTugas
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan id siswa yang sedang login
use Illuminate\Support\Facades\Storage; // Untuk menyimpan file
use Illuminate\Support\Facades\Log; // Untuk debugging

class PengumpulanTugasController extends Controller
{
    /**
     * Menampilkan halaman pengumpulan tugas untuk minggu dan mapel tertentu.
     */
    public function index(Request $request)
    {
        $mapelSlug = $request->query('mapel_slug');
        $mingguKe = $request->query('minggu_ke'); // This is 'mingguKe' (camelCase)
        $userId = Auth::id(); // Siswa yang sedang login

        $mapel = null;
        $tugas = null;
        $pengumpulanTugas = null;

        if ($mapelSlug) {
            // Gunakan mapping eksplisit untuk mencocokkan slug dengan nama mapel di database
            $mapelNameMapping = [
                'indo' => 'Bahasa Indonesia',
                'inggris' => 'Bahasa Inggris',
                'mtk' => 'Matematika',
            ];

            if (isset($mapelNameMapping[$mapelSlug])) {
                $mapel = Mapel::where('nama', $mapelNameMapping[$mapelSlug])->first();
            }
        }

        if ($mapel && $mingguKe) {
            // Dapatkan tugas yang relevan dengan mapel dan minggu ini
            // Asumsi ada satu tugas per mapel per minggu, atau ambil yang pertama
            $tugas = Tugas::where('mapel_id', $mapel->id)
                          ->where('minggu', $mingguKe)
                          ->first();

            // Dapatkan status pengumpulan tugas oleh siswa untuk tugas ini
            if ($tugas && $userId) {
                $pengumpulanTugas = PengumpulanTugas::where('siswa_id', $userId)
                                                    ->where('mapel_id', $mapel->id)
                                                    ->where('tugas_id', $tugas->id)
                                                    ->where('minggu_ke', $mingguKe)
                                                    ->first();
            }
        }

        // Jika mapel atau tugas tidak ditemukan, mungkin redirect atau tampilkan pesan error
        if (!$mapel || !$tugas) {
            Log::warning("Mapel atau Tugas tidak ditemukan saat mengakses halaman pengumpulan tugas. Mapel Slug: {$mapelSlug}, Minggu Ke: {$mingguKe}. Mapel ditemukan: " . ($mapel ? $mapel->nama : 'Tidak'), ['user_id' => $userId]);

            return redirect()->route('siswa.kursus.index')->with('error', 'Tugas atau mata pelajaran tidak ditemukan untuk minggu ini. Pastikan tugas sudah dibuat.');
        }

        // --- Pastikan variabel 'mingguKe' (camelCase) digunakan di compact() ---
        return view('siswa.pengumpulan_tugas', compact('mapel', 'mingguKe', 'tugas', 'pengumpulanTugas'));
    }

    /**
     * Menyimpan file tugas yang diunggah oleh siswa.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'mapel_id' => ['required', 'integer', 'exists:mapel,id'],
            'minggu_ke' => ['required', 'integer', 'min:1', 'max:16'],
            'tugas_id' => ['required', 'integer', 'exists:tugas,id'],
            'file_tugas' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip,rar,ppt,pptx,xls,xlsx,jpg,jpeg,png'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $userId = Auth::id(); // ID siswa yang sedang login
        $mapelId = $request->input('mapel_id');
        $mingguKe = $request->input('minggu_ke');
        $tugasId = $request->input('tugas_id');
        $keteranganSiswa = $request->input('keterangan');
        $file = $request->file('file_tugas');

        try {
            // 2. Simpan File ke Storage
            // MENGGUNAKAN DISK 'public' SECARA EKSPLISIT
            $filePath = $file->storeAs(
                'pengumpulan_tugas/' . $mapelId . '/' . $mingguKe . '/' . $userId,
                $file->getClientOriginalName(),
                'public' // MENENTUKAN DISK 'public'
            );

            // Path relatif untuk database (tidak perlu mengganti 'public/' karena sudah di disk public)
            // Cukup hapus 'public/' dari $filePath jika $filePath mengembalikan path lengkap dengan nama disk.
            // Namun, storeAs dengan disk 'public' biasanya sudah mengembalikan path relatif terhadap root disk tersebut.
            // Jadi, $filePath harusnya sudah siap untuk disimpan ke DB.
            $relativePath = $filePath; // Menggunakan langsung $filePath karena sudah relatif terhadap disk 'public'

            // 3. Simpan data ke Database menggunakan updateOrCreate
            $pengumpulanTugas = PengumpulanTugas::updateOrCreate(
                [
                    'siswa_id' => $userId,
                    'mapel_id' => $mapelId,
                    'tugas_id' => $tugasId,
                    'minggu_ke' => $mingguKe,
                ],
                [
                    'file_path' => $relativePath,
                    'status' => 'submitted',
                    'keterangan_siswa' => $keteranganSiswa,
                ]
            );

            Log::info("Tugas berhasil diunggah dan disimpan untuk Siswa ID: {$userId}, Tugas ID: {$tugasId}. Path: {$relativePath}");

            // --- PERBAIKAN: Dapatkan nama mapel dan mapping untuk redirect yang benar ---
            $currentMapel = Mapel::find($mapelId);
            $mapelNameMapping = [
                'Bahasa Indonesia' => 'indo',
                'Bahasa Inggris' => 'inggris',
                'Matematika' => 'mtk',
            ];
            $mapelSlugForRedirect = $mapelNameMapping[$currentMapel->nama] ?? null;

            if (!$mapelSlugForRedirect) {
                Log::error("Gagal mendapatkan mapel_slug untuk redirect setelah unggah tugas. Mapel ID: {$mapelId}.");
                // Fallback jika mapelSlug tidak ditemukan, redirect ke halaman kursus
                return redirect()->route('siswa.kursus.index')->with('error', 'Tugas berhasil diunggah, tetapi terjadi kesalahan saat mengarahkan kembali. Silakan navigasi manual.');
            }

            return redirect()->route('siswa.pengumpulan_tugas', [
                'mapel_slug' => $mapelSlugForRedirect,
                'minggu_ke' => $mingguKe
            ])->with('success', 'Tugas berhasil diunggah!');

        } catch (\Exception $e) {
            Log::error("Gagal mengunggah tugas untuk Siswa ID: {$userId}. Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunggah tugas. Silakan coba lagi.');
        }
    }

    public function rekapGuru()
    {
        // Ambil semua data pengumpulan tugas, termasuk relasi ke siswa dan tugas
        $tugas = \App\Models\PengumpulanTugas::with(['siswa', 'tugas'])->get();

        return view('guru.pengumpulan', compact('tugas'));
    }
}
