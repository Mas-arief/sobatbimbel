@extends('layouts.app')

@section('title', 'Kursus')

@section('content')
    {{-- Custom Styles for Background Animation --}}
    <style>
        @keyframes floatingFade {
            0% { transform: translateY(0px); opacity: 0.5; }
            25% { opacity: 0.7; }
            50% { transform: translateY(5px); opacity: 0.9; } /* Slight vertical movement */
            75% { opacity: 0.7; }
            100% { transform: translateY(0px); opacity: 0.5; }
        }
        .animate-floating-fade {
            animation: floatingFade 15s ease-in-out infinite;
        }
    </style>

    {{-- Background animasi --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        {{-- Ensure the image path is correct in your Laravel setup --}}
        <img src="{{ asset('images/10.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div x-data="{
        tab: '{{ $defaultTab ?? 'indo' }}',
        mingguAktif: 1,

        setTugasModalValues: function(mapelId, minggu) {
            this.mingguAktif = minggu;
            setTimeout(() => {
                const mapelInput = document.getElementById('mapel_id_tugas');
                const mingguHiddenInput = document.getElementById('minggu_ke_tugas_hidden');
                const mingguSelect = document.getElementById('minggu_ke_select');

                if (mapelInput) {
                    mapelInput.value = mapelId;
                    console.log('Tugas: mapel_id_tugas set to:', mapelId);
                } else {
                    console.error('Tugas: Element with ID mapel_id_tugas not found.');
                }

                if (mingguHiddenInput) {
                    mingguHiddenInput.value = minggu;
                    console.log('Tugas: minggu_ke_tugas_hidden set to:', minggu);
                } else {
                    console.error('Tugas: Element with ID minggu_ke_tugas_hidden not found.');
                }

                if (mingguSelect) {
                    mingguSelect.value = minggu;
                    console.log('Tugas: minggu_ke_select (display) set to:', minggu);
                } else {
                    console.error('Tugas: Element with ID minggu_ke_select not found.');
                }
            }, 0);
        },

        setMateriModalValues: function(mapelId, minggu) {
            this.mingguAktif = minggu;
            setTimeout(() => {
                const mapelInput = document.getElementById('mapel_id_materi');
                const mingguHiddenInput = document.getElementById('minggu_ke_materi_hidden');
                const mingguSelect = document.getElementById('minggu_ke_materi_select');

                if (mapelInput) {
                    mapelInput.value = mapelId;
                    console.log('Materi: mapel_id_materi set to:', mapelId);
                } else {
                    console.error('Materi: Element with ID mapel_id_materi not found.');
                }

                if (mingguHiddenInput) {
                    mingguHiddenInput.value = minggu;
                    console.log('Materi: minggu_ke_materi_hidden set to:', minggu);
                } else {
                    console.error('Materi: Element with ID minggu_ke_materi_hidden not found.');
                }

                if (mingguSelect) {
                    mingguSelect.value = minggu;
                    console.log('Materi: minggu_ke_materi_select (display) set to:', minggu);
                } else {
                    console.error('Materi: Element with ID minggu_ke_materi_select not found.');
                }
            }, 0);
        }
    }" class="min-h-screen relative z-10">
        <div class="mt-8 sm:mt-16 md:mt-3 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-left">KURSUS</h1>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
                x-init="setTimeout(() => show = false, 3000)"
                class="mt-4 px-4 py-3 rounded-md bg-green-500 text-white text-center max-w-4xl mx-auto shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
                x-init="setTimeout(() => show = false, 3000)"
                class="mt-4 px-4 py-3 rounded-md bg-red-500 text-white text-center max-w-4xl mx-auto shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms
                x-init="setTimeout(() => show = false, 5000)"
                class="mt-4 px-4 py-3 rounded-md bg-red-500 text-white max-w-4xl mx-auto shadow-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- End Flash Messages --}}

        <div class="mt-5 flex justify-center space-x-6">
            @if(isset($mapel['indo']))
            <button @click="tab = 'indo'"
                :class="{ 'bg-blue-900 text-white': tab === 'indo', 'bg-blue-700 text-white hover:bg-blue-800': tab !== 'indo' }"
                class="py-4 px-8 rounded-full font-semibold transition-colors duration-200 shadow-[0_4px_12px_rgba(0,0,0,0.3)]">Bahasa Indonesia
            </button>
            @endif

            @if(isset($mapel['inggris']))
            <button @click="tab = 'inggris'"
                :class="{ 'bg-blue-900 text-white': tab === 'inggris', 'bg-blue-700 text-white hover:bg-blue-800': tab !== 'inggris' }"
                class="py-4 px-8 rounded-full font-semibold transition-colors duration-200 shadow-[0_4px_12px_rgba(0,0,0,0.3)]">Bahasa Inggris
            </button>
            @endif

            @if(isset($mapel['mtk']))
            <button @click="tab = 'mtk'"
                :class="{ 'bg-blue-900 text-white': tab === 'mtk', 'bg-blue-700 text-white hover:bg-blue-800': tab !== 'mtk' }"
                class="py-4 px-8 rounded-full font-semibold transition-colors duration-200 shadow-[0_4px_12px_rgba(0,0,0,0.3)]">Matematika
            </button>
            @endif
        </div>

        <div class="space-y-6 mt-10 max-w-4xl mx-auto text-lg">
            <template x-for="i in 16" :key="i">
                <div x-data="{ open: null }">
                    <div class="bg-blue-800 text-white rounded-lg mb-2 dark:bg-blue-700 shadow-[0_4px_12px_rgba(0,0,0,0.3)]">
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
                                <ul class="list-none space-y-1">
                                    {{-- KONDISI UNTUK TAB BAHASA INDONESIA --}}
                                    <template x-if="tab === 'indo'">
                                        @if(isset($mapel['indo']))
                                            <div>
                                                <button data-modal-target="modalTambahMateri"
                                                    data-modal-toggle="modalTambahMateri"
                                                    @click="setMateriModalValues({{ $mapel['indo']->id }}, i);"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span>Tambah Materi</span>
                                                </button>
                                                {{-- Display materials for Bahasa Indonesia --}}
                                                @php
                                                    $indoMaterials = $materials['Bahasa Indonesia'][request('minggu') ?? 1] ?? collect();
                                                @endphp
                                                <template x-for="material in {{ json_encode($materials['Bahasa Indonesia'] ?? []) }}[i] || []" :key="material.id">
                                                    <li>
                                                        <a :href="'{{ url('guru/materi/download') }}/' + material.id" class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                            <i :class="{
                                                                'fas fa-file-pdf': material.file_type === 'pdf',
                                                                'fas fa-file-word': material.file_type === 'doc' || material.file_type === 'docx',
                                                                'fas fa-file-powerpoint': material.file_type === 'ppt' || material.file_type === 'pptx',
                                                            }"></i>
                                                            <span x-text="material.judul_materi"></span>
                                                        </a>
                                                        <button @click.prevent="deleteMateri(material.id, 'indo')" class="text-red-400 hover:text-red-600 ml-2 text-xs">Hapus</button>
                                                    </li>
                                                </template>
                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <button data-modal-target="modalBuatTugas" data-modal-toggle="modalBuatTugas"
                                                    @click="setTugasModalValues({{ $mapel['indo']->id }}, i);"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-book"></i>
                                                    <span>Buat Tugas</span>
                                                </button>
                                                {{-- Display tasks for Bahasa Indonesia --}}
                                                <template x-for="task in {{ json_encode($tasks['Bahasa Indonesia'] ?? []) }}[i] || []" :key="task.id">
                                                    <li>
                                                        <a :href="'{{ url('guru/tugas/download') }}/' + task.id" class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                            <i class="fas fa-file-alt"></i>
                                                            <span x-text="task.judul"></span>
                                                            <span class="text-xs ml-2">(Deadline: <span x-text="task.deadline"></span>)</span>
                                                        </a>
                                                        <button @click.prevent="deleteTugas(task.id, 'indo')" class="text-red-400 hover:text-red-600 ml-2 text-xs">Hapus</button>
                                                    </li>
                                                </template>
                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <a href="{{ route('guru.pengumpulan') }}"
                                                 class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-paperclip"></i>
                                                    <span>Pengumpulan</span>
                                                </a>

                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <a x-bind:href="'{{ route('penilaian.index', ['mapelId' => $mapel['indo']->id]) }}' + '?minggu=' + i"
                                                    class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-clipboard-check"></i>
                                                    <span>Penilaian</span>
                                                </a>

                                                <a x-bind:href="'{{ route('guru.absensi.show', $mapel['indo']->id) }}' + '?minggu=' + i"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>Absensi</span>
                                                </a>
                                            </div>
                                        @endif
                                    </template>

                                    {{-- KONDISI UNTUK TAB BAHASA INGGRIS --}}
                                    <template x-if="tab === 'inggris'">
                                        @if(isset($mapel['inggris']))
                                            <div>
                                                <button data-modal-target="modalTambahMateri"
                                                    data-modal-toggle="modalTambahMateri"
                                                    @click="setMateriModalValues({{ $mapel['inggris']->id }}, i);"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span>Tambah Materi</span>
                                                </button>
                                                {{-- Display materials for Bahasa Inggris --}}
                                                <template x-for="material in {{ json_encode($materials['Bahasa Inggris'] ?? []) }}[i] || []" :key="material.id">
                                                    <li>
                                                        <a :href="'{{ url('guru/materi/download') }}/' + material.id" class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                            <i :class="{
                                                                'fas fa-file-pdf': material.file_type === 'pdf',
                                                                'fas fa-file-word': material.file_type === 'doc' || material.file_type === 'docx',
                                                                'fas fa-file-powerpoint': material.file_type === 'ppt' || material.file_type === 'pptx',
                                                            }"></i>
                                                            <span x-text="material.judul_materi"></span>
                                                        </a>
                                                        <button @click.prevent="deleteMateri(material.id, 'inggris')" class="text-red-400 hover:text-red-600 ml-2 text-xs">Hapus</button>
                                                    </li>
                                                </template>
                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <button data-modal-target="modalBuatTugas" data-modal-toggle="modalBuatTugas"
                                                    @click="setTugasModalValues({{ $mapel['inggris']->id }}, i);"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-book"></i>
                                                    <span>Buat Tugas</span>
                                                </button>
                                                {{-- Display tasks for Bahasa Inggris --}}
                                                <template x-for="task in {{ json_encode($tasks['Bahasa Inggris'] ?? []) }}[i] || []" :key="task.id">
                                                    <li>
                                                        <a :href="'{{ url('guru/tugas/download') }}/' + task.id" class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                            <i class="fas fa-file-alt"></i>
                                                            <span x-text="task.judul"></span>
                                                            <span class="text-xs ml-2">(Deadline: <span x-text="task.deadline"></span>)</span>
                                                        </a>
                                                        <button @click.prevent="deleteTugas(task.id, 'inggris')" class="text-red-400 hover:text-red-600 ml-2 text-xs">Hapus</button>
                                                    </li>
                                                </template>
                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <a href="{{ route('guru.pengumpulan') }}"
                                                 class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-paperclip"></i>
                                                    <span>Pengumpulan</span>
                                                </a>

                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <a x-bind:href="'{{ route('penilaian.index', ['mapelId' => $mapel['inggris']->id]) }}' + '?minggu=' + i"
                                                    class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-clipboard-check"></i>
                                                    <span>Penilaian</span>
                                                </a>

                                                <a x-bind:href="'{{ route('guru.absensi.show', $mapel['inggris']->id) }}' + '?minggu=' + i"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>Absensi</span>
                                                </a>
                                            </div>
                                        @endif
                                    </template>

                                    {{-- KONDISI UNTUK TAB MATEMATIKA --}}
                                    <template x-if="tab === 'mtk'">
                                        @if(isset($mapel['mtk']))
                                            <div>
                                                <button data-modal-target="modalTambahMateri"
                                                    data-modal-toggle="modalTambahMateri"
                                                    @click="setMateriModalValues({{ $mapel['mtk']->id }}, i);"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span>Tambah Materi</span>
                                                </button>
                                                {{-- Display materials for Matematika --}}
                                                <template x-for="material in {{ json_encode($materials['Matematika'] ?? []) }}[i] || []" :key="material.id">
                                                    <li>
                                                        <a :href="'{{ url('guru/materi/download') }}/' + material.id" class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                            <i :class="{
                                                                'fas fa-file-pdf': material.file_type === 'pdf',
                                                                'fas fa-file-word': material.file_type === 'doc' || material.file_type === 'docx',
                                                                'fas fa-file-powerpoint': material.file_type === 'ppt' || material.file_type === 'pptx',
                                                            }"></i>
                                                            <span x-text="material.judul_materi"></span>
                                                        </a>
                                                        <button @click.prevent="deleteMateri(material.id, 'mtk')" class="text-red-400 hover:text-red-600 ml-2 text-xs">Hapus</button>
                                                    </li>
                                                </template>
                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <button data-modal-target="modalBuatTugas" data-modal-toggle="modalBuatTugas"
                                                    @click="setTugasModalValues({{ $mapel['mtk']->id }}, i);"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-book"></i>
                                                    <span>Buat Tugas</span>
                                                </button>
                                                {{-- Display tasks for Matematika --}}
                                                <template x-for="task in {{ json_encode($tasks['Matematika'] ?? []) }}[i] || []" :key="task.id">
                                                    <li>
                                                        <a :href="'{{ url('guru/tugas/download') }}/' + task.id" class="flex items-center space-x-2 px-4 py-2 bg-white text-blue-700 font-semibold rounded shadow hover:bg-gray-100 transition mb-2">
                                                            <i class="fas fa-file-alt"></i>
                                                            <span x-text="task.judul"></span>
                                                            <span class="text-xs ml-2">(Deadline: <span x-text="task.deadline"></span>)</span>
                                                        </a>
                                                        <button @click.prevent="deleteTugas(task.id, 'mtk')" class="text-red-400 hover:text-red-600 ml-2 text-xs">Hapus</button>
                                                    </li>
                                                </template>
                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <a href="{{ route('guru.pengumpulan') }}"
                                                 class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-paperclip"></i>
                                                    <span>Pengumpulan</span>
                                                </a>

                                                <hr class="my-2 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

                                                <a x-bind:href="'{{ route('penilaian.index', ['mapelId' => $mapel['mtk']->id]) }}' + '?minggu=' + i"
                                                    class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-clipboard-check"></i>
                                                    <span>Penilaian</span>
                                                </a>

                                                <a x-bind:href="'{{ route('guru.absensi.show', $mapel['mtk']->id) }}' + '?minggu=' + i"
                                                     class="flex items-center space-x-2 text-white hover:underline text-sm">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>Absensi</span>
                                                </a>
                                        @endif
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- Script for handling delete --}}
    <script>
        function deleteMateri(id, subjectTab) {
            if (confirm('Apakah Anda yakin ingin menghapus materi ini?')) {
                fetch(`/guru/materi/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Gagal menghapus materi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus materi.');
                });
            }
        }

        function deleteTugas(id, subjectTab) {
            if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
                fetch(`/guru/tugas/${id}`, { // Assuming your delete route for tasks is /guru/tugas/{id}
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Gagal menghapus tugas: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus tugas.');
                });
            }
        }
    </script>

    {{-- Pastikan jalur ini benar sesuai dengan lokasi file modal Anda --}}
    @include('guru.modal_tambah_tugas')
    @include('guru.modal_tambah_materi')
@endsection
