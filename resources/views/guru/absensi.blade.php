@extends('layouts.navbar')

@section('title', 'Input Absensi')

@section('content')
    <div class="flex justify-center mt-10 w-full px-4">
        <div class="w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-4 text-center">INPUT DAFTAR HADIR</h2>

            <p><strong>Mapel:</strong> {{ $mapel->nama }}</p>
            <p><strong>Minggu Ke:</strong> Minggu ke-{{ $minggu }}</p>

            <form action="{{ route('guru.absensi.store') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                <input type="hidden" name="minggu_ke" value="{{ $minggu }}">

                <table class="w-full text-center border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Nama</th>
                            <th class="p-2">Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $s)
                            <tr class="border-t">
                                <td class="p-2">{{ $s->name }}</td>
                                <td class="p-2">
                                    <select name="kehadiran[{{ $s->id }}]" class="w-full border rounded">
                                        <option value="hadir">Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="sakit">Sakit</option>
                                        <option value="alpa">Alpa</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end space-x-2">
                    <a href="{{ url()->previous() }}"
                        class="bg-indigo-700 hover:bg-indigo-800 text-white px-6 py-2 rounded text-sm font-medium shadow-md transition duration-200">
                        Kembali
                    </a>
                    <button type="submit"
                        class="bg-indigo-700 hover:bg-indigo-800 text-white px-6 py-2 rounded text-sm font-medium shadow-md transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection