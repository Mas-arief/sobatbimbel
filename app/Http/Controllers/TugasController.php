<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Mapel; // Pastikan ini di-import jika digunakan di tempat lain
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Opsional: Untuk debugging ke log Laravel

class TugasController extends Controller
{
    public function index()
    {
        // ... (Tidak ada perubahan di sini)
    }

    public function store(Request $request)
    {
        Log::info('Request received for TugasController@store', $request->all()); // Debugging: Log semua input

        // 1. Validasi Input
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id',
            'judul_tugas' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf|max:2048', // Max 2MB
            'tanggal_deadline' => 'required|date',
            // Gunakan 'minggu_ke' jika itu nama input hidden yang Anda ingin pakai
            // Jika Anda hanya ingin menggunakan nilai dari select, maka tetap 'minggu_ke_select'
            // dan pastikan JavaScript Anda menyetelnya dengan benar.
            'minggu_ke' => 'required|integer|min:1|max:16', // Menggunakan nama dari input hidden
        ]);

        $filePath = null;
        // 2. Tangani Pengunggahan File
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tugas_pdf', $fileName, 'public');
            Log::info('File uploaded:', ['path' => $filePath]); // Debugging: Log path file
        } else {
            Log::error('File not uploaded despite being required.'); // Debugging: Error jika file tidak ada
            return redirect()->back()->withErrors(['file_path' => 'File tugas harus diunggah.']);
        }

        // 3. Simpan Data ke Database
        try {
            $tugas = new Tugas();
            $tugas->mapel_id = $request->input('mapel_id');
            $tugas->judul = $request->input('judul_tugas'); // Mapped: judul_tugas (form) -> judul (DB)
            $tugas->file_path = $filePath;
            $tugas->deadline = $request->input('tanggal_deadline'); // Mapped: tanggal_deadline (form) -> deadline (DB)
            $tugas->minggu = $request->input('minggu_ke'); // Mengambil nilai dari input hidden 'minggu_ke'
            $tugas->user_id = auth()->id(); // Asumsi guru sedang login
            $tugas->save();

            Log::info('Tugas saved successfully:', ['tugas_id' => $tugas->id]); // Debugging: Konfirmasi penyimpanan
            return redirect()->back()->with('success', 'Tugas berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error saving task:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]); // Debugging: Log error
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan tugas: ' . $e->getMessage()]);
        }
    }

    // ... Metode lain
}
