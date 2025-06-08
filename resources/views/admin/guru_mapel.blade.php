@extends('layouts.app')
@include('admin.modal_guru_mapel')

@section('content')
    <div class="pl-64 pr-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">MANAJEMEN GURU & MAPEL</h1>

    <div class="mb-4">
        <a href="{{ route('dashboard') }}">
            <button class="bg-blue-800 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>
        </a>
    </div>

    <div class="flex justify-center">
    <div class="w-full max-w-6xl overflow-x-auto rounded-md shadow-md">
        <table class="min-w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
            <thead class="bg-gray-300 text-center font-semibold">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Guru Mapel</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr class="border border-gray-300">
                    <td class="px-4 py-2 border">001</td>
                    <td class="px-4 py-2 border font-semibold">Nama Guru 1</td>
                    <td class="px-4 py-2 border">guru1@example.com</td>
                    <td class="px-4 py-2 border">Matematika</td>
                    <td class="px-4 py-2 border">
                        <button data-modal-target="modalEditGuru" data-modal-toggle="modalEditGuru"
                            class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100">
                            Pilih Mapel
                        </button>
                    </td>
                </tr>
                <tr class="border border-gray-300">
                    <td class="px-4 py-2 border">002</td>
                    <td class="px-4 py-2 border font-semibold">Nama Guru 2</td>
                    <td class="px-4 py-2 border">guru2@example.com</td>
                    <td class="px-4 py-2 border">Bahasa Inggris</td>
                    <td class="px-4 py-2 border">
                        <button data-modal-target="modalEditGuru" data-modal-toggle="modalEditGuru"
                            class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100">
                            Pilih Mapel
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

@endsection