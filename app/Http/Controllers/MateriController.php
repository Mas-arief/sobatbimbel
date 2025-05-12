<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class MateriController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_file' => 'required|in:pdf,video,link',
            'judul_materi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_materi' => 'nullable|file|mimes:pdf|max:2048', // Contoh validasi untuk PDF
            'link_video' => 'nullable|url|max:255',
            'minggu_ke' => 'required|integer|min:1|max:16',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $materi = [
            'judul' => $request->judul_materi,
            'deskripsi' => $request->deskripsi,
            'jenis_file' => $request->jenis_file,
            'minggu_ke' => $request->minggu_ke,
        ];

        switch ($request->jenis_file) {
            case 'pdf':
                if ($request->hasFile('file_materi')) {
                    // Simpan file ke storage (sementara)
                    $path = $request->file('file_materi')->store('materi/pdf_temp', 'public');
                    $materi['path_file'] = $path;
                    // Perlu diingat bahwa file ini hanya akan tersimpan sementara
                    // dan akan hilang setelah session berakhir atau tidak ditangani lebih lanjut.
                }
                break;
            case 'video':
                $materi['link'] = $request->link_video;
                break;
            case 'link':
                $materi['link'] = $request->link_video;
                break;
        }

        // Simpan data materi ke dalam session
        $materis = Session::get('materis', []);
        $materis[] = $materi;
        Session::put('materis', $materis);

        return back()->with('success', 'Materi berhasil ditambahkan (tanpa database).');
    }

    // Contoh untuk menampilkan data materi dari session
    public function index()
    {
        $materis = Session::get('materis', []);
        dd($materis); // Untuk debugging, menampilkan data di browser
        // return view('some_view', ['materis' => $materis]); // Jika ingin ditampilkan di view
    }
}
