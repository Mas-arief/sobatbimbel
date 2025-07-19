<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Mengimpor kelas Request untuk menangani permintaan HTTP
use App\Models\Penilaian; // Mengimpor model Penilaian untuk berinteraksi dengan data nilai siswa
use App\Models\Mapel; // Mengimpor model Mapel untuk berinteraksi dengan data mata pelajaran
use App\Models\User; // Mengimpor model User untuk berinteraksi dengan data pengguna (siswa)
use App\Models\PengumpulanTugas; // Mengimpor model PengumpulanTugas untuk berinteraksi dengan data pengumpulan tugas

class PenilaianController extends Controller
{
    /**
     * Menampilkan formulir input nilai untuk semua siswa dalam satu mata pelajaran dan satu minggu tertentu.
     * Guru akan menggunakan halaman ini untuk memasukkan atau memperbarui nilai.
     *
     * @param  int  $mapelId ID mata pelajaran yang akan dinilai.
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang mungkin berisi parameter 'minggu'.
     * @return \Illuminate\View\View
     */
    public function index($mapelId, Request $request)
    {
        // Mencari data mata pelajaran berdasarkan $mapelId. Jika tidak ditemukan, akan melempar 404.
        $mapel = Mapel::findOrFail($mapelId);
        // Mengambil semua pengguna dengan peran 'siswa'.
        $siswa = User::where('role', 'siswa')->get();
        // Mengambil nilai 'minggu' dari parameter query string (misal: ?minggu=2).
        // Jika parameter 'minggu' tidak ada, nilai defaultnya adalah 1.
        $minggu = $request->query('minggu', 1);

        // Mengambil data penilaian yang sudah ada untuk mata pelajaran dan minggu ini.
        $penilaianData = Penilaian::where('mapel_id', $mapelId)
            ->where('minggu', $minggu)
            ->get();

        // Mengubah koleksi penilaian menjadi array asosiatif dengan 'siswa_id' sebagai kunci.
        // Ini memudahkan untuk mengakses nilai siswa tertentu di view.
        $penilaian = $penilaianData->keyBy('siswa_id');

        // Menentukan tipe pengguna sebagai 'guru' untuk keperluan view.
        $tipe = 'guru';

        // Mengembalikan view 'guru.penilaian' dengan data yang diperlukan.
        // Data yang dikirimkan meliputi: mapel, siswa, penilaian (yang sudah ada), minggu, dan tipe.
        return view('guru.penilaian', compact('mapel', 'siswa', 'penilaian', 'minggu', 'tipe'));
    }

    /**
     * Menyimpan atau memperbarui nilai secara massal.
     * Metode ini digunakan oleh guru untuk menyimpan nilai banyak siswa sekaligus dari formulir.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data nilai.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari permintaan.
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id', // ID mapel wajib dan harus ada di tabel 'mapel'.
            'minggu' => 'required|integer|min:1|max:16', // Minggu wajib, integer, min 1, maks 16.
            'nilai' => 'required|array', // 'nilai' wajib dan harus berupa array.
            'nilai.*' => 'nullable|integer|min:0|max:100', // Setiap nilai dalam array bersifat opsional, integer, min 0, maks 100.
        ]);

        // Mengambil data dari input permintaan.
        $mapelId = $request->input('mapel_id');
        $minggu = $request->input('minggu');
        $nilaiData = $request->input('nilai'); // Ini adalah array [siswa_id => nilai]

        // Melakukan iterasi untuk setiap siswa dalam data nilai yang diterima.
        foreach ($nilaiData as $siswaId => $nilai) {
            // Hanya proses jika nilai tidak kosong atau null.
            if ($nilai !== null && $nilai !== '') {
                // Menggunakan metode updateOrCreate untuk menyimpan atau memperbarui nilai.
                // Jika record dengan 'siswa_id', 'mapel_id', dan 'minggu' yang sama sudah ada,
                // maka record tersebut akan diperbarui. Jika tidak ada, record baru akan dibuat.
                Penilaian::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'mapel_id' => $mapelId,
                        'minggu' => $minggu,
                    ],
                    [
                        'nilai' => $nilai,
                    ]
                );
            }
        }

        // Mengarahkan kembali ke halaman input nilai yang sama (untuk mapel dan minggu yang sama)
        // dengan pesan sukses.
        return redirect()->route('penilaian.index', ['mapelId' => $mapelId, 'minggu' => $minggu])
            ->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Menampilkan formulir untuk mengedit nilai satu siswa dari halaman rekap tugas.
     *
     * @param  int  $siswaId ID siswa.
     * @param  int  $tugasId ID tugas (tidak digunakan langsung dalam query ini, tapi bisa relevan untuk konteks).
     * @param  int  $minggu Minggu ke-.
     * @return \Illuminate\View\View
     */
    public function edit($siswaId, $tugasId, $minggu)
    {
        // Mengambil data pengumpulan tugas berdasarkan siswa_id dan minggu.
        // firstOrFail() akan melempar 404 jika tidak ada record yang cocok.
        $pengumpulan = PengumpulanTugas::where('siswa_id', $siswaId)
            ->where('minggu_ke', $minggu)
            ->firstOrFail();

        // Mengambil data penilaian yang sudah ada untuk siswa dan minggu ini.
        // Jika tidak ada, akan mengembalikan null.
        $penilaian = Penilaian::where('siswa_id', $siswaId)
            ->where('minggu', $minggu)
            ->first();

        // Mengembalikan view 'guru.edit_tugas' dengan data pengumpulan dan penilaian.
        return view('guru.edit_tugas', compact('pengumpulan', 'penilaian'));
    }

    /**
     * Menyimpan nilai dari formulir edit nilai satu siswa.
     * Metode ini digunakan oleh guru untuk menyimpan nilai tugas individual.
     *
     * @param  \Illuminate\Http\Request  $request Objek permintaan HTTP yang berisi data nilai.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function simpan(Request $request)
    {
        // Validasi input dari permintaan.
        $request->validate([
            'siswa_id' => 'required|integer|exists:users,id', // ID siswa wajib, integer, dan harus ada di tabel 'users'.
            'minggu' => 'required|integer|min:1|max:16', // Minggu wajib, integer, min 1, maks 16.
            'nilai' => 'required|integer|min:0|max:100', // Nilai wajib, integer, min 0, maks 100.
        ]);

        // Mengambil mapel_id dari model Tugas berdasarkan tugas_id yang diberikan.
        // Ini memastikan nilai dikaitkan dengan mata pelajaran yang benar.
        $tugas = \App\Models\Tugas::findOrFail($request->tugas_id);
        $mapelId = $tugas->mapel_id;

        // Memperbarui atau membuat record Penilaian.
        // Jika record dengan 'siswa_id' dan 'minggu' yang sama sudah ada,
        // maka akan diperbarui. Jika tidak ada, record baru akan dibuat.
        Penilaian::updateOrCreate(
            [
                'siswa_id' => $request->siswa_id,
                'minggu' => $request->minggu,
            ],
            [
                'mapel_id' => $mapelId, // Menyimpan mapel_id yang diambil dari tugas.
                'nilai' => $request->nilai,
            ]
        );

        // Mengarahkan kembali ke halaman rekap pengumpulan tugas guru untuk minggu yang sama
        // dengan pesan sukses.
        return redirect()->route('guru.pengumpulan', [
            // Perhatikan bahwa 'mapelId' mungkin tidak diperlukan di route 'guru.pengumpulan'
            // jika route tersebut hanya memfilter berdasarkan 'minggu'.
            // Jika diperlukan, pastikan Anda memiliki cara untuk mendapatkan mapelId yang relevan.
            // Untuk saat ini, saya akan menyertakannya berdasarkan asumsi route Anda.
            'mapelId' => $mapelId, // Ini mungkin perlu disesuaikan jika route guru.pengumpulan tidak menggunakan mapelId
            'minggu' => $request->minggu,
        ])->with('success', 'Nilai berhasil disimpan.');
    }
}
