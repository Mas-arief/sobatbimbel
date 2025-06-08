@extends('layouts.app')

@section('title', 'Pengumpulan Tugas')

@section('content')
<?php include base_path('resources/views/modal/modal_kumpul_tugas.php'); ?>

<div class="text-white p-2 bg-blue-800">
    <div class="container mx-auto flex justify-start items-center">
        <a href="{{ route('kursus.index') }}">
            <button class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-1 px-4 rounded shadow-md">
                Kembali
            </button>
        </a>
    </div>
</div>

<h1 class="text-2xl font-bold text-center mt-6 mb-6">Pengumpulan Tugas</h1>

<div class="max-w-xl mx-auto shadow-md border border-gray-200 rounded">
    <table class="w-full text-left table-auto border-collapse">
        <tbody>
            <tr class="border-b border-gray-200">
                <td class="p-4 font-medium text-gray-700">Status Tugas</td>
                <td class="p-4">-</td>
            </tr>
            <tr>
                <td class="p-4 font-medium text-gray-700">Nilai</td>
                <td class="p-4">-</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-6">
    <button data-modal-target="unggahModal" data-modal-toggle="unggahModal"
        class="bg-blue-900 hover:bg-blue-800 text-white text-sm font-bold py-2 px-6 rounded shadow-md">
        UNGGAH TUGAS
    </button>
</div>
@endsection
