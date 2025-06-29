@extends('layouts.app')

@section('content')

<style>
    @keyframes floatingFade {
        0%, 100% { transform: translateX(0); opacity: 0; }
        25%, 75% { opacity: 0.3; }
        50% { opacity: 0.6; }
    }

    .animate-floating-fade {
        animation: floatingFade 15s ease-in-out infinite;
    }
</style>

{{-- Background animasi --}}
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
    <img src="{{ asset('images/6.png') }}" alt="Background"
        class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
</div>

<div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">Manajemen Profil Siswa</h1>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('admin.profile_siswa') }}" class="mb-4 flex justify-center">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari berdasarkan ID atau Nama..."
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700"
        >
            Cari
        </button>
    </form>

    {{-- Pesan sukses / error --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 rounded text-sm mb-4 text-center w-full max-w-2xl mx-auto">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-2 rounded text-sm mb-4 text-center w-full max-w-2xl mx-auto">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Data Siswa --}}
    <div class="overflow-x-auto rounded-md shadow-md max-w-5xl mx-auto">
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
                        <td class="px-4 py-2 border break-words">{{ $siswa->custom_identifier }}</td>
                        <td class="px-4 py-2 border font-semibold">{{ $siswa->name ?: $siswa->username }}</td>
                        <td class="px-4 py-2 border">{{ $siswa->jenis_kelamin ?: '-' }}</td>
                        <td class="px-4 py-2 border break-words">{{ $siswa->alamat ?: '-' }}</td>
                        <td class="px-4 py-2 border break-words">{{ $siswa->email }}</td>
                        <td class="px-4 py-2 border">{{ $siswa->telepon ?: '-' }}</td>
                        <td class="px-4 py-2 border flex justify-center items-center gap-2">
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun siswa {{ $siswa->name ?: $siswa->username }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-white border border-red-500 text-red-600 px-3 py-1 rounded text-sm hover:bg-red-100 flex items-center gap-1">
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

        {{-- Paginasi --}}
        <div class="mt-4 px-4">
            {{ $dataSiswa->withQueryString()->links() }}
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- Tambahkan script JavaScript jika dibutuhkan --}}
@endsection
