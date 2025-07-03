@extends('layouts.navbar')

@section('title', 'Rekap Tugas')

@section('content')
    <style>
        @keyframes floatingFade {
            0% { transform: translateX(15px); opacity: 0.3; }
            25% { opacity: 0.5; }
            50% { transform: translateX(-10px); opacity: 1; }
            75% { opacity: 0.5; }
            100% { transform: translateX(0px); opacity: 0.3; }
        }

        .animate-floating-fade {
            animation: floatingFade 15s ease-in-out infinite;
        }
    </style>

    {{-- background animasi --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/9.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div class="relative z-10 px-4 py-4">

        {{-- Pesan Sukses/Error (auto hide) --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                class="max-w-4xl mx-auto mb-4 transition ease-out duration-500"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                class="max-w-4xl mx-auto mb-4 transition ease-out duration-500"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="sticky top-0 z-10 dark:bg-white pb-3">
            <h1 class="text-center text-2xl font-bold mb-1 mt-3">REKAP PENGUMPULAN TUGAS
                @if (request('minggu'))
                    <span class="text-blue-600">MINGGU {{ request('minggu') }}</span>
                @endif
            </h1>
        </div>

        <div class="flex justify-end space-x-2 mt-4 mb-4 max-w-5xl mx-auto">
            <a href="{{ route('guru.kursus', ['minggu' => request('minggu')]) }}"
                class="bg-indigo-700 hover:bg-indigo-800 text-white px-3 py-1.5 rounded text-sm transition duration-300 ease-in-out transform hover:scale-105">
                Kembali ke Kursus
                @if (request('minggu'))
                    Minggu {{ request('minggu') }}
                @endif
            </a>
            <a href="{{ route('guru.pengumpulan') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded text-sm transition duration-300 ease-in-out transform hover:scale-105">
                Tampilkan Semua Tugas
            </a>
        </div>

        <div class="overflow-y-auto max-h-[500px] border rounded-md w-full max-w-5xl mx-auto shadow">
            <table class="min-w-full text-sm text-center border-collapse">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 border">NO</th>
                        <th class="px-4 py-3 border">NAMA</th>
                        <th class="px-4 py-3 border">TANGGAL KUMPUL</th>
                        <th class="px-4 py-3 border">TUGAS</th>
                        <th class="px-4 py-3 border">AKSI</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-50 text-gray-700">
                    @forelse ($tugas as $index => $item)
                        <tr class="border-b border-gray-300">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $item->siswa->name }}</td>
                            <td class="px-4 py-2 border">{{ $item->created_at->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border">{{ $item->tugas->judul ?? '-' }}</td>
                            <td class="px-4 py-2 border">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    @if ($item->file_path)
                                        <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            Lihat File
                                        </a>
                                    @else
                                        <span class="text-gray-500 text-xs">Belum ada file</span>
                                    @endif

                                    <form action="{{ route('pengumpulan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            Hapus
                                        </button>
                                    </form>

                                    {{-- Tombol Penilaian --}}
                                    @if ($item->file_path)
                                        <a href="{{ route('edit_tugas', ['siswa_id' => $item->siswa_id, 'tugas_id' => $item->tugas_id, 'minggu' => $item->minggu_ke]) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            Beri Nilai
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-gray-500 italic">Belum ada data tugas untuk minggu ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
