<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class TugasController extends Controller
{
    public function index(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'nullable|string',
            'tanggal_deadline' => 'nullable|date',
            'minggu_ke' => 'nullable|integer|min:1|max:16', // Sesuaikan batas max sesuai kebutuhan
        ]);

        // Buat instance model Tugas dan simpan data ke database
        $tugas = new Tugas();
        $tugas->judul = $request->input('judul_tugas');
        $tugas->deskripsi = $request->input('deskripsi_tugas');
        $tugas->deadline = $request->input('tanggal_deadline');
        $tugas->minggu_ke = $request->input('minggu_ke');
        // Tambahkan kolom lain sesuai kebutuhan (misalnya, user_id, course_id)
        $tugas->save();

        // Redirect pengguna kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Tugas berhasil dibuat.');
    }
}
