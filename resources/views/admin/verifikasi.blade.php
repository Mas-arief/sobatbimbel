@extends('layouts.app')
@section('content')
<div class="px-4 sm:ml-64">
  <h1 class="text-2xl font-bold text-gray-800 text-center sm:text-left">VERIFIKASI</h1>
</div>

<div class="p-4 sm:ml-64 mt-5">
  <div class="overflow-x-auto shadow-md sm:rounded-lg">
    <table class="min-w-full text-sm text-gray-800 border border-gray-400 bg-gray-100">
      <thead class="text-xs text-gray-800 uppercase bg-gray-300 text-center">
        <tr>
          <th class="px-4 py-3 border border-gray-400 min-w-[100px]">ID</th>
          <th class="px-4 py-3 border border-gray-400 min-w-[150px]">NAMA</th>
          <th class="px-4 py-3 border border-gray-400 min-w-[200px]">EMAIL</th>
          <th class="px-4 py-3 border border-gray-400 min-w-[140px]">AKSI</th>
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
        <tr class="{{ $index % 2 == 0 ? 'bg-gray-200' : 'bg-gray-100' }} text-center">
          <td class="px-4 py-4 border border-gray-400">{{ $user['id'] }}</td>
          <td class="px-4 py-4 border border-gray-400">{{ $user['nama'] }}</td>
          <td class="px-4 py-4 border border-gray-400">{{ $user['email'] }}</td>
          <td class="px-4 py-4 border border-gray-400">
            <div class="flex flex-wrap justify-center gap-2">
              <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Terima</button>
              <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Tolak</button>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
