<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Mapel;
use App\Models\PengumpulanTugas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        ]);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tugas_pdf', $fileName, 'public');
            Log::info('File uploaded:', ['path' => $filePath]);
        } else {
            Log::error('File not uploaded despite being required.');
            return redirect()->back()->withErrors(['file_path' => 'File tugas harus diunggah.']);
        }

        try {
            $tugas = new Tugas();
            $tugas->mapel_id = $request->input('mapel_id');
            $tugas->judul = $request->input('judul_tugas');
            $tugas->file_path = $filePath;
            $tugas->deadline = $request->input('tanggal_deadline');
            $tugas->minggu = $request->input('minggu_ke');
            $tugas->user_id = auth()->id();
            $tugas->save();

            Log::info('Tugas saved successfully:', ['tugas_id' => $tugas->id]);
            return redirect()->back()->with('success', 'Tugas berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error saving task:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan tugas: ' . $e->getMessage()]);
        }
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
}
