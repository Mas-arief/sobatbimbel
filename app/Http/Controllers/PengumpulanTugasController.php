<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use App\Models\Mapel; // Mengimpor model Mapel untuk berinteraksi dengan data mata pelajaran
use App\Models\Tugas; // Mengimpor model Tugas untuk berinteraksi dengan data tugas
use App\Models\PengumpulanTugas; // Mengimpor model PengumpulanTugas untuk berinteraksi dengan data pengumpulan tugas siswa
use App\Models\Penilaian; // Mengimpor model Penilaian untuk berinteraksi dengan data nilai siswa
use Illuminate\Support\Facades\Auth; // Mengimpor Facade Auth untuk mendapatkan pengguna yang sedang login
use Illuminate\Support\Facades\Storage; // Mengimpor Facade Storage untuk mengelola file yang disimpan
use Illuminate\Support\Facades\Log; // Mengimpor Facade Log untuk keperluan debugging

class PengumpulanTugasController extends Controller
{
    /**
     * Menampilkan halaman pengumpulan tugas untuk minggu dan mata pelajaran tertentu.
     * Metode ini dirancang untuk siswa agar dapat melihat detail tugas, status pengumpulan, dan nilai.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi parameter query (mapel_slug, minggu_ke).
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        // Mengambil parameter 'mapel_slug' dan 'minggu_ke' dari URL query string.
        $mapelSlug = $request->query('mapel_slug');
        $mingguKe = $request->query('minggu_ke');
        // Mengambil ID pengguna yang sedang login (diasumsikan siswa).
        $userId = Auth::id();

        // Menginisialisasi variabel yang akan digunakan di view.
        $mapel = null;
        $tugas = null;
        $pengumpulanTugas = null;
        $nilai = null;

        // Memetakan slug mata pelajaran ke nama lengkap mata pelajaran yang ada di database.
        if ($mapelSlug) {
            $mapelNameMapping = [
                'indo' => 'Bahasa Indonesia',
                'inggris' => 'Bahasa Inggris',
                'mtk' => 'Matematika',
            ];

            // Mencari mata pelajaran berdasarkan nama lengkapnya.
            if (isset($mapelNameMapping[$mapelSlug])) {
                $mapel = Mapel::where('nama', $mapelNameMapping[$mapelSlug])->first();
            }
        }

        // Jika mata pelajaran dan minggu ke- ditemukan, lanjutkan untuk mengambil data tugas dan pengumpulan.
        if ($mapel && $mingguKe) {
            // Mencari tugas yang sesuai dengan mapel_id dan minggu yang diberikan.
            $tugas = Tugas::where('mapel_id', $mapel->id)
                          ->where('minggu', $mingguKe)
                          ->first();

            // Jika tugas ditemukan dan pengguna login, cari data pengumpulan tugas dan nilai.
            if ($tugas && $userId) {
                // Mencari data pengumpulan tugas spesifik untuk siswa, mapel, tugas, dan minggu ini.
                $pengumpulanTugas = PengumpulanTugas::where('siswa_id', $userId)
                                                    ->where('mapel_id', $mapel->id)
                                                    ->where('tugas_id', $tugas->id)
                                                    ->where('minggu_ke', $mingguKe)
                                                    ->first();

                // Mengambil nilai dari tabel penilaian untuk siswa, mapel, dan minggu ini.
                $penilaian = Penilaian::where('siswa_id', $userId)
                                      ->where('mapel_id', $mapel->id)
                                      ->where('minggu', $mingguKe)
                                      ->first();

                // Mengambil nilai dari objek penilaian (jika ada), jika tidak maka null.
                $nilai = $penilaian?->nilai;
            }
        }

        // Jika mata pelajaran atau tugas tidak ditemukan, arahkan kembali dengan pesan error.
        if (!$mapel || !$tugas) {
            // Mencatat peringatan untuk debugging.
            Log::warning("Mapel atau Tugas tidak ditemukan saat mengakses halaman pengumpulan tugas. Mapel Slug: {$mapelSlug}, Minggu Ke: {$mingguKe}. Mapel ditemukan: " . ($mapel ? $mapel->nama : 'Tidak'), ['user_id' => $userId]);

            // Mengarahkan kembali ke halaman kursus siswa dengan pesan error.
            return redirect()->route('siswa.kursus.index')->with('error', 'Tugas atau mata pelajaran tidak ditemukan untuk minggu ini. Pastikan tugas sudah dibuat.');
        }

        // Menentukan tipe pengguna sebagai 'siswa' untuk keperluan view.
        $tipe = 'siswa';
        // Mengembalikan view 'siswa.pengumpulan_tugas' dengan semua data yang diperlukan.
        return view('siswa.pengumpulan_tugas', compact('mapel', 'mingguKe', 'tugas', 'pengumpulanTugas', 'tipe', 'nilai'));
    }

    /**
     * Menyimpan file tugas yang diunggah oleh siswa.
     * Metode ini menangani proses unggah file dan pembaruan status pengumpulan tugas.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data pengumpulan tugas.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari permintaan.
        $request->validate([
            'mapel_id' => ['required', 'integer', 'exists:mapel,id'], // ID mapel wajib, integer, dan harus ada di tabel 'mapel'.
            'minggu_ke' => ['required', 'integer', 'min:1', 'max:16'], // Minggu ke- wajib, integer, min 1, maks 16.
            'tugas_id' => ['required', 'integer', 'exists:tugas,id'], // ID tugas wajib, integer, dan harus ada di tabel 'tugas'.
            'file_tugas' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,zip,rar,ppt,pptx,xls,xlsx,jpg,jpeg,png'], // File tugas wajib, maks 10MB, format tertentu.
            'keterangan' => ['nullable', 'string', 'max:500'], // Keterangan opsional, string, maks 500 karakter.
        ]);

        // Mengambil data dari permintaan dan ID pengguna yang login.
        $userId = Auth::id();
        $mapelId = $request->input('mapel_id');
        $mingguKe = $request->input('minggu_ke');
        $tugasId = $request->input('tugas_id');
        $keteranganSiswa = $request->input('keterangan');
        $file = $request->file('file_tugas');

        try {
            // Menyimpan file tugas yang diunggah ke direktori spesifik di storage.
            // Path akan menjadi 'pengumpulan_tugas/{mapelId}/{mingguKe}/{userId}/nama_file_asli.ext'.
            $filePath = $file->storeAs(
                'pengumpulan_tugas/' . $mapelId . '/' . $mingguKe . '/' . $userId,
                $file->getClientOriginalName(),
                'public' // Menggunakan disk 'public'
            );

            // Path relatif file yang disimpan.
            $relativePath = $filePath;

            // Memperbarui atau membuat record PengumpulanTugas.
            // Jika record dengan kombinasi siswa_id, mapel_id, tugas_id, dan minggu_ke sudah ada,
            // maka akan diperbarui. Jika tidak, record baru akan dibuat.
            $pengumpulanTugas = PengumpulanTugas::updateOrCreate(
                [
                    'siswa_id' => $userId,
                    'mapel_id' => $mapelId,
                    'tugas_id' => $tugasId,
                    'minggu_ke' => $mingguKe,
                ],
                [
                    'file_path' => $relativePath, // Menyimpan path file di database.
                    'status' => 'submitted', // Mengatur status tugas menjadi 'submitted'.
                    'keterangan_siswa' => $keteranganSiswa, // Menyimpan keterangan dari siswa.
                ]
            );

            // Mencatat informasi keberhasilan unggah tugas.
            Log::info("Tugas berhasil diunggah dan disimpan untuk Siswa ID: {$userId}, Tugas ID: {$tugasId}. Path: {$relativePath}");

            // Mengambil nama mata pelajaran saat ini untuk menentukan slug pengalihan.
            $currentMapel = Mapel::find($mapelId);
            // Memetakan nama mata pelajaran ke slug yang digunakan di URL.
            $mapelNameMapping = [
                'Bahasa Indonesia' => 'indo',
                'Bahasa Inggris' => 'inggris',
                'Matematika' => 'mtk',
            ];
            // Mendapatkan slug mapel untuk pengalihan.
            $mapelSlugForRedirect = $mapelNameMapping[$currentMapel->nama] ?? null;

            // Jika slug mapel untuk pengalihan tidak ditemukan, log error dan arahkan ke halaman kursus utama.
            if (!$mapelSlugForRedirect) {
                Log::error("Gagal mendapatkan mapel_slug untuk redirect setelah unggah tugas. Mapel ID: {$mapelId}.");
                return redirect()->route('siswa.kursus.index')->with('error', 'Tugas berhasil diunggah, tetapi terjadi kesalahan saat mengarahkan kembali. Silakan navigasi manual.');
            }

            // Mengarahkan kembali ke halaman pengumpulan tugas yang sama dengan pesan sukses.
            return redirect()->route('siswa.pengumpulan_tugas', [
                'mapel_slug' => $mapelSlugForRedirect,
                'minggu_ke' => $mingguKe
            ])->with('success', 'Tugas berhasil diunggah!');

        } catch (\Exception $e) {
            // Menangani kesalahan jika terjadi masalah saat mengunggah tugas.
            Log::error("Gagal mengunggah tugas untuk Siswa ID: {$userId}. Error: " . $e->getMessage());
            // Mengarahkan kembali ke halaman sebelumnya dengan pesan error.
            return redirect()->back()->with('error', 'Gagal mengunggah tugas. Silakan coba lagi.');
        }
    }

    /**
     * Menampilkan rekap tugas yang dikumpulkan untuk guru.
     * Metode ini memfilter data pengumpulan tugas berdasarkan parameter 'minggu' dari request.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang mungkin berisi parameter 'minggu'.
     * @return \Illuminate\View\View
     */
    public function rekapGuru(Request $request)
    {
        // Memulai query untuk model PengumpulanTugas dengan eager loading relasi 'siswa' dan 'tugas'.
        $query = PengumpulanTugas::with(['siswa', 'tugas']);

        // Filter berdasarkan 'minggu_ke' jika ada parameter 'minggu' di URL.
        if ($request->has('minggu')) {
            $mingguKe = (int) $request->query('minggu'); // Memastikan nilai 'minggu' adalah integer.
            Log::debug("Filtering rekapGuru by minggu_ke: {$mingguKe}"); // Log untuk debugging.
            $query->where('minggu_ke', $mingguKe);
        } else {
            // Log jika tidak ada parameter 'minggu' ditemukan.
            Log::debug("No 'minggu' parameter found for rekapGuru. Showing all tasks.");
        }

        // Mengambil data yang sudah difilter (atau semua data jika tidak ada filter), diurutkan berdasarkan yang terbaru.
        $tugas = $query->latest()->get(); // Anda bisa juga menggunakan paginate() jika data sangat banyak.

        // Menentukan tipe pengguna sebagai 'guru' untuk keperluan view.
        $tipe = 'guru';
        // Mengembalikan view 'guru.pengumpulan' dengan data tugas dan tipe pengguna.
        return view('guru.pengumpulan', compact('tugas', 'tipe'));
    }

