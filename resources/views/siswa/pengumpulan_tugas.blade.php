@extends('layouts.navbar')

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

    <!-- background animasi -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/9.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

<div class="relative z-10 max-w-6xl mx-auto px-4 py-4">

    {{-- Judul Halaman --}}
    <h2 class="text-xl sm:text-2xl font-bold text-center text-gray-800 mb-4 flex items-center justify-center gap-2">
        📚 <span>Pengumpulan Tugas</span>
    </h2>

    {{-- Tombol Kembali --}}
    <a href="{{ route('siswa.kursus.index') }}"
       class="inline-block mb-3 bg-blue-700 hover:bg-blue-800 text-white font-semibold py-1.5 px-4 rounded text-sm transition duration-300 ease-in-out transform hover:scale-105">
        ⬅ Kembali
    </a>

    {{-- Kontainer Dua Kolom --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Kiri: Detail Tugas + Status --}}
        <div class="space-y-4">
            {{-- Detail Tugas --}}
            <div class="bg-white border border-gray-200 shadow rounded-lg p-4">
                <h3 class="text-base font-semibold text-gray-700 mb-2 flex items-center gap-2">📘 Detail Tugas</h3>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li><strong>Mata Pelajaran:</strong> {{ $mapel->nama }}</li>
                    <li><strong>Minggu Ke:</strong> {{ $mingguKe }}</li>
                    <li><strong>Judul Tugas:</strong> {{ $tugas->judul }}</li>
                    <li><strong>Deskripsi:</strong> {{ $tugas->deskripsi ?? '-' }}</li>
                    <li><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}</li>
                </ul>
            </div>

            {{-- Status Pengumpulan --}}
            <div class="bg-white border border-gray-200 shadow rounded-lg p-4">
                <h3 class="text-base font-semibold text-gray-700 mb-2 flex items-center gap-2">📄 Status Anda</h3>
                @if ($pengumpulanTugas)
                    <ul class="text-sm text-gray-700 space-y-1">
                        <li>
                            <strong>Status:</strong> {{ $pengumpulanTugas->status }}
                            @if ($pengumpulanTugas->nilai !== null)
                                <span class="text-green-600 font-medium">(Sudah Dinilai)</span>
                            @else
                                <span class="text-yellow-600 font-medium">(Menunggu Penilaian)</span>
                            @endif
                        </li>
                        <li><strong>Nilai:</strong> {{ $pengumpulanTugas->nilai ?? '-' }}</li>
                        <li><strong>File:</strong>
                            <a href="{{ asset('storage/' . $pengumpulanTugas->file_path) }}"
                               class="text-blue-600 underline" target="_blank">Lihat File</a>
                        </li>
                        <li><strong>Keterangan:</strong> {{ $pengumpulanTugas->keterangan_siswa ?? '-' }}</li>
                    </ul>
                @else
                    <p class="text-red-500 text-sm">Anda belum mengumpulkan tugas ini.</p>
                @endif
            </div>
        </div>

        {{-- Kanan: Form Upload --}}
        <div class="bg-white border border-gray-200 shadow rounded-lg p-4 h-full">
            <h3 class="text-base font-semibold text-gray-700 mb-2 flex items-center gap-2">
                📤 <span>{{ $pengumpulanTugas ? 'Perbarui Tugas' : 'Unggah Tugas' }}</span>
            </h3>

            <form action="{{ route('siswa.pengumpulan_tugas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                <input type="hidden" name="tugas_id" value="{{ $tugas->id }}">
                <input type="hidden" name="minggu_ke" value="{{ $mingguKe }}">

                {{-- File --}}
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700" for="file_tugas">🗂️ File Tugas</label>
                    <input type="file" name="file_tugas" accept=".pdf,.docx,.jpg,.jpeg,.png,.zip"
                           class="w-full px-3 py-1.5 border border-gray-300 rounded text-sm" {{ $pengumpulanTugas ? '' : 'required' }}>
                    <p class="text-xs text-gray-500 mt-1">Format: PDF, DOCX, JPG, PNG, ZIP. Max 2MB.</p>
                    @error('file_tugas') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium mb-1 text-gray-700" for="keterangan">📝 Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full px-3 py-1.5 border border-gray-300 rounded text-sm">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tombol --}}
                <div>
                    <button type="submit"
                            class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                        {{ $pengumpulanTugas ? '🔄 Perbarui Tugas' : '⬆️ Unggah Tugas' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
