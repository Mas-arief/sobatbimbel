<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\User;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DaftarHadirController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        try {
            $this->validateRequiredTables(); // Memastikan tabel ada

            $mapel = Mapel::orderBy('nama')->get();
            $students = User::where('role', 'siswa')->orderBy('name')->get();

            $query = Absensi::with(['siswa:id,name,email', 'mapel:id,nama']);

            if ($request->filled('mapel_id')) {
                $query->where('id_mapel', $request->input('mapel_id'));
            }

            if ($request->filled('siswa_id')) {
                $query->where('id_siswa', $request->input('siswa_id'));
            }

            $attendanceData = $query->get();
           $tipe = 'siswa';
            return view('siswa.daftar_hadir', compact('mapel', 'students', 'attendanceData', 'tipe'));
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memuat daftar hadir: ' . $e->getMessage());
        }
    }

    private function validateRequiredTables(): void
    {
        $requiredTables = ['absensi', 'users', 'mapel']; // Perbaikan: absensis -> absensi

        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                throw new \Exception("Tabel `{$table}` tidak ditemukan di database Anda. Pastikan migrasi sudah dijalankan.");
            }
        }
    }
}
