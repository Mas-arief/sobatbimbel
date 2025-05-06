@extends('layouts.app')

@section('content')
    @include('components.navbar')

    <div class="text-white p-2 mt-20">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('guru.index') }}">
                <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow-md">
                    Kembali
                </button>
            </a>
        </div>
    </div>

    <div class=" px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 text-center my-6">MANAJEMEN PROFILE GURU</h1>
        </div>
    </div>

    <div class="overflow-x-auto rounded-md shadow-md max-w-7xl mx-auto mt-4">
        <table class="w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
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
                        <td class="px-4 py-2 border flex justify-center items-center gap-2">
                            <button class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">Edit</button>
                            <button class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
