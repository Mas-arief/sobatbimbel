<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Materi; // Import Materi model
use App\Models\Tugas;  // Import Tugas model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class KursusGuruController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user();
        // Asumsi: Relasi 'mapel' di model User mengembalikan satu objek Mapel
        // Jika guru bisa mengajar banyak mapel, logika ini perlu diubah
        $mapelGuru = $guru->mapel; // Ini akan mengembalikan objek Mapel atau null

        $mapel = []; // Akan berisi ['indo' => MapelObj, 'inggris' => MapelObj, 'mtk' => MapelObj]
        $materials = []; // Akan berisi ['indo' => Collection, 'inggris' => Collection, 'mtk' => Collection]
        $assignments = []; // Akan berisi ['indo' => Collection, 'inggris' => Collection, 'mtk' => Collection]
        $defaultTab = 'indo'; // Default tab awal

        if ($mapelGuru) {
            $mapelName = $mapelGuru->nama; // Asumsi kolom nama mapel adalah 'nama' atau 'nama_mapel'
            $mapelId = $mapelGuru->id;

            // Tentukan kunci array berdasarkan nama mapel untuk konsistensi di Blade
            $key = '';
            if (Str::contains($mapelName, 'Indonesia', true)) { // Menggunakan Str::contains untuk fleksibilitas
                $key = 'indo';
            } elseif (Str::contains($mapelName, 'Inggris', true)) {
                $key = 'inggris';
            } elseif (Str::contains($mapelName, 'Matematika', true)) {
                $key = 'mtk';
            }

            if ($key) {
                $mapel[$key] = $mapelGuru;
                $defaultTab = $request->query('tab', $key); // Set default tab ke mapel guru jika ada
            }

            // Ambil semua materi dan tugas untuk mapel yang diajar guru
            // dan eager load relasi materis dan tugas
            // Gunakan eager loading di sini untuk menghindari N+1 query jika guru mengajar banyak mapel
            // Namun, karena asumsi 1 guru 1 mapel, kita bisa langsung query
            $allMaterialsForGuruMapel = Materi::where('mapel_id', $mapelId)->get()->groupBy('minggu_ke');
            $allAssignmentsForGuruMapel = Tugas::where('mapel_id', $mapelId)->get()->groupBy('minggu');

            // Isi array $materials dan $assignments dengan kunci yang sesuai
            if ($key) {
                $materials[$key] = $allMaterialsForGuruMapel;
                $assignments[$key] = $allAssignmentsForGuruMapel;
            }
        }

        $tipe = 'guru';

        // Pastikan semua variabel yang digunakan di Blade di-compact
        return view('guru.kursus', compact('mapel', 'defaultTab', 'tipe', 'materials', 'assignments'));
    }
}
