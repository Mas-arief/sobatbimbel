@extends('layouts.app')

@section('content')
<main class="pt-25 px-6">
    <div class="w-full max-w-6xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 mt-6">DAFTAR NILAI</h2>

        <div class="p-4 rounded-lg">
            <div class="overflow-x-auto rounded-md shadow-md">
                <table class="w-full text-sm text-center text-black border border-white dark:text-white dark:border-gray-700">
                    <thead class="bg-gray-300 text-black dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th rowspan="2" class="px-4 py-2 border border-white rounded-tl-md align-middle w-40 dark:border-gray-700">
                                Mapel
                            </th>
                            <th colspan="16" class="px-4 py-2 border border-white font-medium text-center dark:border-gray-700">
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
                        {{-- Bahasa Indonesia --}}
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">
                                Bahasa Indonesia
                            </th>
                            @php
                                $nilaiBahasaIndonesia = [80, 85, 78, 90, '', 88, '', 92, '', 86, '', '', '', 84, '', 89];
                            @endphp
                            @foreach ($nilaiBahasaIndonesia as $nilai)
                                <td class="px-2 py-1 border border-white dark:border-gray-700 dark:text-white">
                                    {{ $nilai !== '' ? $nilai : '-' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Bahasa Inggris --}}
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">
                                Bahasa Inggris
                            </th>
                            @php
                                $nilaiBahasaInggris = [75, 80, '', '', 82, '', 79, '', '', '', '', '', '', '', '', ''];
                            @endphp
                            @foreach ($nilaiBahasaInggris as $nilai)
                                <td class="px-2 py-1 border border-white dark:border-gray-700 dark:text-white">
                                    {{ $nilai !== '' ? $nilai : '-' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Matematika --}}
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium rounded-bl-md dark:border-gray-700 dark:text-white">
                                Matematika
                            </th>
                            @php
                                $nilaiMatematika = [90, '', 85, 88, '', '', '', 91, '', '', '', 86, '', '', 89, ''];
                            @endphp
                            @foreach ($nilaiMatematika as $nilai)
                                <td class="px-2 py-1 border border-white dark:border-gray-700 dark:text-white">
                                    {{ $nilai !== '' ? $nilai : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
