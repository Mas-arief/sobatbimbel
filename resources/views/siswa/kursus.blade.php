@extends('layouts.app') {{-- Pastikan ini adalah layout yang benar --}}

@section('title', 'Kursus')

@section('content')

    <style>
        @keyframes floatingFade {
            0% {
                transform: translateY(0px);
                opacity: 0.2;
            }

            25% {
                opacity: 0.8;
            }

            50% {
                transform: translateY(0px);
                opacity: 1.5;
            }

            75% {
                opacity: 0.8;
            }

            100% {
                transform: translateY(0px);
                opacity: 0.2;
            }
        }

        .animate-floating-fade {
            animation: floatingFade 15s ease-in-out infinite;
        }
    </style>

    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/9.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    {{-- PERBAIKAN: Inisialisasi tab dari PHP jika ada --}}
    <div x-data="{ tab: '{{ $initialTab ?? 'indo' }}', materiOpen: null, tugasOpen: null, open: null }" class="min-h-screen relative z-10">
        <div class="mt-8 sm:mt-16 md:mt-3 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-left">KURSUS</h1>
        </div>

        <div class="mt-5 flex justify-center space-x-6">
            <button @click="tab = 'indo'" :class="tab === 'indo'
                ? 'bg-white text-[#1F1AA1] shadow-[0_4px_12px_rgba(0,0,0,0.3)]'
                : 'bg-blue-700 text-white hover:bg-blue-800 shadow-[0_4px_12px_rgba(0,0,0,0.3)]'"
                class="py-4 px-8 rounded-full font-semibold font-poppins transition duration-500 ease-in-out transform hover:scale-105">
                Bahasa Indonesia
            </button>

            <button @click="tab = 'inggris'" :class="tab === 'inggris'
                ? 'bg-white text-[#1F1AA1] shadow-[0_4px_12px_rgba(0,0,0,0.3)]'
                : 'bg-blue-700 text-white hover:bg-blue-800 shadow-[0_4px_12px_rgba(0,0,0,0.3)]'"
                class="py-4 px-8 rounded-full font-semibold font-nunito transition duration-500 ease-in-out transform hover:scale-105">
                Bahasa Inggris
            </button>

            <button @click="tab = 'mtk'" :class="tab === 'mtk'
                ? 'bg-white text-[#1F1AA1] shadow-[0_4px_12px_rgba(0,0,0,0.3)]'
                : 'bg-blue-700 text-white hover:bg-blue-800 shadow-[0_4px_12px_rgba(0,0,0,0.3)]'"
                class="py-4 px-8 rounded-full font-semibold font-inter transition duration-500 ease-in-out transform hover:scale-105">
                Matematika
            </button>
        </div>


        {{-- Alpine.js data initialization from PHP --}}
        <div class="space-y-6 mt-10 max-w-4xl mx-auto text-lg " x-data="kursusData({{ $jsonDataKursus }})">
            @for ($i = 1; $i <= 16; $i++)
                <div x-data="{ open: null }">
                    <div class="bg-blue-800 text-white rounded-lg mb-2 dark:bg-blue-700 shadow-[0_4px_12px_rgba(0,0,0,0.3)]">
                        <div class="p-5 flex items-center justify-between cursor-pointer"
                            @click="open = (open === {{ $i }} ? null : {{ $i }})">
                            <div class="flex items-center space-x-2">
                                <svg :class="{ 'transform rotate-90': open === {{ $i }} }" class="w-4 h-4 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span>MINGGU {{ $i }}</span>
                            </div>
                        </div>

                        <div x-show="open === {{ $i }}" x-collapse class="px-4 pb-4 text-sm space-y-4">
                            <p class="text-gray-100 dark:text-gray-200">
                                Konten <span
                                    x-text="tab === 'indo' ? 'Bahasa Indonesia' : tab === 'inggris' ? 'Bahasa Inggris' : 'Matematika'"></span>
                                Minggu {{ $i }} di sini...
                            </p>

                            <div class="space-y-4">
                                <h4 class="font-bold text-md text-gray-200 dark:text-gray-200">Materi:</h4>
                                <template
                                    x-if="dataKursus[tab] && dataKursus[tab][{{ $i }}] && dataKursus[tab][{{ $i }}].materi.length > 0">
                                    <div>
                                        <template x-for="materiItem in dataKursus[tab][{{ $i }}].materi" :key="materiItem.id">
                                            {{-- Memastikan URL download materi benar --}}
                                            <a :href="materiItem.file_url" target="_blank"
                                                class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                <i class="fas fa-file-pdf"></i> {{-- Membutuhkan Font Awesome --}}
                                                <span x-text="materiItem.judul"></span>
                                            </a>
                                        </template>
                                    </div>
                                </template>
                                <template
                                    x-if="!dataKursus[tab] || !dataKursus[tab][{{ $i }}] || dataKursus[tab][{{ $i }}].materi.length === 0">
                                    <p class="text-gray-300">Belum ada materi untuk minggu ini.</p>
                                </template>
                            </div>

                            <hr class="my-4 border-gray-200 dark:border-gray-700">

                            <div class="space-y-2">
                                <h4 class="font-bold text-md text-gray-200 dark:text-gray-200">Tugas:</h4>
                                <ul class="list-none space-y-1">
                                    <template
                                        x-if="dataKursus[tab] && dataKursus[tab][{{ $i }}] && dataKursus[tab][{{ $i }}].tugas.length > 0">
                                        <template x-for="tugasItem in dataKursus[tab][{{ $i }}].tugas" :key="tugasItem.id">
                                            <li>
                                                {{-- Memastikan URL download tugas benar --}}
                                                <a :href="tugasItem.file_url" target="_blank"
                                                    class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                    <span x-text="tugasItem.judul"></span> (Deadline: <span
                                                        x-text="new Date(tugasItem.deadline).toLocaleDateString('id-ID')"></span>)
                                                </a>
                                            </li>
                                        </template>
                                    </template>
                                    <template
                                        x-if="!dataKursus[tab] || !dataKursus[tab][{{ $i }}] || dataKursus[tab][{{ $i }}].tugas.length === 0">
                                        <p class="text-gray-300">Belum ada tugas untuk minggu ini.</p>
                                    </template>
                                </ul>
                            </div>

                            <div class="mt-4">
                                {{-- PERBAIKAN: Menggunakan helper route() dengan parameter yang dinamis --}}
                                <a :href="`{{ route('pengumpulan_tugas') }}?mapel_slug=${tab}&minggu_ke={{ $i }}`"
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
            Alpine.data('kursusData', (initialData) => ({
                dataKursus: initialData,
                init() {
                    console.log('Data Kursus:', this.dataKursus); // Debugging
                    // Inisialisasi tab dari URL jika ada
                    const urlParams = new URLSearchParams(window.location.search);
                    const tabParam = urlParams.get('tab');
                    if (tabParam) {
                        this.tab = tabParam;
                    }
                }
            }));
        });
    </script>
@endsection
