<?php

namespace App\Http\Controllers;

use App\Models\Absensi; // Mengimpor model Absensi untuk berinteraksi dengan data absensi
use App\Models\User; // Mengimpor model User untuk berinteraksi dengan data pengguna (siswa)
use App\Models\Mapel; // Mengimpor model Mapel untuk berinteraksi dengan data mata pelajaran
use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use Illuminate\Support\Facades\Schema; // Mengimpor Facade Schema untuk memeriksa keberadaan tabel database
use Illuminate\View\View; // Mengimpor tipe kembalian View
use Illuminate\Http\RedirectResponse; // Mengimpor tipe kembalian RedirectResponse

class DaftarHadirController extends Controller
{
    /**
     * Menampilkan daftar hadir siswa.
     * Metode ini dapat memfilter daftar hadir berdasarkan mata pelajaran atau siswa.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang mungkin berisi filter.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request): View|RedirectResponse
    {
        try {
            // Memvalidasi keberadaan tabel-tabel yang diperlukan di database.
            // Jika ada tabel yang tidak ditemukan, akan melempar Exception.
            $this->validateRequiredTables();

            // Mengambil semua data mata pelajaran, diurutkan berdasarkan nama.
            $mapel = Mapel::orderBy('nama')->get();
            // Mengambil semua pengguna dengan peran 'siswa', diurutkan berdasarkan nama.
            $students = User::where('role', 'siswa')->orderBy('name')->get();

            // Memulai query untuk model Absensi dengan eager loading relasi 'siswa' dan 'mapel'.
            // Hanya kolom 'id', 'name', 'email' yang diambil dari 'siswa', dan 'id', 'nama' dari 'mapel'
            // untuk optimasi performa.
            $query = Absensi::with(['siswa:id,name,email', 'mapel:id,nama']);

            // Memeriksa apakah parameter 'mapel_id' ada dan tidak kosong dalam permintaan.
            if ($request->filled('mapel_id')) {
                // Jika ada, tambahkan kondisi WHERE untuk memfilter berdasarkan id_mapel.
                $query->where('id_mapel', $request->input('mapel_id'));
            }

            // Memeriksa apakah parameter 'siswa_id' ada dan tidak kosong dalam permintaan.
            if ($request->filled('siswa_id')) {
                // Jika ada, tambahkan kondisi WHERE untuk memfilter berdasarkan id_siswa.
                $query->where('id_siswa', $request->input('siswa_id'));
            }

            // Menjalankan query dan mengambil semua data absensi yang cocok dengan filter.
            $attendanceData = $query->get();
            // Menentukan tipe pengguna sebagai 'siswa' untuk keperluan view.
            $tipe = 'siswa';
            // Mengembalikan view 'siswa.daftar_hadir' dengan data yang diperlukan.
            // Data yang dikirimkan meliputi: mapel, students, attendanceData, dan tipe.
            return view('siswa.daftar_hadir', compact('mapel', 'students', 'attendanceData', 'tipe'));
        } catch (\Exception $e) {
            // Menangkap setiap pengecualian yang terjadi selama proses.
            // Mengarahkan kembali ke halaman sebelumnya dengan pesan error yang berisi detail kesalahan.
            return back()->withErrors('Terjadi kesalahan saat memuat daftar hadir: ' . $e->getMessage());
        }
    }

    /**
     * Memvalidasi keberadaan tabel-tabel yang diperlukan di database.
     *
     * @throws \Exception Jika salah satu tabel yang diperlukan tidak ditemukan.
     * @return void
     */
    private function validateRequiredTables(): void
    {
        // Mendefinisikan array nama-nama tabel yang wajib ada.
        $requiredTables = ['absensi', 'users', 'mapel']; // Perbaikan: 'absensis' menjadi 'absensi' agar sesuai dengan konvensi Laravel (nama tabel tunggal).

        // Melakukan iterasi pada setiap nama tabel yang diperlukan.
        foreach ($requiredTables as $table) {
            // Memeriksa apakah tabel saat ini ada di database.
            if (!Schema::hasTable($table)) {
                // Jika tabel tidak ditemukan, lempar Exception dengan pesan yang informatif.
                throw new \Exception("Tabel `{$table}` tidak ditemukan di database Anda. Pastikan migrasi sudah dijalankan.");
            }
        }
    }
}
