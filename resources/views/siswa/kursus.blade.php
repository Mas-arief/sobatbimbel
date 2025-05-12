@extends('layouts.app')

@section('title', 'Kursus')

@section('content')
<div x-data="{ tab: 'indo', materiOpen: null, tugasOpen: null }" class="min-h-screen">
    <div class="mt-8 sm:mt-16 md:mt-3 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-left">KURSUS</h1>
    </div>

    <div class="mt-5 flex justify-center space-x-6">
        <button @click="tab = 'indo'"
            :class="{
                'bg-blue-900 text-white': tab === 'indo',
                'bg-blue-700 text-white hover:bg-blue-800': tab !== 'indo'
            }"
            class="py-4 px-8 rounded-full font-semibold transition-colors duration-200">
            Bahasa Indonesia
        </button>
        <button @click="tab = 'inggris'"
            :class="{
                'bg-blue-900 text-white': tab === 'inggris',
                'bg-blue-700 text-white hover:bg-blue-800': tab !== 'inggris'
            }"
            class="py-4 px-8 rounded-full font-semibold transition-colors duration-200">
            Bahasa Inggris
        </button>
        <button @click="tab = 'mtk'"
            :class="{
                'bg-blue-900 text-white': tab === 'mtk',
                'bg-blue-700 text-white hover:bg-blue-800': tab !== 'mtk'
            }"
            class="py-4 px-8 rounded-full font-semibold transition-colors duration-200">
            Matematika
        </button>
    </div>

    <div class="space-y-6 mt-10 max-w-4xl mx-auto text-lg">
        @for ($i = 1; $i <= 16; $i++)
            <div x-data="{ open: null }">
                <div class="bg-blue-800 text-white rounded-lg mb-2 dark:bg-blue-700">
                    <div class="p-5 flex items-center justify-between cursor-pointer"
                        @click="open = (open === {{ $i }} ? null : {{ $i }})">
                        <div class="flex items-center space-x-2">
                            <svg :class="{ 'transform rotate-90': open === {{ $i }} }"
                                class="w-4 h-4 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>MINGGU {{ $i }}</span>
                        </div>
                    </div>

                    <div x-show="open === {{ $i }}" x-collapse class="px-4 pb-4 text-sm space-y-4">
                        <p class="text-gray-100 dark:text-gray-200">
                            Konten <span
                                x-text="tab === 'indo' ? 'Bahasa Indonesia' : tab === 'inggris' ? 'Bahasa Inggris' : 'Matematika'">
                            </span> Minggu {{ $i }} di sini...
                        </p>

                        <div class="space-y-2">
                            <h4 class="font-bold text-md text-gray-200 dark:text-gray-200">Materi:</h4>
                            <ul class="list-disc list-inside space-y-1">
                                <template x-if="tab === 'indo' && dataKursus.indo[{{ $i }}]">
                                    <li>
                                        <a :href="dataKursus.indo[{{ $i }}].materi_link" class="text-blue-400 hover:underline dark:text-blue-300">
                                            <span x-text="dataKursus.indo[{{ $i }}].materi"></span>
                                        </a>
                                        <div x-show="materiOpen === {{ $i }}" x-collapse
                                            class="mt-2 text-gray-300 dark:text-gray-400">
                                            <p>Isi materi Bahasa Indonesia minggu {{ $i }}.</p>
                                            <p>Contoh: tata bahasa, kalimat, latihan soal.</p>
                                        </div>
                                    </li>
                                </template>
                                <template x-if="tab === 'inggris' && dataKursus.inggris[{{ $i }}]">
                                    <li>
                                        <a :href="dataKursus.inggris[{{ $i }}].materi_link" class="text-blue-400 hover:underline dark:text-blue-300">
                                            <span x-text="dataKursus.inggris[{{ $i }}].materi"></span>
                                        </a>
                                        <div x-show="materiOpen === {{ $i }}" x-collapse
                                            class="mt-2 text-gray-300 dark:text-gray-400">
                                            <p>Materi Bahasa Inggris minggu {{ $i }}.</p>
                                            <p>Contoh: vocabulary, grammar, dialog.</p>
                                        </div>
                                    </li>
                                </template>
                                <template x-if="tab === 'mtk' && dataKursus.mtk[{{ $i }}]">
                                    <li>
                                        <a :href="dataKursus.mtk[{{ $i }}].materi_link" class="text-blue-400 hover:underline dark:text-blue-300">
                                            <span x-text="dataKursus.mtk[{{ $i }}].materi"></span>
                                        </a>
                                        <div x-show="materiOpen === {{ $i }}" x-collapse
                                            class="mt-2 text-gray-300 dark:text-gray-400">
                                            <p>Materi Matematika minggu {{ $i }}.</p>
                                            <p>Contoh: rumus, soal, pembahasan.</p>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <hr class="my-2 border-gray-200 dark:border-gray-700">

                        <div class="space-y-2">
                            <h4 class="font-bold text-md text-gray-200 dark:text-gray-200">Tugas:</h4>
                            <ul class="list-disc list-inside space-y-1">
                                <template x-if="tab === 'indo' && dataKursus.indo[{{ $i }}]">
                                    <li>
                                        <a href="#" class="text-blue-400 hover:underline dark:text-blue-300"
                                            @click.prevent="tugasOpen = {{ $i }}">
                                            <span x-text="dataKursus.indo[{{ $i }}].tugas"></span>
                                        </a>
                                        <div x-show="tugasOpen === {{ $i }}" x-collapse
                                            class="mt-2 text-gray-300 dark:text-gray-400">
                                            <p>Kerjakan soal berikut:</p>
                                            <ol class="list-decimal list-inside">
                                                <template x-for="item in dataKursus.indo[{{ $i }}].tugas_deskripsi" :key="item">
                                                    <li x-text="item"></li>
                                                </template>
                                            </ol>
                                        </div>
                                    </li>
                                </template>
                                <template x-if="tab === 'inggris' && dataKursus.inggris[{{ $i }}]">
                                    <li>
                                        <a href="#" class="text-blue-400 hover:underline dark:text-blue-300"
                                            @click.prevent="tugasOpen = {{ $i }}">
                                            <span x-text="dataKursus.inggris[{{ $i }}].tugas"></span>
                                        </a>
                                        <div x-show="tugasOpen === {{ $i }}" x-collapse
                                            class="mt-2 text-gray-300 dark:text-gray-400">
                                            <p>Exercises:</p>
                                            <ol class="list-decimal list-inside">
                                                <template x-for="item in dataKursus.inggris[{{ $i }}].tugas_deskripsi" :key="item">
                                                    <li x-text="item"></li>
                                                </template>
                                            </ol>
                                        </div>
                                    </li>
                                </template>
                                <template x-if="tab === 'mtk' && dataKursus.mtk[{{ $i }}]">
                                    <li>
                                        <a href="#" class="text-blue-400 hover:underline dark:text-blue-300"
                                            @click.prevent="tugasOpen = {{ $i }}">
                                            <span x-text="dataKursus.mtk[{{ $i }}].tugas"></span>
                                        </a>
                                        <div x-show="tugasOpen === {{ $i }}" x-collapse
                                            class="mt-2 text-gray-300 dark:text-gray-400">
                                            <p>Kerjakan soal berikut:</p>
                                            <ol class="list-decimal list-inside">
                                                <template x-for="item in dataKursus.mtk[{{ $i }}].tugas_deskripsi" :key="item">
                                                    <li x-text="item"></li>
                                                </template>
                                            </ol>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <div class="mt-4">
                            <a :href="'{{ url('admin/modal_pengumpulan_tugas') }}?minggu=' + {{ $i }} + '&mapel=' + tab"
                               class="inline-block px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded shadow text-sm font-semibold transition">
                                <i class="fas fa-upload mr-2"></i> Kumpulkan Tugas Minggu {{ $i }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('kursusData', () => ({
            dataKursus: @json($dataKursus)
        }))
    })
</script>
@endsection
