<?php

namespace App\Http\Controllers;

use App\Models\Materi; // Mengimpor model Materi untuk berinteraksi dengan data materi pelajaran
use App\Models\Mapel; // Pastikan model Mapel di-import untuk validasi 'exists'
use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use Illuminate\Support\Facades\Storage; // Mengimpor Facade Storage untuk mengelola file yang disimpan
use Illuminate\Support\Str; // Mengimpor kelas Str untuk fungsi-fungsi string helper (misalnya Str::random)
use Illuminate\Support\Facades\Log; // Mengimpor Facade Log untuk keperluan debugging
use Illuminate\Validation\ValidationException; // Mengimpor ValidationException untuk menangani kesalahan validasi

class MateriController extends Controller
{
    /**
     * Menyimpan sumber daya materi yang baru dibuat ke penyimpanan.
     * Metode ini menangani unggahan file materi dan penyimpanannya di database.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data materi.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Debugging: Mencatat semua data input dan file yang diterima untuk analisis.
        Log::info('Data yang diterima untuk Materi:', $request->all());
        Log::info('File yang diterima untuk Materi:', $request->file());

        try {
            // Validasi input dari permintaan.
            $validated = $request->validate([
                'judul_materi' => 'required|string|max:255', // Judul materi wajib, string, maks 255 karakter.
                'file_materi' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // File wajib, harus berupa file, format tertentu, maks 10MB.
                'minggu_ke' => 'required|integer|min:1|max:16', // Minggu ke- wajib, integer, min 1, maks 16.
                'mapel_id' => 'required|exists:mapel,id', // ID mata pelajaran wajib, dan harus ada di tabel 'mapel'.
                'tab' => 'nullable|string' // Menangkap nilai tab untuk pengalihan kembali ke tab yang benar.
            ], [
                // Pesan kesalahan kustom untuk setiap aturan validasi.
                'judul_materi.required' => 'Judul materi harus diisi',
                'file_materi.required' => 'File materi harus diupload',
                'file_materi.mimes' => 'File harus berformat PDF, DOC, DOCX, PPT, atau PPTX',
                'file_materi.max' => 'Ukuran file maksimal 10MB',
                'minggu_ke.required' => 'Minggu harus dipilih',
                'minggu_ke.integer' => 'Minggu harus berupa angka',
                'minggu_ke.min' => 'Minggu minimal 1',
                'minggu_ke.max' => 'Minggu maksimal 16',
                'mapel_id.required' => 'Mata pelajaran harus dipilih',
                'mapel_id.exists' => 'ID mata pelajaran tidak valid.',
            ]);

            // Cek apakah sudah ada materi dengan judul, minggu, dan mapel yang sama untuk mencegah duplikasi.
            $existingMateri = Materi::where('minggu_ke', $validated['minggu_ke'])
                ->where('mapel_id', $validated['mapel_id'])
                ->where('judul_materi', $validated['judul_materi'])
                ->first();

            if ($existingMateri) {
                // Jika materi duplikat ditemukan, arahkan kembali dengan pesan error dan input lama.
                return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                                 ->withErrors(['judul_materi' => 'Materi dengan judul yang sama sudah ada untuk minggu ini di mata pelajaran ini.'])
                                 ->withInput();
            }

            // Menangani unggahan file.
            if ($request->hasFile('file_materi')) {
                $file = $request->file('file_materi');
                $originalName = $file->getClientOriginalName(); // Mendapatkan nama asli file.
                $extension = $file->getClientOriginalExtension(); // Mendapatkan ekstensi file.

                // Menghasilkan nama file unik untuk menghindari konflik nama.
                $filename = 'materi_' . time() . '_' . Str::random(10) . '.' . $extension;

                // Menyimpan file ke direktori 'materi' di disk 'public' (storage/app/public/materi).
                // $filePath akan berisi path relatif seperti 'materi/nama_file_unik.pdf'.
                $filePath = $file->storeAs('materi', $filename, 'public');

                // Mengambil hanya NAMA FILENYA (tanpa path direktori) untuk disimpan ke database.
                $fileNameForDb = basename($filePath); // <-- BARIS PERBAIKAN DI SINI

                // Menyimpan data materi ke database.
                $materi = Materi::create([
                    'judul_materi' => $validated['judul_materi'],
                    'file_materi' => $fileNameForDb, // <-- SIMPAN HANYA NAMA FILENYA
                    'minggu_ke' => $validated['minggu_ke'],
                    'mapel_id' => $validated['mapel_id'],
                    'file_type' => strtolower($extension), // Menyimpan tipe file (ekstensi).
                    'original_filename' => $originalName // Menyimpan nama file asli.
                ]);

                // Mencatat informasi bahwa materi berhasil disimpan.
                Log::info('Materi berhasil disimpan:', ['materi_id' => $materi->id, 'file_path_db' => $fileNameForDb]);

                // Mengarahkan kembali ke halaman kursus guru dengan tab yang benar dan pesan sukses.
                return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])->with('success', 'Materi berhasil ditambahkan!');
            } else {
                // Ini seharusnya tidak tercapai jika validasi 'required' pada 'file_materi' berfungsi.
                // Namun, sebagai fallback, arahkan kembali dengan error jika file tidak ditemukan.
                return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                                 ->withErrors(['file_materi' => 'File materi tidak ditemukan setelah validasi.'])
                                 ->withInput();
            }
        } catch (ValidationException $e) {
            // Menangani error validasi secara spesifik.
            Log::error('Validation Error storing materi: ' . json_encode($e->errors()));
            // Arahkan kembali dengan error validasi dan input lama, serta kembali ke tab yang sama.
            return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                             ->withErrors($e->errors())
                             ->withInput();
        } catch (\Exception $e) {
            // Menangani error umum lainnya.
            Log::error('Error storing materi: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

            // Arahkan kembali dengan pesan error umum dan input lama, serta kembali ke tab yang sama.
            return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                             ->with('error', 'Terjadi kesalahan saat menyimpan materi: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Mengunduh file materi.
     *
     * @param  int  $id ID materi yang akan diunduh.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id)
    {
        // Mencari materi berdasarkan ID. Jika tidak ditemukan, akan melempar 404.
        $materi = Materi::findOrFail($id);

        // Membangun path lengkap ke file materi di sistem penyimpanan.
        // Pastikan ini sesuai dengan lokasi fisik file di disk 'public'.
        $filePath = storage_path('app/public/materi/' . $materi->file_materi);

        // Memeriksa apakah file benar-benar ada di lokasi yang ditentukan.
        if (!file_exists($filePath)) {
            // Jika file tidak ditemukan, hentikan eksekusi dengan error 404.
            abort(404, 'File tidak ditemukan');
        }

        // Mengembalikan respons unduhan file dengan nama asli file.
        return response()->download($filePath, $materi->original_filename);
    }

    /**
     * Menghapus materi dari database dan penyimpanan.
     *
     * @param  int  $id ID materi yang akan dihapus.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Mencari materi berdasarkan ID. Jika tidak ditemukan, akan melempar 404.
            $materi = Materi::findOrFail($id);

            // Membangun path file di storage yang akan dihapus (relatif dari disk 'public').
            $filePathInStorage = 'materi/' . $materi->file_materi; // Tambahkan 'materi/' di sini

            // Memeriksa apakah file ada di storage sebelum mencoba menghapusnya.
            if (Storage::disk('public')->exists($filePathInStorage)) {
                // Menghapus file dari storage.
                Storage::disk('public')->delete($filePathInStorage);
                Log::info('File materi dihapus dari storage:', ['path' => $filePathInStorage]);
            }

            // Menghapus record materi dari database.
            $materi->delete();
            Log::info('Materi dihapus dari database:', ['materi_id' => $id]);

            // Mengembalikan respons JSON sukses.
            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            // Menangani kesalahan jika terjadi masalah saat menghapus materi.
            Log::error('Error menghapus materi: ' . $e->getMessage());

            // Mengembalikan respons JSON error dengan status 500.
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus materi: ' . $e->getMessage()
            ], 500);
        }
    }
}
