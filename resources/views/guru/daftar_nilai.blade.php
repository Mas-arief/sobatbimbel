@extends('layouts.app')

@section('title', 'Tabel Daftar Nilai')

@section('content')
<div class="mt-6 ml-2 px-6">
    <h1 class="text-2xl font-bold text-gray-800">DAFTAR NILAI</h1>
</div>

<div class="p-6">
    <div class="p-4 rounded-lg mt-6">
        <div class="overflow-x-auto rounded-md shadow-md">
            <table class="w-full text-sm text-center text-black border border-white">
                <thead class="bg-gray-300 text-black">
                    <tr>
                        <th rowspan="2" class="px-4 py-2 border border-white align-middle w-40">Mapel</th>
                        <th colspan="16" class="px-4 py-2 border border-white font-medium text-center">Pertemuan ke</th>
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
                        @foreach ([80, 85, 78, 90, '', 88, '', 92, '', 86, '', '', '', 84, '', 89] as $val)
                            <td class="px-2 py-1 border border-white">{{ $val }}</td>
                        @endforeach
                    </tr>
                    <!-- Bahasa Inggris -->
                    <tr>
                        <th class="px-4 py-2 border border-white text-center font-medium">Bahasa Inggris</th>
                        @foreach ([75, 80, '', '', 82, '', 79, '', '', '', '', '', '', '', '', ''] as $val)
                            <td class="px-2 py-1 border border-white">{{ $val }}</td>
                        @endforeach
                    </tr>
                    <!-- Matematika -->
                    <tr>
                        <th class="px-4 py-2 border border-white text-center font-medium">Matematika</th>
                        @foreach ([90, '', 85, 88, '', '', '', 91, '', '', '', 86, '', '', 89, ''] as $val)
                            <td class="px-2 py-1 border border-white">{{ $val }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
