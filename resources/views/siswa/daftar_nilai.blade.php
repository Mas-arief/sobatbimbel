@extends('layouts.app')

@section('content')

    <style>
        @keyframes floatingFade {
            0% {
                transform: translateY(0px);
                opacity: 0.5;
            }

            25% {
                opacity: 1;
            }

            50% {
                transform: translateY(0px);
                opacity: 2; /* Nilai opacity maksimum adalah 1, 2 tidak akan memberikan efek lebih */
            }

            75% {
                opacity: 1;
            }

            100% {
                transform: translateY(0px);
                opacity: 0.5;
            }
        }

        .animate-floating-fade {
            animation: floatingFade 15s ease-in-out infinite;
        }
    </style>

    {{-- Background animasi --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/10.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    {{-- Mengubah main menjadi lebih terpusat dan responsif --}}
    <main class="min-h-screen flex flex-col items-center py-10 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="w-full max-w-6xl mx-auto"> {{-- mx-auto untuk centering --}}
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 mt-6 text-center">DAFTAR NILAI</h2>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-xl"> {{-- Tambahkan shadow dan warna latar --}}
                <div class="overflow-x-auto rounded-md border dark:border-gray-700"> {{-- Tambahkan border ke wrapper tabel --}}
                    <table
                        class="w-full text-sm text-center text-black dark:text-white"> {{-- Hapus border di sini karena sudah di wrapper --}}
                        <thead class="bg-blue-600 text-white dark:bg-blue-700 dark:text-gray-100"> {{-- Ubah warna header --}}
                            <tr>
                                <th rowspan="2"
                                    class="px-4 py-3 border-b border-r border-blue-700 dark:border-gray-600 align-middle w-40 rounded-tl-md">
                                    Mapel
                                </th>
                                <th colspan="16"
                                    class="px-4 py-3 border-b border-blue-700 dark:border-gray-600 font-medium text-center rounded-tr-md">
                                    Pertemuan ke
                                </th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 16; $i++)
                                    <th class="px-2 py-2 border-r border-blue-700 last:border-r-0 dark:border-gray-600">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700"> {{-- Ubah warna body dan tambahkan divider --}}
                            @foreach ($mapel as $m)
                                <tr>
                                    <th
                                        class="px-4 py-2 border-r border-gray-200 dark:border-gray-700 text-left font-medium text-gray-800 dark:text-white"> {{-- Align text ke kiri untuk nama mapel --}}
                                        {{ $m->nama }}
                                    </th>
                                    @for ($i = 1; $i <= 16; $i++)
                                        <td class="px-2 py-1 border-r border-gray-200 last:border-r-0 dark:border-gray-700 dark:text-white">
                                            @php
                                                // $penilaianSiswa is grouped by mapel_id in controller
                                                // So, $penilaianSiswa->get($m->id) gives us a collection of grades for this mapel
                                                // Then we find the specific grade for the current week ($i)
                                                $nilaiDitemukan = $penilaianSiswa->get($m->id)?->where('minggu', $i)->first();
                                            @endphp
                                            {{ $nilaiDitemukan ? $nilaiDitemukan->nilai : '-' }}
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
