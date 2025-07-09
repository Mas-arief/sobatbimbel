<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use App\Models\Mapel; // Mengimpor model Mapel untuk berinteraksi dengan data mata pelajaran
use App\Models\User; // Mengimpor model User untuk berinteraksi dengan data pengguna (siswa)
use App\Models\Absensi; // Mengimpor model Absensi untuk berinteraksi dengan data absensi
use Illuminate\Support\Facades\Log; // Mengimpor Facade Log untuk keperluan debugging

class AbsensiController extends Controller
{
    /**
     * Menampilkan formulir absensi untuk guru.
     * Formulir ini memungkinkan guru untuk memasukkan atau memperbarui status absensi siswa.
     *
     * @param  int  $mapelId ID mata pelajaran yang akan diabsen.
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP.
     * @return \Illuminate\View\View
     */
    public function show($mapelId, Request $request)
    {
        // Mencari data mata pelajaran berdasarkan $mapelId. Jika tidak ditemukan, akan melempar 404.
        $mapel = Mapel::findOrFail($mapelId);
        // Mengambil semua pengguna dengan peran 'siswa'.
        $siswa = User::where('role', 'siswa')->get();

        // Mengambil nilai 'minggu' dari parameter query string (misal: ?minggu=2).
        // Jika parameter 'minggu' tidak ada, nilai defaultnya adalah 1.
        $minggu = $request->query('minggu', 1);

        // Mengambil data absensi yang sudah ada untuk mata pelajaran dan minggu yang spesifik.
        // Ini penting agar form bisa menampilkan status absensi yang sudah tersimpan sebelumnya.
        $absensiTersimpan = Absensi::where('id_mapel', $mapelId)
                                   ->where('minggu_ke', $minggu)
                                   ->get()
                                   ->keyBy('id_siswa'); // Mengubah koleksi menjadi array asosiatif dengan id_siswa sebagai kunci.

        // Menentukan tipe pengguna (dalam kasus ini 'guru') untuk keperluan view.
        $tipe = 'guru';
        // Mengembalikan view 'guru.absensi' dengan data yang diperlukan.
        // Data yang dikirimkan meliputi: mapel, siswa, minggu, tipe, dan absensiTersimpan.
        return view('guru.absensi', compact('mapel', 'siswa', 'minggu', 'tipe', 'absensiTersimpan'));
    }

    /**
     * Menyimpan data absensi yang dikirim oleh guru.
     * Metode ini menangani penambahan absensi baru atau pembaruan absensi yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data absensi.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi Input dari permintaan.
        $request->validate([
            'mapel_id' => ['required', 'integer', 'exists:mapel,id'], // ID mapel wajib, integer, dan harus ada di tabel 'mapel'.
            'minggu_ke' => ['required', 'integer', 'min:1', 'max:16'], // Minggu ke- wajib, integer, minimal 1, maksimal 16.
            'kehadiran' => ['required', 'array'], // 'kehadiran' wajib dan harus berupa array.
            // Setiap nilai dalam array 'kehadiran' harus salah satu dari 'hadir', 'izin', 'sakit', atau 'alpha'.
            'kehadiran.*' => ['required', 'string', 'in:hadir,izin,sakit,alpha'],
            'keterangan' => ['nullable', 'array'], // 'keterangan' opsional dan bisa berupa array.
            'keterangan.*' => ['nullable', 'string', 'max:255'], // Setiap keterangan dalam array bersifat opsional, string, maks 255 karakter.
        ]);

        // Mengambil nilai mapel_id dari input permintaan.
        $mapelId = $request->input('mapel_id');
        // Mengambil nilai minggu_ke dari input permintaan.
        $minggu = $request->input('minggu_ke');
        // Mengambil array data kehadiran (format: [siswa_id => status_kehadiran]).
        $kehadiranData = $request->input('kehadiran');
        // Mengambil array data keterangan (format: [siswa_id => keterangan]).
        $keteranganData = $request->input('keterangan');

        // --- Logging untuk Debugging (bisa dihapus setelah yakin berfungsi) ---
        // Mencatat informasi permintaan ke log Laravel untuk membantu debugging.
        Log::info('Absensi Store Request:', [
            'mapel_id' => $mapelId,
            'minggu_ke' => $minggu,
            'kehadiranData' => $kehadiranData,
            'keteranganData' => $keteranganData,
        ]);
        // --- Akhir Logging ---

        // Melakukan iterasi untuk setiap siswa dalam data kehadiran yang diterima.
        foreach ($kehadiranData as $siswaId => $status) {
            try {
                // 2. Menggunakan metode updateOrCreate untuk menyimpan atau memperbarui data absensi.
                // Jika record dengan 'id_siswa', 'id_mapel', dan 'minggu_ke' yang sama sudah ada,
                // maka record tersebut akan diperbarui. Jika tidak ada, record baru akan dibuat.
                Absensi::updateOrCreate(
                    [
                        'id_siswa' => $siswaId, // Kriteria pencarian: ID Siswa
                        'id_mapel' => $mapelId, // Kriteria pencarian: ID Mata Pelajaran
                        'minggu_ke' => $minggu, // Kriteria pencarian: Minggu ke-
                    ],
                    [
                        'kehadiran' => $status, // Data yang akan diperbarui/dibuat: Status kehadiran
                        // Mengambil keterangan spesifik untuk siswa ini dari array $keteranganData.
                        // Jika tidak ada keterangan untuk siswa ini, nilainya akan menjadi null.
                        'keterangan' => $keteranganData[$siswaId] ?? null,
                    ]
                );
                // Mencatat keberhasilan penyimpanan/pembaruan absensi untuk setiap siswa.
                Log::info("Absensi untuk Siswa ID: {$siswaId} berhasil disimpan/diperbarui dengan status: {$status}.");

            } catch (\Exception $e) {
                // Menangani kesalahan jika terjadi masalah saat menyimpan atau memperbarui absensi untuk siswa tertentu.
                Log::error("Gagal menyimpan/memperbarui absensi untuk Siswa ID: {$siswaId}. Error: " . $e->getMessage());
                // Anda bisa memilih untuk mengembalikan error di sini atau melanjutkan loop.
                // Untuk saat ini, kita hanya mencatat error dan melanjutkan agar proses tidak terhenti untuk siswa lain.
                // return back()->with('error', 'Gagal menyimpan absensi untuk beberapa siswa.');
            }
        }

        // --- PERUBAHAN PENTING DI SINI ---
        // Setelah semua absensi disimpan, arahkan kembali pengguna ke halaman input absensi yang sama
        // (untuk mapel dan minggu yang sama) dengan pesan sukses.
        // Ini memberikan pengalaman pengguna yang lebih baik karena mereka tetap berada di halaman yang relevan.
        return redirect()->route('guru.absensi.show', ['mapelId' => $mapelId, 'minggu' => $minggu])
                         ->with('success', 'Absensi berhasil disimpan.');
    }
}
