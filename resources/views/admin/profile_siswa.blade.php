@extends('layouts.app') {{-- Pastikan ini mengarah ke layout utama Anda --}}

@section('content')

    <style>
        /* CSS untuk animasi background yang Anda berikan */
        @keyframes floatingFade {
            0% {
                transform: translateX(0px);
                opacity: 0;
            }

            25% {
                opacity: 0.3;
            }

            50% {
                transform: translateX(0px);
                opacity: 0.6;
            }

            75% {
                opacity: 0.3;
            }

            100% {
                transform: translateX(0px);
                opacity: 0;
            }
        }

        .animate-floating-fade {
            animation: floatingFade 15s ease-in-out infinite;
        }
    </style>

    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/6.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mt-3">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">Manajemen Profil Siswa</h1>

        <div class="overflow-x-auto rounded-md shadow-md max-w-5xl mx-auto mt-4">
            @if(session('success'))
                <div class="bg-green-500 text-white p-2 rounded text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-500 text-white p-2 rounded text-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <table class="w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
                <thead class="bg-gray-300 text-center font-semibold">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Jenis Kelamin</th>
                        <th class="px-4 py-2 border">Alamat</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Telepon</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($dataSiswa as $siswa)
                        <tr class="border border-gray-300">
                            <td class="px-4 py-2 border">{{ $siswa->id }}</td>
                            <td class="px-4 py-2 border font-semibold">{{ $siswa->name ?: $siswa->username }}</td>
                            <td class="px-4 py-2 border">{{ $siswa->jenis_kelamin ?: '-' }}</td>
                            <td class="px-4 py-2 border">{{ $siswa->alamat ?: '-' }}</td>
                            <td class="px-4 py-2 border">{{ $siswa->email }}</td>
                            <td class="px-4 py-2 border">{{ $siswa->telepon ?: '-' }}</td>
                            <td class="px-4 py-2 border flex justify-center items-center gap-2">
                                {{-- Form untuk Hapus --}}
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun siswa {{ $siswa->name ?: $siswa->username }}?');">
                                    @csrf
                                    @method('DELETE') {{-- Method spoofing untuk DELETE request --}}
                                    <button type="submit"
                                        class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1 text-red-600">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Link Paginasi --}}
          
        </div>
    </div>

@endsection

{{-- Bagian scripts tidak perlu ada jika tidak ada interaksi JS kompleks --}}
@section('scripts')
{{-- Jika Anda hanya butuh SweetAlert atau library lain, letakkan di sini --}}
@endsection
