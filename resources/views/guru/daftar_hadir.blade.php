@extends('layouts.app')

@section('title', 'Tabel Daftar Hadir')

@section('content')
<div class="mt-6 text-center">
    <h1 class="text-2xl font-bold text-gray-800">DAFTAR HADIR</h1>
</div>

<div class="p-6">
    <div class="text-left mb-4 ml-4">
        <p class="text-base text-black font-medium">Mapel: Bahasa Indonesia</p>
        <p class="text-base text-black font-medium">Minggu Ke: 4</p>
    </div>

    <div class="overflow-x-auto rounded-md shadow-md mx-4">
        <table class="w-full text-sm text-center text-black border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border border-gray-300">Nama</th>
                    <th class="px-4 py-2 border border-gray-300">Kehadiran</th>
                    <th class="px-4 py-2 border border-gray-300">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @for ($i = 0; $i < 7; $i++)
                    <tr>
                        <td class="px-4 py-2 border border-gray-300">Nama Siswa/i</td>
                        <td class="px-4 py-2 border border-gray-300">
                            @if ($i === 4)
                                <input type="checkbox" disabled>
                            @else
                                <input type="checkbox" checked disabled>
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            @if ($i === 4)
                                Sakit
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <div class="flex justify-end gap-4 mt-4 mr-6">
        <button class="bg-blue-800 text-white px-4 py-2 rounded-md hover:bg-blue-900">Edit</button>
        <button class="bg-blue-800 text-white px-4 py-2 rounded-md hover:bg-blue-900">Kembali</button>
    </div>
</div>
@endsection
