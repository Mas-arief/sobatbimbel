@extends('layouts.app')

@section('title', 'Tabel Daftar Hadir')

@section('content')
<div class="mt-6 ml-2 px-6">
    <h1 class="text-2xl font-bold text-gray-800">DAFTAR HADIR</h1>
</div>

<div class="p-6">
    <div class="p-4 rounded-lg mt-6">
        <div class="overflow-x-auto rounded-md shadow-md">
            <table class="w-full text-sm text-center text-black border border-white">
                <thead class="bg-gray-300 text-black">
                    <tr>
                        <th rowspan="2" class="px-4 py-2 border border-white align-middle w-40">
                            Mapel
                        </th>
                        <th colspan="16" class="px-4 py-2 border border-white font-medium text-center">
                            Minggu ke
                        </th>
                    </tr>
                    <tr>
                        @for ($i = 1; $i <= 16; $i++)
                            <th class="px-2 py-1 border border-white">{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody class="bg-gray-300">
                    <!-- Bahasa Indonesia -->
                    <tr>
                        <th class="px-4 py-2 border border-white text-center font-medium">Bahasa Indonesia</th>
                        @foreach (['sakit', '', '', '', '', 'hadir', '', '', '', 'izin', '', '', '', '', '', ''] as $val)
                            <td class="px-2 py-1 border border-white">{{ $val }}</td>
                        @endforeach
                    </tr>
                    <!-- Bahasa Inggris -->
                    <tr>
                        <th class="px-4 py-2 border border-white text-center font-medium">Bahasa Inggris</th>
                        @for ($i = 0; $i < 16; $i++)
                            <td class="px-2 py-1 border border-white"></td>
                        @endfor
                    </tr>
                    <!-- Matematika -->
                    <tr>
                        <th class="px-4 py-2 border border-white text-center font-medium">Matematika</th>
                        @for ($i = 0; $i < 16; $i++)
                            <td class="px-2 py-1 border border-white"></td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