    /**
     * Menghapus data pengumpulan tugas dan file terkait dari penyimpanan.
     *
     * @param  int  $id ID pengumpulan tugas yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            // Mencari data pengumpulan tugas berdasarkan ID. Jika tidak ditemukan, akan melempar 404.
            $pengumpulan = PengumpulanTugas::findOrFail($id);

            // Memeriksa apakah ada file yang terkait dan file tersebut ada di storage.
            if ($pengumpulan->file_path && Storage::disk('public')->exists($pengumpulan->file_path)) {
                // Menghapus file dari storage.
                Storage::disk('public')->delete($pengumpulan->file_path);
            }

            // Menghapus record pengumpulan tugas dari database.
            $pengumpulan->delete();

            // Mengarahkan kembali ke halaman sebelumnya dengan pesan sukses.
            return redirect()->back()->with('success', 'Data pengumpulan tugas berhasil dihapus.');
        } catch (\Exception $e) {
            // Menangani kesalahan jika terjadi masalah saat menghapus data.
            Log::error("Gagal menghapus pengumpulan tugas ID {$id}: " . $e->getMessage());
            // Mengarahkan kembali dengan pesan error.
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    /**
     * Menampilkan formulir untuk mengedit atau memberi nilai tugas.
     * Ini adalah placeholder; Anda mungkin perlu mengembangkannya lebih lanjut
     * untuk menampilkan detail tugas, file yang diunggah, dan form input nilai.
     *
     * @param  int  $siswa_id ID siswa.
     * @param  int  $tugas_id ID tugas.
     * @param  int  $minggu Minggu ke-.
     * @return \Illuminate\View\View
     */
    public function editTugas($siswa_id, $tugas_id, $minggu)
    {
        // Logika untuk mengambil data pengumpulan tugas berdasarkan siswa_id, tugas_id, dan minggu.
        // firstOrFail() akan melempar 404 jika tidak ada record yang cocok.
        $pengumpulan = PengumpulanTugas::where('siswa_id', $siswa_id)
                                       ->where('tugas_id', $tugas_id)
                                       ->where('minggu_ke', $minggu)
                                       ->firstOrFail();

        // Mengembalikan view 'guru.edit_tugas' dengan data pengumpulan tugas.
        // Pastikan view 'guru.edit_tugas' ini ada dan sesuai dengan kebutuhan Anda.
        return view('guru.edit_tugas', compact('pengumpulan'));
    }
}
