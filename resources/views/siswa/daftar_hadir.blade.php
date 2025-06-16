@extends('layouts.app')

@section('content')
<main class="pt-25 px-6">
    <div class="w-full max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mt-6">DAFTAR HADIR SISWA</h2>

            <!-- Filter Controls -->
            <div class="flex space-x-4">
                <select id="mapel-filter" class="px-4 py-2 border rounded-md">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}" {{ request('mapel_id') == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama }}
                    </option>
                    @endforeach
                </select>

                <select id="siswa-filter" class="px-4 py-2 border rounded-md">
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ request('siswa_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name ?? $student->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="p-4 rounded-lg">
            <div class="overflow-x-auto rounded-md shadow-md">
                <table class="w-full text-sm text-center text-black border border-white dark:text-white dark:border-gray-700">
                    <thead class="bg-gray-300 text-black dark:bg-gray-700 dark:text-gray-300">
                        <tr>
                            <th rowspan="2" class="px-4 py-2 border border-white rounded-tl-md align-middle w-40 dark:border-gray-700">
                                @if(request('siswa_id'))
                                Siswa
                                @else
                                Mapel
                                @endif
                            </th>
                            <th colspan="16" class="px-4 py-2 border border-white font-medium text-center dark:border-gray-700">
                                Minggu ke
                            </th>
                            <th rowspan="2" class="px-4 py-2 border border-white align-middle dark:border-gray-700">
                                Total Hadir
                            </th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 16; $i++)
                                <th class="px-2 py-1 border border-white dark:border-gray-700">
                                <a href="#" onclick="showWeekDetail( $i )" class="hover:text-blue-600">
                                    {{ $i }}
                                </a>
                                </th>
                                @endfor
                        </tr>
                    </thead>
                    <tbody class="bg-gray-100 dark:bg-gray-800">
                        @if(request('siswa_id'))
                        {{-- Show attendance for specific student across all subjects --}}
                        @php
                        $selectedStudent = $students->find(request('siswa_id'));
                        @endphp
                        @if($selectedStudent)
                        @foreach($mapels as $mapel)
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">
                                <a href="{{ route('absensi.index', ['mapel_id' => $mapel->id]) }}"
                                    class="hover:text-blue-600">
                                    {{ $mapel->nama }}
                                </a>
                            </th>
                            @php
                            $totalHadir = 0;
                            @endphp
                            @for ($week = 1; $week <= 16; $week++)
                                @php
                                $attendance=$attendanceData
                                ->where('id_siswa', $selectedStudent->id)
                                ->where('id_mapel', $mapel->id)
                                ->where('minggu_ke', $week)
                                ->first();

                                $status = '';
                                $bgColor = 'bg-gray-100';

                                if ($attendance) {
                                if ($attendance->kehadiran) {
                                $status = '✓';
                                $bgColor = 'bg-green-100 text-green-800';
                                $totalHadir++;
                                } else {
                                $status = $attendance->keterangan ?? '✗';
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
                                <td class="px-2 py-1 border border-white dark:border-gray-700 {{ $bgColor }}"
                                    title="{{ $attendance ? ($attendance->kehadiran ? 'Hadir' : ($attendance->keterangan ?? 'Tidak Hadir')) : 'Belum Ada Data' }}">
                                    {{ $status ?: '-' }}
                                </td>
                                @endfor
                                <td class="px-4 py-2 border border-white font-bold {{ $totalHadir >= 12 ? 'text-green-600' : ($totalHadir >= 8 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $totalHadir }}/16
                                </td>
                        </tr>
                        @endforeach
                        @endif
                        @else
                        {{-- Show attendance for all subjects (or filtered subject) --}}
                        @foreach($mapels as $mapel)
                        <tr>
                            <th class="px-4 py-2 border border-white text-center font-medium dark:border-gray-700 dark:text-white">
                                <a href="{{ route('absensi.index', ['mapel_id' => $mapel->id]) }}"
                                    class="hover:text-blue-600">
                                    {{ $mapel->nama }}
                                </a>
                            </th>
                            @php
                            $totalHadirPerMapel = 0;
                            @endphp
                            @for ($week = 1; $week <= 16; $week++)
                                @php
                                $weeklyAttendance=$attendanceData
                                ->where('id_mapel', $mapel->id)
                                ->where('minggu_ke', $week);

                                $totalStudents = $weeklyAttendance->count();
                                $presentStudents = $weeklyAttendance->where('kehadiran', true)->count();

                                $status = $totalStudents > 0 ? round(($presentStudents / $totalStudents) * 100) . '%' : '-';
                                $bgColor = 'bg-gray-100';

                                if ($totalStudents > 0) {
                                $percentage = ($presentStudents / $totalStudents) * 100;
                                if ($percentage >= 80) {
                                $bgColor = 'bg-green-100 text-green-800';
                                } elseif ($percentage >= 60) {
                                $bgColor = 'bg-yellow-100 text-yellow-800';
                                } else {
                                $bgColor = 'bg-red-100 text-red-800';
                                }
                                $totalHadirPerMapel += $presentStudents;
                                }
                                @endphp
                                <td class="px-2 py-1 border border-white dark:border-gray-700 {{ $bgColor }}"
                                    title="Minggu {{ $week }}: {{ $presentStudents }}/{{ $totalStudents }} siswa hadir">
                                    <a href="{{ route('absensi.index', ['mapel_id' => $mapel->id, 'minggu_ke' => $week]) }}"
                                        class="hover:underline">
                                        {{ $status }}
                                    </a>
                                </td>
                                @endfor
                                <td class="px-4 py-2 border border-white font-bold text-blue-600">
                                    {{ $totalHadirPerMapel }}
                                </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Legend -->
            <div class="mt-4 flex flex-wrap gap-4 text-sm">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-green-100 border border-green-300 rounded"></div>
                    <span>Hadir / >80%</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-yellow-100 border border-yellow-300 rounded"></div>
                    <span>Sakit / 60-80%</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-blue-100 border border-blue-300 rounded"></div>
                    <span>Izin</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-red-100 border border-red-300 rounded"></div>
                    <span>Alpha / <60%< /span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-gray-100 border border-gray-300 rounded"></div>
                    <span>Belum Ada Data</span>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Filter functionality
    document.getElementById('mapel-filter').addEventListener('change', function() {
        updateFilters();
    });

    document.getElementById('siswa-filter').addEventListener('change', function() {
        updateFilters();
    });

    function updateFilters() {
        const mapelId = document.getElementById('mapel-filter').value;
        const siswaId = document.getElementById('siswa-filter').value;

        const params = new URLSearchParams();
        if (mapelId) params.set('mapel_id', mapelId);
        if (siswaId) params.set('siswa_id', siswaId);

        window.location.href = '{{ route("absensi.dashboard") }}' +
            (params.toString() ? '?' + params.toString() : '');
    }

    function showWeekDetail(week) {
        const mapelId = document.getElementById('mapel-filter').value;
        if (mapelId) {
            window.location.href = `{{ route('absensi.index') }}?mapel_id=${mapelId}&minggu_ke=${week}`;
        } else {
            alert('Pilih mata pelajaran terlebih dahulu');
        }
    }
</script>
@endsection