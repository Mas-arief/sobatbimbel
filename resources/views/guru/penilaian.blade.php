@extends('layouts.navbar')

@section('title', 'Input Nilai')

@section('content')
<div class="px-4 py-4">
    <!-- Judul & Mapel (Sticky) -->
    <div class="sticky top-0 z-10 dark:bg-gray-900 pb-3">
        <h1 class="text-center text-lg font-semibold mb-1">INPUT NILAI</h1>
        <p class="text-sm text-gray-700 dark:text-gray-300 text-center">
            <strong>Mapel:</strong> {{ $mapel }}
        </p>

    </div>

    <form action="{{ route('penilaian.store') }}" method="POST">
        @csrf

        <!-- Scrollable Table -->
        <div class="overflow-y-auto max-h-[400px] border rounded-md w-full max-w-3xl mx-auto mt-4">
            <table class="table-auto w-full border-collapse">
                <thead class="bg-gray-200 sticky top-0 z-10 text-sm">
                    <tr>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border text-center">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 30; $i++)
                        <tr class="even:bg-gray-100 text-sm">
                            <td class="p-2 border">Nama Siswa/i</td>
                            <td class="p-2 border text-center">
                                <input type="number" name="nilai[{{ $i }}]" placeholder="Angka"
                                    class="w-20 border rounded px-2 py-1 text-center text-sm">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Tombol Aksi -->
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
