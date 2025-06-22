<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel; // Pastikan model Mapel di-import jika digunakan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Penting untuk debugging

class MateriController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug untuk melihat data yang diterima
        Log::info('Data yang diterima untuk Materi:', $request->all());
        Log::info('File yang diterima untuk Materi:', $request->file()); // Tambahkan ini untuk cek file

        // Validasi input
        $validated = $request->validate([
            'judul_materi' => 'required|string|max:255',
            'file_materi' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // max 10MB, tambahkan doc/ppt
            'minggu_ke' => 'required|integer|min:1|max:16',
            'mapel_id' => 'required|integer|min:1'
        ], [
            'judul_materi.required' => 'Judul materi harus diisi',
            'file_materi.required' => 'File materi harus diupload',
            'file_materi.mimes' => 'File harus berformat PDF, DOC, DOCX, PPT, atau PPTX', // Sesuaikan pesan
            'file_materi.max' => 'Ukuran file maksimal 10MB',
            'minggu_ke.required' => 'Minggu harus dipilih',
            'minggu_ke.integer' => 'Minggu harus berupa angka',
            'minggu_ke.min' => 'Minggu minimal 1',
            'minggu_ke.max' => 'Minggu maksimal 16',
            'mapel_id.required' => 'Mata pelajaran harus dipilih',
            'mapel_id.integer' => 'ID mata pelajaran harus berupa angka',
            'mapel_id.min' => 'ID mata pelajaran tidak valid'
        ]);

        // Cek apakah mapel_id valid (Anda bisa ganti ini dengan query ke tabel mapel jika sudah ada)
        // Contoh: if (!Mapel::where('id', $validated['mapel_id'])->exists()) { ... }
        if (!in_array($validated['mapel_id'], [1, 2, 3])) { // Contoh sederhana, ganti dengan query database jika mapel sudah diurus di DB
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak valid. Gunakan: 1=Bahasa Indonesia, 2=Bahasa Inggris, 3=Matematika'
            ], 422);
        }

        try {
            // Cek apakah sudah ada materi dengan judul, minggu, dan mapel yang sama
            $existingMateri = Materi::where('minggu_ke', $validated['minggu_ke'])
                ->where('mapel_id', $validated['mapel_id'])
                ->where('judul_materi', $validated['judul_materi'])
                ->first();

            if ($existingMateri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Materi dengan judul yang sama sudah ada untuk minggu ini di mata pelajaran ini.'
                ], 422);
            }

            // Handle file upload
            if ($request->hasFile('file_materi')) {
                $file = $request->file('file_materi');
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                // Generate unique filename
                $filename = 'materi_' . time() . '_' . Str::random(10) . '.' . $extension;

                // Store file in storage/app/public/materi
                $filePath = $file->storeAs('materi', $filename, 'public');

                // Simpan data ke database
                $materi = Materi::create([
                    'judul_materi' => $validated['judul_materi'],
                    'file_materi' => $filePath,
                    'minggu_ke' => $validated['minggu_ke'],
                    'mapel_id' => $validated['mapel_id'],
                    'file_type' => strtolower($extension),
                    'original_filename' => $originalName
                ]);

                // Response untuk AJAX request
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Materi berhasil ditambahkan',
                        'data' => $materi->load('mapel')
                    ]);
                }

                // Redirect back dengan pesan sukses
                return redirect()->back()->with('success', 'Materi berhasil ditambahkan');
            } else {
                // Ini seharusnya tidak tercapai jika validasi 'required' berfungsi
                return response()->json([
                    'success' => false,
                    'message' => 'File materi tidak ditemukan setelah validasi.'
                ], 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani error validasi secara spesifik
            Log::error('Validation Error storing materi: ' . json_encode($e->errors()));
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log error umum
            Log::error('Error storing materi: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan internal saat menyimpan materi'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan materi')
                ->withInput();
        }
    }

    /**
     * Get materi by minggu and mapel
     */
    public function getMateriByMingguMapel($minggu, $mapelId)
    {
        $materi = Materi::with('mapel')
            ->where('minggu_ke', $minggu)
            ->where('mapel_id', $mapelId)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $materi
        ]);
    }

    /**
     * Download materi file
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
     * Delete materi
     */
    public function destroy($id)
    {
        try {
            $materi = Materi::findOrFail($id);

            // Delete file from storage
            if (Storage::disk('public')->exists($materi->file_materi)) {
                Storage::disk('public')->delete($materi->file_materi);
            }

            // Delete record from database
            $materi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Materi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting materi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus materi'
            ], 500);
        }
    }
}
