@extends('layouts.app')

@section('content')
<main class="pt-25 px-6">
    <div class="w-full max-w-6xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">DAFTAR HADIR</h2>

        <div class="p-4 rounded-lg">
            <div class="overflow-x-auto rounded-md shadow-md">
                <table class="w-full text-sm text-center text-black border border-white dark:text-white dark:border-gray-700">
                    <thead class="bg-gray-300 text-black dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th rowspan="2" class="px-4 py-2 border border-white rounded-tl-md align-middle w-40 dark:border-gray-700">
                                Mapel
                            </th>
                            <th colspan="16" class="px-4 py-2 border border-white font-medium text-center dark:border-gray-700">
                                Minggu ke
                            </th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 16; $i++)
                                <th class="px-2 py-1 border border-white dark:border-gray-700">{{ $i }}</th>
                                @endfor
                        </tr>
                    </thead>
                    <tbody class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">Bahasa Indonesia</th>
                            @php
                            $bahasaIndonesia = ['sakit', '', '', '', '', 'hadir', '', '', '', 'izin', '', '', '', '', '', ''];
                            @endphp
                            @foreach ($bahasaIndonesia as $val)
                            <td class="px-2 py-1 border border-white dark:border-gray-700 dark:text-white">{{ $val }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">Bahasa Inggris</th>
                            @for ($i = 0; $i < 16; $i++)
                                <td class="px-2 py-1 border border-white dark:border-gray-700 dark:text-white">
                                </td>
                                @endfor
                        </tr>
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium rounded-bl-md dark:border-gray-700 dark:text-white">Matematika</th>
                            @for ($i = 0; $i < 16; $i++)
                                <td class="px-2 py-1 border border-white dark:border-gray-700 dark:text-white">
                                </td>
                                @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    @endsection