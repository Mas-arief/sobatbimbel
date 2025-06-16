@extends('layouts.navbar')

@section('title', 'Input Nilai')

@section('content')
<div class="px-4 py-4">
    <div class="sticky top-0 z-10 dark:bg-gray-900 pb-3">
        <h1 class="text-center text-lg font-semibold mb-1">INPUT NILAI</h1>
        <p class="text-sm text-gray-700 dark:text-gray-300 text-center">
            <strong>Mapel:</strong> {{ $mapel->nama }}
        </p>
    </div>

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf
        <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">

        {{-- Input untuk memilih Minggu --}}
        <div class="mb-4 w-full max-w-3xl mx-auto">
            <label for="minggu" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minggu Ke-</label>
            {{-- Menggunakan onchange untuk submit form saat minggu diubah --}}
            <select name="minggu" id="minggu" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600" onchange="this.form.submit()">
                @for ($i = 1; $i <= 16; $i++)
                    <option value="{{ $i }}" {{ $selectedMinggu == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
            </select>
        </div>

        <div class="overflow-y-auto max-h-[400px] border rounded-md w-full max-w-3xl mx-auto mt-4">
            <table class="table-auto w-full border-collapse">
                <thead class="bg-gray-200 sticky top-0 z-10 text-sm">
                    <tr>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border text-center">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $s)
                    <tr class="even:bg-gray-100 text-sm">
                        <td class="p-2 border">{{ $s->name }}</td>
                        <td class="p-2 border text-center">
                            <input type="number"
                                name="nilai[{{ $s->id }}]"
                                placeholder="Angka"
                                min="0" max="100"
                                {{-- PERBAIKAN: Ambil nilai dari koleksi $penilaian yang sudah difilter --}}
                                value="{{ $penilaian->get($s->id)?->nilai }}"
                                class="w-20 border rounded px-2 py-1 text-center text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end space-x-2 mt-4 max-w-3xl mx-auto">
            <a href="{{ url()->previous() }}" class="bg-indigo-700 hover:bg-indigo-800 text-white px-3 py-1.5 rounded text-sm">
                Kembali
            </a>
            <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 text-white px-3 py-1.5 rounded text-sm">
                SIMPAN
            </button>
        </div>
    </form>
</div>
@endsection