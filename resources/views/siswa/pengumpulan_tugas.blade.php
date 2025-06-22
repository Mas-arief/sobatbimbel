@extends('layouts.app') {{-- Pastikan ini adalah layout yang benar --}}

@section('title', 'Pengumpulan Tugas')

@section('content')
@include('siswa.modal_kumpul_tugas')

<div class="text-white p-2 bg-blue-800">
    <div class="container mx-auto flex justify-start items-center">
        {{-- Tombol kembali, mengarahkan ke halaman kursus siswa --}}
        <a href="{{ route('siswa.kursus.index') }}">
            <button class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-1 px-4 rounded shadow-md">
                Kembali
            </button>
        </a>
    </div>
</div>

<h1 class="text-2xl font-bold text-center mt-6 mb-6">Pengumpulan Tugas</h1>

<div class="max-w-xl mx-auto p-6 bg-white shadow-md border border-gray-200 rounded-lg dark:bg-gray-800 dark:border-gray-700">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Detail Tugas</h2>
    <div class="space-y-3 text-gray-700 dark:text-gray-300">
        <p><strong>Mata Pelajaran:</strong> {{ $mapel->nama ?? 'N/A' }}</p>
        <p><strong>Minggu Ke:</strong> {{ $mingguKe ?? 'N/A' }}</p>
        <p><strong>Judul Tugas:</strong> {{ $tugas->judul ?? 'N/A' }}</p>
        <p><strong>Deskripsi:</strong> {{ $tugas->deskripsi ?? 'N/A' }}</p>
        <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tugas->deadline ?? 'N/A')->format('d M Y H:i') }}</p>
        @if($tugas && $tugas->file_url)
            <p><strong>File Tugas:</strong> <a href="{{ Storage::url($tugas->file_url) }}" target="_blank" class="text-blue-500 hover:underline">Lihat File</a></p>
        @endif
    </div>

    <hr class="my-6 border-gray-300 dark:border-gray-600">

    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Status Pengumpulan Anda</h2>
    <table class="w-full text-left table-auto border-collapse">
        <tbody>
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="p-4 font-medium text-gray-700 dark:text-gray-300">Status Pengumpulan</td>
                <td class="p-4 text-gray-900 dark:text-white">
                    {{ $pengumpulanTugas->status ?? 'Belum diunggah' }}
                    @if($pengumpulanTugas && $pengumpulanTugas->status === 'submitted')
                        <span class="text-yellow-600 dark:text-yellow-400 font-semibold">(Menunggu Penilaian)</span>
                    @elseif($pengumpulanTugas && $pengumpulanTugas->status === 'graded')
                        <span class="text-green-600 dark:text-green-400 font-semibold">(Sudah Dinilai)</span>
                    @endif
                </td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="p-4 font-medium text-gray-700 dark:text-gray-300">Nilai</td>
                <td class="p-4 text-gray-900 dark:text-white">
                    {{ $pengumpulanTugas->nilai ?? '-' }}
                </td>
            </tr>
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="p-4 font-medium text-gray-700 dark:text-gray-300">File Anda</td>
                <td class="p-4 text-gray-900 dark:text-white">
                    @if($pengumpulanTugas && $pengumpulanTugas->file_path)
                        <a href="{{ Storage::url($pengumpulanTugas->file_path) }}" target="_blank" class="text-blue-500 hover:underline">Lihat File Anda</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="p-4 font-medium text-gray-700 dark:text-gray-300">Keterangan Anda</td>
                <td class="p-4 text-gray-900 dark:text-white">
                    {{ $pengumpulanTugas->keterangan_siswa ?? '-' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-6">
    <button data-modal-target="unggahModal" data-modal-toggle="unggahModal"
        class="bg-blue-900 hover:bg-blue-800 text-white text-sm font-bold py-2 px-6 rounded shadow-md"
        {{-- Tambahkan data attribute tugas-id untuk JS di modal --}}
        data-tugas-id="{{ $tugas->id ?? '' }}"> {{-- Pastikan $tugas ada sebelum mengakses id --}}
        UNGGAH TUGAS
    </button>
</div>

<script>
    // Pastikan variabel tugasId tersedia untuk modal jika halaman dimuat ulang
    const currentTugasIdFromPhp = "{{ $tugas->id ?? '' }}";
</script>
@endsection
s
