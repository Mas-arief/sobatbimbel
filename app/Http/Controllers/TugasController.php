<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Mapel; // Pastikan ini di-import jika digunakan untuk helper
use App\Models\PengumpulanTugas; // Pastikan ini di-import jika digunakan
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk auth()->id()

class TugasController extends Controller
{
    public function index()
    {
        // Optional: implement if needed
    }

    public function store(Request $request)
    {
        Log::info('Request received for TugasController@store', $request->all());

        $request->validate([
            'mapel_id' => 'required|exists:mapel,id',
            'judul_tugas' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf|max:2048',
            'tanggal_deadline' => 'required|date',
            'minggu_ke' => 'required|integer|min:1|max:16',
            'tab' => 'nullable|string' // Menangkap nilai tab untuk redirect
        ]);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tugas_pdf', $fileName, 'public');
            Log::info('File uploaded:', ['path' => $filePath]);
        } else {
            Log::error('File not uploaded despite being required.');
            return redirect()->back()->withErrors(['file_path' => 'File tugas harus diunggah.'])->withInput();
        }

        try {
            $tugas = new Tugas();
            $tugas->mapel_id = $request->input('mapel_id');
            $tugas->judul = $request->input('judul_tugas');
            $tugas->file_path = $filePath;
            $tugas->deadline = $request->input('tanggal_deadline');
            $tugas->minggu = $request->input('minggu_ke');
            $tugas->user_id = Auth::id(); // Menggunakan Auth::id()
            $tugas->save();

            Log::info('Tugas saved successfully:', ['tugas_id' => $tugas->id]);
            // Redirect kembali ke halaman kursus dengan tab yang benar
            return redirect()->route('guru.kursus', ['tab' => $request->input('tab')])->with('success', 'Tugas berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error saving task:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan tugas: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Metode untuk menampilkan detail tugas atau langsung mengunduh file.
     * Ini akan digunakan oleh link di Blade untuk mengunduh tugas.
     */
    public function show($id)
    {
        $tugas = Tugas::findOrFail($id);

        $filePath = storage_path('app/public/' . $tugas->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tugas tidak ditemukan.');
        }

        // Mengambil nama file asli dari path yang disimpan atau menggunakan judul tugas
        // Jika Anda menyimpan original_filename di model Tugas, gunakan itu:
        // return response()->download($filePath, $tugas->original_filename);
        // Jika tidak, gunakan judul tugas atau nama file dari path:
        return response()->download($filePath, $tugas->judul . '.pdf');
    }

    public function edit($id)
    {
        $pengumpulan = PengumpulanTugas::with(['siswa', 'tugas'])->findOrFail($id);
        return view('guru.edit_tugas', compact('pengumpulan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $pengumpulan = PengumpulanTugas::findOrFail($id);
        $pengumpulan->nilai = $request->nilai;
        $pengumpulan->save();

        return redirect()->route('guru.pengumpulan')->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Metode untuk menghapus tugas dan file terkait.
     * Ini akan digunakan oleh tombol "Hapus" di Blade.
     */
    public function destroy($id)
    {
        try {
            $tugas = Tugas::findOrFail($id);

            // Hapus file dari storage
            if (Storage::disk('public')->exists($tugas->file_path)) {
                Storage::disk('public')->delete($tugas->file_path);
                Log::info('File tugas dihapus dari storage:', ['path' => $tugas->file_path]);
            }

            // Hapus record dari database
            $tugas->delete();
            Log::info('Tugas dihapus dari database:', ['tugas_id' => $id]);

            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting tugas:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus tugas: ' . $e->getMessage()
            ], 500);
        }
    }
}
