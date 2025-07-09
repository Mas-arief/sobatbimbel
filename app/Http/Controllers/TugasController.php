<?php

namespace App\Http\Controllers;

use App\Models\Tugas; // Mengimpor model Tugas untuk berinteraksi dengan data tugas
use App\Models\Mapel; // Pastikan ini di-import jika digunakan untuk helper atau relasi
use App\Models\PengumpulanTugas; // Pastikan ini di-import jika digunakan
use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use Illuminate\Support\Facades\Storage; // Mengimpor Facade Storage untuk mengelola file yang disimpan
use Illuminate\Support\Facades\Log; // Mengimpor Facade Log untuk keperluan debugging
use Illuminate\Support\Facades\Auth; // Mengimpor Facade Auth untuk mendapatkan ID pengguna yang sedang login
use Illuminate\Support\Str; // Mengimpor kelas Str jika Str::contains atau Str::random digunakan

class TugasController extends Controller
{
    /**
     * Metode index. Opsional: Implementasikan jika diperlukan untuk menampilkan daftar tugas.
     *
     * @return void
     */
    public function index()
    {
        // Opsional: implementasikan jika diperlukan
    }

    /**
     * Menyimpan tugas baru yang diunggah oleh guru.
     * Metode ini menangani unggahan file PDF tugas dan penyimpanannya di database.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data tugas.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Mencatat semua data permintaan yang diterima untuk debugging.
        Log::info('Request received for TugasController@store', $request->all());

        // Validasi input dari permintaan.
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id', // ID mapel wajib dan harus ada di tabel 'mapel'.
            'judul_tugas' => 'required|string|max:255', // Judul tugas wajib, string, maks 255 karakter.
            'file_path' => 'required|file|mimes:pdf|max:2048', // File wajib, harus PDF, maks 2MB.
            'tanggal_deadline' => 'required|date', // Tanggal deadline wajib dan harus format tanggal.
            'minggu_ke' => 'required|integer|min:1|max:16', // Minggu ke- wajib, integer, min 1, maks 16.
            'tab' => 'nullable|string' // Menangkap nilai tab untuk pengalihan kembali ke tab yang benar.
        ]);

        $filePath = null; // Inisialisasi $filePath

        // Menangani unggahan file.
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Membuat nama file unik.
            // Menyimpan file ke direktori 'tugas_pdf' di disk 'public'.
            $filePath = $file->storeAs('tugas_pdf', $fileName, 'public');
            Log::info('File uploaded:', ['path' => $filePath]);
        } else {
            // Ini seharusnya tidak tercapai jika validasi 'required' berfungsi.
            Log::error('File not uploaded despite being required.');
            return redirect()->back()->withErrors(['file_path' => 'File tugas harus diunggah.'])->withInput();
        }

        try {
            // Membuat instance baru dari model Tugas.
            $tugas = new Tugas();
            // Mengisi atribut-atribut tugas dengan data dari permintaan.
            $tugas->mapel_id = $request->input('mapel_id');
            $tugas->judul = $request->input('judul_tugas');
            $tugas->file_path = $filePath; // Menyimpan path file yang diunggah.
            $tugas->deadline = $request->input('tanggal_deadline');
            $tugas->minggu = $request->input('minggu_ke');
            $tugas->user_id = Auth::id(); // Menggunakan ID pengguna yang sedang login sebagai user_id (guru yang membuat tugas).
            $tugas->save(); // Menyimpan data tugas ke database.

            Log::info('Tugas saved successfully:', ['tugas_id' => $tugas->id]);
            // Mengarahkan kembali ke halaman kursus guru dengan tab yang benar dan pesan sukses.
            return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])->with('success', 'Tugas berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Menangani kesalahan jika terjadi masalah saat menyimpan tugas.
            Log::error('Error saving task:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            // Mengarahkan kembali dengan pesan error dan input lama.
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan tugas: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Metode untuk mengunduh file tugas.
     * Ini akan digunakan oleh link di Blade untuk mengunduh tugas.
     *
     * @param  int  $id ID tugas yang akan diunduh.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function download($id) // Mengganti nama metode dari 'show' menjadi 'download'
    {
        // Mencari tugas berdasarkan ID. Jika tidak ditemukan, akan melempar 404.
        $tugas = Tugas::findOrFail($id);

        // Membangun path lengkap ke file di storage.
        // Pastikan path ke file di storage sudah benar (misal: 'public/tugas_pdf/nama_file.pdf').
        $filePath = 'public/' . $tugas->file_path;

        // Memeriksa apakah file ada di storage.
        if (!Storage::exists($filePath)) {
            // Log error jika file tidak ditemukan.
            Log::error('File tugas tidak ditemukan:', ['path' => $filePath, 'tugas_id' => $id]);
            // Mengarahkan kembali dengan pesan error.
            return redirect()->back()->with('error', 'File tugas tidak ditemukan.');
        }

        // Mengunduh file. Nama file unduhan akan diambil dari judul tugas,
        // dengan ekstensi yang diambil dari path file asli.
        return Storage::download($filePath, $tugas->judul . '.' . pathinfo($tugas->file_path, PATHINFO_EXTENSION));
    }

    /**
     * Menampilkan formulir untuk mengedit pengumpulan tugas (biasanya untuk memberi nilai).
     *
     * @param  int  $id ID pengumpulan tugas.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Mencari pengumpulan tugas berdasarkan ID, dengan eager loading relasi 'siswa' dan 'tugas'.
        // firstOrFail() akan melempar 404 jika tidak ada record yang cocok.
        $pengumpulan = PengumpulanTugas::with(['siswa', 'tugas'])->findOrFail($id);
        // Mengembalikan view 'guru.edit_tugas' dengan data pengumpulan tugas.
        return view('guru.edit_tugas', compact('pengumpulan'));
    }

    /**
     * Memperbarui nilai untuk pengumpulan tugas.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi nilai.
     * @param  int  $id ID pengumpulan tugas yang akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input nilai.
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100', // Nilai wajib, numerik, min 0, maks 100.
        ]);

        // Mencari pengumpulan tugas berdasarkan ID. Jika tidak ditemukan, akan melempar 404.
        $pengumpulan = PengumpulanTugas::findOrFail($id);
        // Memperbarui kolom 'nilai' pada pengumpulan tugas.
        $pengumpulan->nilai = $request->nilai;
        $pengumpulan->save(); // Menyimpan perubahan ke database.

        // Mengarahkan kembali ke halaman rekap pengumpulan tugas guru dengan pesan sukses.
        return redirect()->route('guru.pengumpulan')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Metode untuk menghapus tugas dan file terkait dari penyimpanan.
     * Ini akan digunakan oleh tombol "Hapus" di Blade.
     *
     * @param  int  $id ID tugas yang akan dihapus.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Mencari tugas berdasarkan ID. Jika tidak ditemukan, akan melempar 404.
            $tugas = Tugas::findOrFail($id);

            // Memeriksa apakah file tugas ada di storage sebelum mencoba menghapusnya.
            if (Storage::disk('public')->exists($tugas->file_path)) {
                // Menghapus file dari storage.
                Storage::disk('public')->delete($tugas->file_path);
                Log::info('File tugas dihapus dari storage:', ['path' => $tugas->file_path]);
            }

            // Menghapus record tugas dari database.
            $tugas->delete();
            Log::info('Tugas dihapus dari database:', ['tugas_id' => $id]);

            // Mengembalikan respons JSON sukses.
            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Menangani kesalahan jika terjadi masalah saat menghapus tugas.
            Log::error('Error deleting tugas:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            // Mengembalikan respons JSON error dengan status 500.
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus tugas: ' . $e->getMessage()
            ], 500);
        }
    }
}
