{{-- resources/views/absensi/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border-t-4 border-blue-600 mb-6">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">INPUT DAFTAR HADIR</h1>

                <!-- Info Mapel dan Minggu -->
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <span class="text-gray-700 font-medium w-20">Mapel:</span>
                        <span class="text-gray-800">{{ $mapel->nama }}</span>
                    </div>
                    <div class="flex items-center mb-4">
    <label for="minggu_ke" class="text-gray-700 font-medium w-20">Minggu Ke:</label>
    <select name="minggu_ke" id="minggu_ke" class="px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-700">
        @foreach ($availableWeeks as $week)
            <option value="{{ $week }}" {{ $week == $mingguKe ? 'selected' : '' }}>
                Minggu ke-{{ $week }}
            </option>
        @endforeach
    </select>
</div>

                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('absensi.store') }}">
                    @csrf
                    <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                    <input type="hidden" name="minggu_ke" value="{{ $mingguKe }}">

                    <!-- Tabel Absensi -->
                    <div class="bg-white rounded-lg overflow-hidden border">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 border-b">Nama</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 border-b">Kehadiran</th>
                                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 border-b">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $index => $absen)
                                <tr class="border-b {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors">
                                    <td class="px-6 py-4 text-gray-800">
                                        {{ $absen->siswa->nama ?? 'Nama Siswa/i' }}
                                        <input type="hidden" name="siswa_id[{{ $index }}]" value="{{ $absen->siswa->id }}">
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <input type="checkbox"
                                                class="kehadiran-checkbox w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                                name="kehadiran[{{ $index }}]"
                                                value="1"
                                                {{ $absen->kehadiran ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <input type="text"
                                            name="keterangan[{{ $index }}]"
                                            value="{{ $absen->keterangan }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Masukkan keterangan...">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md transition-colors duration-200 shadow-sm">
                            SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto ceklis semua siswa
    function checkAll() {
        document.querySelectorAll('.kehadiran-checkbox').forEach(cb => cb.checked = true);
    }
</script>
@endsection