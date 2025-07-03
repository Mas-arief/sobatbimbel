<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Tugas;
use App\Models\PengumpulanTugas;
use App\Models\Penilaian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PengumpulanTugasController extends Controller
{
    /**
     * Menampilkan halaman pengumpulan tugas untuk minggu dan mapel tertentu.
     */
    public function index(Request $request)
    {
        $mapelSlug = $request->query('mapel_slug');
        $mingguKe = $request->query('minggu_ke');
        $userId = Auth::id();

        $mapel = null;
        $tugas = null;
        $pengumpulanTugas = null;
        $nilai = null;

        if ($mapelSlug) {
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
            $tugas = Tugas::where('mapel_id', $mapel->id)
                          ->where('minggu', $mingguKe)
                          ->first();

            if ($tugas && $userId) {
                $pengumpulanTugas = PengumpulanTugas::where('siswa_id', $userId)
                                                    ->where('mapel_id', $mapel->id)
                                                    ->where('tugas_id', $tugas->id)
                                                    ->where('minggu_ke', $mingguKe)
                                                    ->first();

                // Ambil nilai dari tabel penilaian
                $penilaian = Penilaian::where('siswa_id', $userId)
                                      ->where('mapel_id', $mapel->id)
                                      ->where('minggu', $mingguKe)
                                      ->first();

                $nilai = $penilaian?->nilai;
            }
        }

        if (!$mapel || !$tugas) {
            Log::warning("Mapel atau Tugas tidak ditemukan saat mengakses halaman pengumpulan tugas. Mapel Slug: {$mapelSlug}, Minggu Ke: {$mingguKe}. Mapel ditemukan: " . ($mapel ? $mapel->nama : 'Tidak'), ['user_id' => $userId]);

            return redirect()->route('siswa.kursus.index')->with('error', 'Tugas atau mata pelajaran tidak ditemukan untuk minggu ini. Pastikan tugas sudah dibuat.');
        }

        $tipe = 'siswa';
        return view('siswa.pengumpulan_tugas', compact('mapel', 'mingguKe', 'tugas', 'pengumpulanTugas', 'tipe', 'nilai'));
    }

    /**
     * Menyimpan file tugas yang diunggah oleh siswa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mapel_id' => ['required', 'integer', 'exists:mapel,id'],
            'minggu_ke' => ['required', 'integer', 'min:1', 'max:16'],
            'tugas_id' => ['required', 'integer', 'exists:tugas,id'],
            'file_tugas' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip,rar,ppt,pptx,xls,xlsx,jpg,jpeg,png'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $userId = Auth::id();
        $mapelId = $request->input('mapel_id');
        $mingguKe = $request->input('minggu_ke');
        $tugasId = $request->input('tugas_id');
        $keteranganSiswa = $request->input('keterangan');
        $file = $request->file('file_tugas');

        try {
            $filePath = $file->storeAs(
                'pengumpulan_tugas/' . $mapelId . '/' . $mingguKe . '/' . $userId,
                $file->getClientOriginalName(),
                'public'
            );

            $relativePath = $filePath;

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

            $currentMapel = Mapel::find($mapelId);
            $mapelNameMapping = [
                'Bahasa Indonesia' => 'indo',
                'Bahasa Inggris' => 'inggris',
                'Matematika' => 'mtk',
            ];
            $mapelSlugForRedirect = $mapelNameMapping[$currentMapel->nama] ?? null;

            if (!$mapelSlugForRedirect) {
                Log::error("Gagal mendapatkan mapel_slug untuk redirect setelah unggah tugas. Mapel ID: {$mapelId}.");
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

    /**
     * Rekap tugas untuk guru.
     */
    public function rekapGuru()
    {
        $tugas = PengumpulanTugas::with(['siswa', 'tugas'])->get();

        $tipe = 'guru';
        return view('guru.pengumpulan', compact('tugas', 'tipe'));
    }

    /**
     * Hapus data pengumpulan tugas.
     */
    public function destroy($id)
    {
        try {
            $pengumpulan = PengumpulanTugas::findOrFail($id);

            if ($pengumpulan->file_path && Storage::disk('public')->exists($pengumpulan->file_path)) {
                Storage::disk('public')->delete($pengumpulan->file_path);
            }

            $pengumpulan->delete();

            return redirect()->back()->with('success', 'Data pengumpulan tugas berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus pengumpulan tugas ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
