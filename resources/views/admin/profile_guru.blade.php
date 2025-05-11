@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">Manajemen Profile Guru</h1>

    <!-- Tombol Kembali -->
    <div class="mb-4">
        <a href="{{ route('guru.index') }}">
            <button class="bg-blue-800 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>
        </a>
    </div>

    <!-- Tabel -->
    <div class="flex justify-center">
        <div class="w-full max-w-6xl overflow-x-auto rounded-md shadow-md">
            <table class="min-w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
                <thead class="bg-gray-300 text-center font-semibold">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Tempat Lahir</th>
                        <th class="px-4 py-2 border">Tanggal Lahir</th>
                        <th class="px-4 py-2 border">JK</th>
                        <th class="px-4 py-2 border">Guru Mapel</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border rounded-tr-md">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($dataGuru as $guru)
                        <tr class="border border-gray-300">
                            <td class="px-4 py-2 border">{{ $guru['id'] }}</td>
                            <td class="px-4 py-2 border font-semibold">{{ $guru['nama'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['tempat_lahir'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['tanggal_lahir'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['jk'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['mapel'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['email'] }}</td>
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
