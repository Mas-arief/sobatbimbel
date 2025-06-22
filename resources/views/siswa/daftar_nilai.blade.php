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
                opacity: 2;
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

    <!-- background animasi -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/10.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <main class="pt-25 px-6">
        <div class="w-full max-w-6xl relative z-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 mt-6">DAFTAR NILAI</h2>

            <div class="p-4 rounded-lg">
                <div class="overflow-x-auto rounded-md shadow-md">
                    <table
                        class="w-full text-sm text-center text-black border border-white dark:text-white dark:border-gray-700">
                        <thead class="bg-gray-300 text-black dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th rowspan="2"
                                    class="px-4 py-2 border border-white rounded-tl-md align-middle w-40 dark:border-gray-700">
                                    Mapel
                                </th>
                                <th colspan="16"
                                    class="px-4 py-2 border border-white font-medium text-center dark:border-gray-700">
                                    Pertemuan ke
                                </th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 16; $i++)
                                    <th class="px-2 py-1 border border-white dark:border-gray-700">{{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100 dark:bg-gray-800">
                            @foreach ($mapel as $m)
                                <tr>
                                    <th
                                        class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">
                                        {{ $m->nama }}
                                    </th>
                                    @for ($i = 1; $i <= 16; $i++)
                                        <td class="px-2 py-1 border border-white dark:border-gray-700 dark:text-white">
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