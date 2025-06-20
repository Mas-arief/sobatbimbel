@extends('layouts.app')

@section('content')
<main class="pt-25 px-6">
    <div class="w-full max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 mt-6">DAFTAR ABSENSI</h2>

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
                        @php $siswaId = auth()->user()->id; @endphp
                        @foreach ($mapel as $m)
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">
                                {{ $m->nama }}
                            </th>
                            @for ($i = 1; $i <= 16; $i++)
                                @php
                                $attendance=$attendanceData
                                ->where('id_siswa', $siswaId)
                                ->where('id_mapel', $m->id)
                                ->where('minggu_ke', $i)
                                ->first();

                                $status = '-';
                                $bgColor = 'bg-gray-100';

                                if ($attendance) {
                                if ($attendance->kehadiran) {
                                $status = 'Hadir';
                                $bgColor = 'bg-green-100 text-green-800';
                                } else {
                                $status = $attendance->keterangan ?? 'Alpha';
                                if (strtolower($attendance->keterangan ?? '') == 'sakit') {
                                $bgColor = 'bg-yellow-100 text-yellow-800';
                                } elseif (strtolower($attendance->keterangan ?? '') == 'izin') {
                                $bgColor = 'bg-blue-100 text-blue-800';
                                } else {
                                $bgColor = 'bg-red-100 text-red-800';
                                }
                                }
                                }
                                @endphp
                                <td class="px-2 py-1 border border-white dark:border-gray-700 {{ $bgColor }}">
                                    {{ $status }}
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