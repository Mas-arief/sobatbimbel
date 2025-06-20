@extends('layouts.app')

@section('title', 'Kursus')

@section('content')
<div x-data="{ tab: 'indo', materiOpen: null, tugasOpen: null, mingguAktif: 1 }" class="min-h-screen">
    <div class="mt-8 sm:mt-16 md:mt-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-left">KURSUS</h1>
    </div>

    <div class="mt-5 flex justify-center space-x-6">
        <button @click="tab = 'indo'"
            :class="{ 'bg-blue-900 text-white': tab === 'indo', 'bg-blue-700 text-white hover:bg-blue-800': tab !== 'indo' }"
            class="py-4 px-8 rounded-full font-semibold transition-colors duration-200">Bahasa Indonesia
        </button>
        <button @click="tab = 'inggris'"
            :class="{ 'bg-blue-900 text-white': tab === 'inggris', 'bg-blue-700 text-white hover:bg-blue-800': tab !== 'inggris' }"
            class="py-4 px-8 rounded-full font-semibold transition-colors duration-200">Bahasa Inggris
        </button>
        <button @click="tab = 'mtk'"
            :class="{ 'bg-blue-900 text-white': tab === 'mtk', 'bg-blue-700 text-white hover:bg-blue-800': tab !== 'mtk' }"
            class="py-4 px-8 rounded-full font-semibold transition-colors duration-200">Matematika
        </button>
    </div>

    <div class="space-y-6 mt-10 max-w-4xl mx-auto text-lg">
        <template x-for="i in 16" :key="i">
            <div x-data="{ open: null }">
                <div class="bg-blue-800 text-white rounded-lg mb-2 dark:bg-blue-700">
                    <div class="p-5 flex items-center justify-between cursor-pointer"
                        @click="open = (open === i ? null : i); mingguAktif = i;">
                        <div class="flex items-center space-x-2">
                            <svg :class="{ 'transform rotate-90': open === i }" class="w-4 h-4 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            <span x-text="'MINGGU ' + i"></span>
                        </div>
                    </div>
                    <div x-show="open === i" x-collapse class="px-4 pb-4 text-sm space-y-4">
                        <p class="text-gray-100 dark:text-gray-200">
                            Konten <span
                                x-text="tab === 'indo' ? 'Bahasa Indonesia' : tab === 'inggris' ? 'Bahasa Inggris' : 'Matematika'"></span>
                            Minggu <span x-text="i"></span> di sini...
                        </p>

                        <div class="space-y-2">
                            <h4 class="font-bold text-md text-gray-200 dark:text-gray-200">Materi:</h4>
                            <ul class="list-disc list-inside space-y-1">
                                <template x-if="tab === 'indo'">
                                    <div>
                                        <button data-modal-target="modal_Tambah_Materi"
                                            data-modal-toggle="modal_Tambah_Materi"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>Tambah Materi</span>
                                        </button>
                                        <p class="ml-6 text-gray-100">Materi Bahasa Indonesia</p>
                                        <hr class="my-2 border-gray-300 dark:border-gray-600">

                                        <button data-modal-target="modal_Tambah_Tugas"
                                            data-modal-toggle="modal_Tambah_Tugas"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-book"></i>
                                            <span>Buat Tugas</span>
                                        </button>
                                        <p class="ml-6 text-gray-100">Pengumpulan Tugas</p>

                                        <a href="{{ route('guru.pengumpulan') }}"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm ml-6">
                                            <i class="fas fa-paperclip"></i>
                                            <span>Pengumpulan</span>
                                        </a>

                                        <hr class="my-2 border-gray-300 dark:border-gray-600">

                                        @if(isset($mapel['indo']))
                                        <a x-bind:href="'{{ route('guru.absensi.show', $mapel['indo']->id) }}' + '?minggu=' + mingguAktif"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Absensi</span>
                                        </a>

                                        <a href="{{ route('penilaian.index', ['mapelId' => $mapel['indo']->id]) }}"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-clipboard-check"></i>
                                            <span>Penilaian</span>
                                        </a>
                                        @endif
                                    </div>
                                </template>

                                <template x-if="tab === 'inggris'">
                                    <div>
                                        <button data-modal-target="modal_Tambah_Materi"
                                            data-modal-toggle="modal_Tambah_Materi"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>Tambah Materi</span>
                                        </button>
                                        <p class="ml-6 text-gray-100">Materi Bahasa Inggris</p>
                                        <hr class="my-2 border-gray-300 dark:border-gray-600">

                                        <button data-modal-target="modal_Tambah_Tugas"
                                            data-modal-toggle="modal_Tambah_Tugas"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-book"></i>
                                            <span>Buat Tugas</span>
                                        </button>
                                        <p class="ml-6 text-gray-100">Pengumpulan Tugas</p>

                                        <a href="{{ route('guru.pengumpulan') }}"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm ml-6">
                                            <i class="fas fa-paperclip"></i>
                                            <span>Pengumpulan</span>
                                        </a>

                                        <hr class="my-2 border-gray-300 dark:border-gray-600">

                                        @if(isset($mapel['inggris']))
                                        <a x-bind:href="'{{ route('guru.absensi.show', $mapel['inggris']->id) }}' + '?minggu=' + mingguAktif"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Absensi</span>
                                        </a>

                                        <a href="{{ route('penilaian.index', ['mapelId' => $mapel['inggris']->id]) }}"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-clipboard-check"></i>
                                            <span>Penilaian</span>
                                        </a>
                                        @endif
                                    </div>
                                </template>

                                <template x-if="tab === 'mtk'">
                                    <div>
                                        <button data-modal-target="modal_Tambah_Materi"
                                            data-modal-toggle="modal_Tambah_Materi"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-file-pdf"></i>
                                            <span>Tambah Materi</span>
                                        </button>
                                        <p class="ml-6 text-gray-100">Materi Matematika</p>
                                        <hr class="my-2 border-gray-300 dark:border-gray-600">

                                        <button data-modal-target="modal_Tambah_Tugas"
                                            data-modal-toggle="modal_Tambah_Tugas"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-book"></i>
                                            <span>Buat Tugas</span>
                                        </button>
                                        <p class="ml-6 text-gray-100">Pengumpulan Tugas</p>

                                        <a href="{{ route('guru.pengumpulan') }}"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm ml-6">
                                            <i class="fas fa-paperclip"></i>
                                            <span>Pengumpulan</span>
                                        </a>

                                        <hr class="my-2 border-gray-300 dark:border-gray-600">

                                        @if(isset($mapel['mtk']))
                                        <a x-bind:href="'{{ route('guru.absensi.show', $mapel['mtk']->id) }}' + '?minggu=' + mingguAktif"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>Absensi</span>
                                        </a>

                                        <a href="{{ route('penilaian.index', ['mapelId' => $mapel['mtk']->id]) }}"
                                            class="flex items-center space-x-2 text-white hover:underline text-sm">
                                            <i class="fas fa-clipboard-check"></i>
                                            <span>Penilaian</span>
                                        </a>
                                        @endif
                                    </div>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

@include('guru.modal_tambah_tugas')
@include('guru.modal_tambah_materi')
@endsection