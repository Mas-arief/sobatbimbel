<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MateriController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug untuk melihat data yang diterima
        \Log::info('Data yang diterima:', $request->all());

        // Validasi input dengan lebih detail
        $validated = $request->validate([
            'judul_materi' => 'required|string|max:255',
            'file_materi' => 'required|file|mimes:pdf,docx,pptx|max:10240', // max 10MB
            'minggu_ke' => 'required|integer|min:1|max:16', // <-- This is the culprit for "Minggu harus dipilih"
            'mapel_id' => 'required|integer|min:1' // <-- This is likely the "1 more error"
        ], [
            'judul_materi.required' => 'Judul materi harus diisi',
            'file_materi.required' => 'File materi harus diupload',
            'file_materi.mimes' => 'File harus berformat PDF, DOCX, atau PPTX',
            'file_materi.max' => 'Ukuran file maksimal 10MB',
            'minggu_ke.required' => 'Minggu harus dipilih', // <-- Custom message for missing 'minggu_ke'
            'minggu_ke.integer' => 'Minggu harus berupa angka',
            'minggu_ke.min' => 'Minggu minimal 1',
            'minggu_ke.max' => 'Minggu maksimal 16',
            'mapel_id.required' => 'Mata pelajaran harus dipilih', // <-- Custom message for missing 'mapel_id'
            'mapel_id.integer' => 'ID mata pelajaran harus berupa angka',
            'mapel_id.min' => 'ID mata pelajaran tidak valid'
        ]);

        // Cek apakah mapel_id valid (manual check karena tabel mungkin belum ada)
        if (!in_array($validated['mapel_id'], [1, 2, 3])) {
            return response()->json([
                'success' => false,
                'message' => 'Mata pelajaran tidak valid. Gunakan: 1=Bahasa Indonesia, 2=Bahasa Inggris, 3=Matematika'
            ], 422);
        }

        try {
            // Cek apakah sudah ada materi untuk minggu dan mapel yang sama
            $existingMateri = Materi::where('minggu_ke', $validated['minggu_ke'])
                ->where('mapel_id', $validated['mapel_id'])
                ->where('judul_materi', $validated['judul_materi'])
                ->first();

            if ($existingMateri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Materi dengan judul yang sama sudah ada untuk minggu ini'
                ], 422);
            }

            // Handle file upload
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
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error storing materi: ' . $e->getMessage());

            // Response untuk AJAX request
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan materi'
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
            \Log::error('Error deleting materi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus materi'
            ], 500);
        }
    }
}
