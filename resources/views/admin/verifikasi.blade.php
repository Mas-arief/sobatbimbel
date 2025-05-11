@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">VERIFIKASI</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-4xl overflow-x-auto shadow-md rounded-md">
            <table class="min-w-full text-sm text-gray-800 border border-gray-300 bg-gray-200">
                <thead class="text-xs uppercase bg-gray-300 text-center font-semibold">
                    <tr>
                        <th class="px-4 py-3 border">ID</th>
                        <th class="px-4 py-3 border">NAMA</th>
                        <th class="px-4 py-3 border">EMAIL</th>
                        <th class="px-4 py-3 border">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $users = [
                            ['id' => '123104', 'nama' => 'BUDI', 'email' => 'budi@gmail.com'],
                            ['id' => '214908', 'nama' => 'PUTRI', 'email' => 'putri@gmail.com'],
                            ['id' => '214564', 'nama' => 'BENI', 'email' => 'beni@gmail.com'],
                        ];
                    @endphp

                    @foreach ($users as $index => $user)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-gray-200' }} text-center">
                            <td class="px-4 py-3 border">{{ $user['id'] }}</td>
                            <td class="px-9 py-3 border font-semibold">{{ $user['nama'] }}</td>
                            <td class="px-8 py-3 border">{{ $user['email'] }}</td>
                            <td class="px-1 py-3 border text-center whitespace-nowrap">
                                <button class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100 inline-block">
                                  <i class="fas fa-check text-green-600 mr-1"></i> Terima
                                </button>
                                <button class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100 inline-block ml-4">
                                  <i class="fas fa-times text-red-600 mr-1"></i> Tolak
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
