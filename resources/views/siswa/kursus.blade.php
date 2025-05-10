@extends('layouts.app')

@section('title', 'Kursus')

@section('content')
<div x-data="{ tab: 'indo', materiOpen: null, tugasOpen: null }" class="bg-gray-100 dark:bg-gray-900 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-left text-gray-800 dark:text-gray-200 mb-6">KURSUS</h1>


        <div class="flex justify-center space-x-4 mb-10">
            <button @click="tab = 'indo'"
                :class="{'bg-blue-800 text-white dark:bg-blue-700 dark:text-white' : tab === 'indo', 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600' : tab !== 'indo'}"
                class="py-2 px-4 rounded-full font-semibold transition-colors duration-200">
                Bahasa Indonesia
            </button>
            <button @click="tab = 'inggris'"
                :class="{'bg-blue-800 text-white dark:bg-blue-700 dark:text-white' : tab === 'inggris', 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600' : tab !== 'inggris'}"
                class="py-2 px-4 rounded-full font-semibold transition-colors duration-200">
                Bahasa Inggris
            </button>
            <button @click="tab = 'mtk'"
                :class="{'bg-blue-800 text-white dark:bg-blue-700 dark:text-white' : tab === 'mtk', 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-400 dark:hover:bg-gray-600' : tab !== 'mtk'}"
                class="py-2 px-4 rounded-full font-semibold transition-colors duration-200">
                Matematika
            </button>
        </div>

        <div class="space-y-6 text-lg">
            <template x-for="i in 6" :key="i">
                <div x-data="{ open: null }">
                    <div class="bg-blue-800 text-white rounded-lg mb-2 dark:bg-blue-700">
                        <div class="p-4 flex items-center justify-between cursor-pointer" @click="open = (open === i ? null : i)">
                            <div class="flex items-center space-x-2">
                                <svg :class="{ 'transform rotate-90': open === i }"
                                    class="w-4 h-4 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
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

                            <!-- Materi -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-md text-gray-200 dark:text-gray-200">Materi:</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    <template x-if="tab === 'indo'">
                                        <li>
                                            <a href="#"
                                                class="text-blue-400 hover:underline dark:text-blue-300"
                                                @click.prevent="materiOpen = i">
                                                [PDF] Materi Bahasa Indonesia Minggu <span x-text="i"></span>
                                            </a>
                                            <div x-show="materiOpen === i" x-collapse class="mt-2 text-gray-300 dark:text-gray-400">
                                                <p>Ini adalah isi materi Bahasa Indonesia untuk minggu <span x-text="i"></span>.</p>
                                                <p>Tambahan: Contoh materi bisa berupa penjelasan tata bahasa, contoh kalimat, atau latihan soal.</p>
                                            </div>
                                        </li>
                                    </template>
                                    <template x-if="tab === 'inggris'">
                                        <li>
                                            <a href="#" class="text-blue-400 hover:underline dark:text-blue-300" @click.prevent="materiOpen = i">
                                                [PDF] Materi Bahasa Inggris Minggu <span x-text="i"></span>
                                            </a>
                                            <div x-show="materiOpen === i" x-collapse class="mt-2 text-gray-300 dark:text-gray-400">
                                                <p>Ini adalah isi materi Bahasa Inggris untuk minggu <span x-text="i"></span>.</p>
                                                <p>Tambahan: Materi mungkin mencakup vocabulary, grammar, atau contoh dialog.</p>
                                            </div>
                                        </li>
                                    </template>
                                    <template x-if="tab === 'mtk'">
                                        <li>
                                            <a href="#" class="text-blue-400 hover:underline dark:text-blue-300" @click.prevent="materiOpen = i">
                                                [PDF] Materi Matematika Minggu <span x-text="i"></span>
                                            </a>
                                            <div x-show="materiOpen === i" x-collapse class="mt-2 text-gray-300 dark:text-gray-400">
                                                <p>Ini adalah isi materi Matematika untuk minggu <span x-text="i"></span>.</p>
                                                <p>Tambahan: Materi bisa berisi rumus, contoh soal, dan pembahasan.</p>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                            <hr class="my-2 border-gray-200 dark:border-gray-700">

                            <!-- Tugas -->
                            <div class="space-y-2">
                                <h4 class="font-bold text-md text-gray-200 dark:text-gray-200">Tugas:</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    <template x-if="tab === 'indo'">
                                        <li>
                                            <a href="#" class="text-blue-400 hover:underline dark:text-blue-300" @click.prevent="tugasOpen = i">
                                                Tugas Bahasa Indonesia Minggu <span x-text="i"></span>
                                            </a>
                                            <div x-show="tugasOpen === i" x-collapse class="mt-2 text-gray-300 dark:text-gray-400">
                                                <p>Kerjakan soal berikut ini:</p>
                                                <ol class="list-decimal list-inside">
                                                    <li>Soal 1: Tuliskan contoh kalimat...</li>
                                                    <li>Soal 2: Jelaskan perbedaan antara...</li>
                                                </ol>
                                            </div>
                                        </li>
                                    </template>
                                    <template x-if="tab === 'inggris'">
                                        <li>
                                            <a href="#" class="text-blue-400 hover:underline dark:text-blue-300" @click.prevent="tugasOpen = i">
                                                Tugas Bahasa Inggris Minggu <span x-text="i"></span>
                                            </a>
                                            <div x-show="tugasOpen === i" x-collapse class="mt-2 text-gray-300 dark:text-gray-400">
                                                <p>Complete the following exercises:</p>
                                                <ol class="list-decimal list-inside">
                                                    <li>Exercise 1: Translate the following...</li>
                                                    <li>Exercise 2: Write a short paragraph...</li>
                                                </ol>
                                            </div>
                                        </li>
                                    </template>
                                    <template x-if="tab === 'mtk'">
                                        <li>
                                            <a href="#" class="text-blue-400 hover:underline dark:text-blue-300" @click.prevent="tugasOpen = i">
                                                Tugas Matematika Minggu <span x-text="i"></span>
                                            </a>
                                            <div x-show="tugasOpen === i" x-collapse class="mt-2 text-gray-300 dark:text-gray-400">
                                                <p>Kerjakan soal berikut ini:</p>
                                                <ol class="list-decimal list-inside">
                                                    <li>Soal 1: Hitunglah...</li>
                                                    <li>Soal 2: Tentukan nilai x dari persamaan...</li>
                                                </ol>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
@endsection