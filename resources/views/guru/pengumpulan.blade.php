@extends('layouts.navbar')

@section('title', 'Rekap Tugas')

@section('content')
<div class="px-4 py-4">
    <!-- Judul Sticky -->
    <div class="sticky top-0 z-10 dark:bg-white pb-3">
        <h1 class="text-center text-lg font-bold mb-1">REKAP PENGUMPULAN TUGAS</h1>
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-end space-x-2 mt-4 mb-4  max-w-5xl mx-auto">
        <a href="{{ route('guru.kursus') }}" class="bg-indigo-700 hover:bg-indigo-800 text-white px-3 py-1.5 rounded text-sm">
            Kembali
        </a>
        {{-- Tambahkan aksi lain jika dibutuhkan --}}
    </div>

    <!-- Scrollable Table -->
    <div class="overflow-y-auto max-h-[500px] border rounded-md w-full max-w-5xl mx-auto shadow">
        <table class="min-w-full text-sm text-center border-collapse">
            <thead class="bg-gray-200 text-gray-700 uppercase text-xs sticky top-0 z-10">
                <tr>
                    <th class="px-4 py-3 border">NO</th>
                    <th class="px-4 py-3 border">SISWA</th>
                    <th class="px-4 py-3 border">TANGGAL KUMPUL</th>
                    <th class="px-4 py-3 border">TUGAS</th>
                    <th class="px-4 py-3 border">NILAI</th>
                    <th class="px-4 py-3 border">AKSI</th>
                </tr>
            </thead>
            <tbody class="bg-gray-50 text-gray-700">
                @foreach ($tugas as $index => $item)
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $item->siswa->nama }}</td>
                        <td class="px-4 py-2 border">{{ $item->tanggal_kumpul->format('d-m-Y') }}</td>
                        <td class="px-4 py-2 border">{{ $item->judul_tugas }}</td>
                        <td class="px-4 py-2 border">{{ $item->nilai ?? '-' }}</td>
                        <td class="px-4 py-2 border">
                            <a href="{{ route('guru.tugas.edit', $item->id) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach

                @if ($tugas->isEmpty())
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-gray-500 italic">Belum ada data tugas.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
