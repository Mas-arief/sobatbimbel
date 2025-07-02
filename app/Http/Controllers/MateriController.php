<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel; // Pastikan model Mapel di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class MateriController extends Controller
{
    /**
     * Menyimpan sumber daya yang baru dibuat di penyimpanan.
     */
    public function store(Request $request)
    {
        // Debug untuk melihat data yang diterima
        Log::info('Data yang diterima untuk Materi:', $request->all());
        Log::info('File yang diterima untuk Materi:', $request->file());

        // Validasi input
        $validated = $request->validate([
            'judul_materi' => 'required|string|max:255',
            'file_materi' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // max 10MB
            'minggu_ke' => 'required|integer|min:1|max:16',
            'mapel_id' => 'required|exists:mapel,id', // PERBAIKAN: Menggunakan validasi 'exists'
            'tab' => 'nullable|string' // Menangkap nilai tab untuk redirect
        ], [
            'judul_materi.required' => 'Judul materi harus diisi',
            'file_materi.required' => 'File materi harus diupload',
            'file_materi.mimes' => 'File harus berformat PDF, DOC, DOCX, PPT, atau PPTX',
            'file_materi.max' => 'Ukuran file maksimal 10MB',
            'minggu_ke.required' => 'Minggu harus dipilih',
            'minggu_ke.integer' => 'Minggu harus berupa angka',
            'minggu_ke.min' => 'Minggu minimal 1',
            'minggu_ke.max' => 'Minggu maksimal 16',
            'mapel_id.required' => 'Mata pelajaran harus dipilih',
            'mapel_id.exists' => 'ID mata pelajaran tidak valid.', // Pesan untuk validasi 'exists'
        ]);

        try {
            // Cek apakah sudah ada materi dengan judul, minggu, dan mapel yang sama
            $existingMateri = Materi::where('minggu_ke', $validated['minggu_ke'])
                ->where('mapel_id', $validated['mapel_id'])
                ->where('judul_materi', $validated['judul_materi'])
                ->first();

            if ($existingMateri) {
                // PERBAIKAN: Redirect dengan errors dan input, serta kembali ke tab yang sama
                return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                                 ->withErrors(['judul_materi' => 'Materi dengan judul yang sama sudah ada untuk minggu ini di mata pelajaran ini.'])
                                 ->withInput();
            }

            // Handle file upload
            if ($request->hasFile('file_materi')) {
                $file = $request->file('file_materi');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                // Generate nama file unik
                $filename = 'materi_' . time() . '_' . Str::random(10) . '.' . $extension;

                // Store file in storage/app/public/materi
                $filePath = $file->storeAs('materi', $filename, 'public');

                // Simpan data ke database
                $materi = Materi::create([
                    'judul_materi' => $validated['judul_materi'],
                    'file_materi' => $filePath, // Path relatif dari storage/app/public
                    'minggu_ke' => $validated['minggu_ke'],
                    'mapel_id' => $validated['mapel_id'],
                    'file_type' => strtolower($extension),
                    'original_filename' => $originalName
                ]);

                Log::info('Materi berhasil disimpan:', ['materi_id' => $materi->id, 'file_path' => $filePath]);

                // Redirect kembali ke halaman kursus dengan tab yang benar
                return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])->with('success', 'Materi berhasil ditambahkan!');
            } else {
                // Ini seharusnya tidak tercapai jika validasi 'required' berfungsi
                // PERBAIKAN: Redirect dengan errors dan input, serta kembali ke tab yang sama
                return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                                 ->withErrors(['file_materi' => 'File materi tidak ditemukan setelah validasi.'])
                                 ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi secara spesifik
            Log::error('Validation Error storing materi: ' . json_encode($e->errors()));
            // PERBAIKAN: Redirect dengan errors dan input, serta kembali ke tab yang sama
            return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                             ->withErrors($e->errors())
                             ->withInput();
        } catch (\Exception $e) {
            // Log error umum
            Log::error('Error storing materi: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

            // PERBAIKAN: Redirect dengan errors dan input, serta kembali ke tab yang sama
            return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])
                             ->with('error', 'Terjadi kesalahan saat menyimpan materi: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Mengunduh file materi
     */
    public function download($id)
    {
        $materi = Materi::findOrFail($id);

        $filePath = storage_path('app/public/' . $materi->file_materi);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath, $materi->original_filename);
    }

    /**
     * Menghapus materi
     */
    public function destroy($id)
    {
        try {
            $materi = Materi::findOrFail($id);

            // Hapus file dari storage
            if (Storage::disk('public')->exists($materi->file_materi)) {
                Storage::disk('public')->delete($materi->file_materi);
                Log::info('File materi dihapus dari storage:', ['path' => $materi->file_materi]);
            }

            // Hapus record dari database
            $materi->delete();
            Log::info('Materi dihapus dari database:', ['materi_id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error menghapus materi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus materi: ' . $e->getMessage()
            ], 500);
        }
    }
}
