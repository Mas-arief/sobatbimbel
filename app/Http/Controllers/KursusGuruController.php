<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel; // Pastikan Anda mengimpor model Mapel
use Illuminate\Support\Facades\Auth; // Pastikan Anda mengimpor Auth

class KursusGuruController extends Controller
{
    public function index()
    {
        // Mendapatkan guru yang sedang login
        $guru = Auth::user();

        // Mengambil mapel yang diajar oleh guru ini
        // Asumsi relasi user->mapel() sudah didefinisikan di model User
        $mapelGuru = $guru->mapel; // Ini akan mengembalikan objek Mapel tunggal jika relasinya belongsTo

        // Buat array $mapel yang berisi objek Mapel yang relevan
        $mapel = [];
        if ($mapelGuru) {
            // Asumsi kolom 'nama' di tabel 'mapel' berisi 'Bahasa Indonesia', 'Bahasa Inggris', 'Matematika'
            if ($mapelGuru->nama == 'Bahasa Indonesia') {
                $mapel['indo'] = $mapelGuru;
            } elseif ($mapelGuru->nama == 'Bahasa Inggris') {
                $mapel['inggris'] = $mapelGuru;
            } elseif ($mapelGuru->nama == 'Matematika') {
                $mapel['mtk'] = $mapelGuru;
            }
        }

        // Tentukan tab default yang akan aktif berdasarkan mapel guru
        $defaultTab = 'indo'; // Default, jika tidak ada mapel terhubung
        if (isset($mapel['indo'])) {
            $defaultTab = 'indo';
        } elseif (isset($mapel['inggris'])) {
            $defaultTab = 'inggris';
        } elseif (isset($mapel['mtk'])) {
            $defaultTab = 'mtk';
        }

$tipe='guru';
        // Teruskan variabel $mapel dan $defaultTab ke view
        return view('guru.kursus', compact('mapel', 'defaultTab', 'tipe')); // Ganti 'kursus' dengan nama file view Anda
    }
}
