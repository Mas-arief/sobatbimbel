<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Materi; // Import Materi model
use App\Models\Tugas;  // Import Tugas model
use Illuminate\Support\Facades\Auth;

class KursusGuruController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        $mapelGuru = $guru->mapel;

        $mapel = [];
        $materials = [];
        $tasks = [];
        $defaultTab = 'indo';

        if ($mapelGuru) {
            $mapelName = $mapelGuru->nama;
            $mapelId = $mapelGuru->id;

            if ($mapelName == 'Bahasa Indonesia') {
                $mapel['indo'] = $mapelGuru;
                $defaultTab = 'indo';
            } elseif ($mapelName == 'Bahasa Inggris') {
                $mapel['inggris'] = $mapelGuru;
                $defaultTab = 'inggris';
            } elseif ($mapelName == 'Matematika') {
                $mapel['mtk'] = $mapelGuru;
                $defaultTab = 'mtk';
            }

            // Fetch materials and tasks for the assigned mapel
            $materials[$mapelName] = Materi::where('mapel_id', $mapelId)->get()->groupBy('minggu_ke');
            $tasks[$mapelName] = Tugas::where('mapel_id', $mapelId)->get()->groupBy('minggu');
        }

        $tipe = 'guru';

        return view('guru.kursus', compact('mapel', 'defaultTab', 'tipe', 'materials', 'tasks'));
    }
}
