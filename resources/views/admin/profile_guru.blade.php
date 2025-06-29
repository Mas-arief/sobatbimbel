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

<!-- Background animasi -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
    <img src="{{ asset('images/6.png') }}" alt="Background"
        class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
</div>

<div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">Manajemen Profil Guru</h1>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('admin.profile_guru') }}" class="mb-4 flex justify-center">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari berdasarkan ID atau Nama..."
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700">
            Cari
        </button>
    </form>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 rounded text-sm mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="overflow-auto rounded-md shadow-md">
        <table class="min-w-full table-fixed text-sm text-left text-black border border-gray-300 bg-gray-200">
            <thead class="bg-gray-300 text-center font-semibold">
                <tr>
                    <th class="w-24 px-2 py-2 border">ID</th>
                    <th class="w-40 px-2 py-2 border">Nama</th>
                    <th class="w-16 px-2 py-2 border">JK</th>
                    <th class="w-48 px-2 py-2 border">Alamat</th>
                    <th class="w-40 px-2 py-2 border">Guru Mapel</th>
                    <th class="w-60 px-2 py-2 border">Email</th>
                    <th class="w-32 px-2 py-2 border">Telepon</th>
                    <th class="w-40 px-2 py-2 border rounded-tr-md">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse ($dataGuru as $guru)
                    <tr class="border border-gray-300">
                        <td class="px-2 py-2 border break-words">{{ $guru->custom_identifier }}</td>
                        <td class="px-2 py-2 border font-semibold">{{ $guru->name ?? $guru->username }}</td>
                        <td class="px-2 py-2 border">{{ $guru->jenis_kelamin ?: '-' }}</td>
                        <td class="px-2 py-2 border break-words">{{ $guru->alamat ?: '-' }}</td>
                        <td class="px-2 py-2 border break-words">{{ $guru->mapel->nama ?? '-' }}</td>
                        <td class="px-2 py-2 border break-words">{{ $guru->email }}</td>
                        <td class="px-2 py-2 border">{{ $guru->telepon ?: '-' }}</td>
                        <td class="px-2 py-2 border">
                            <div class="flex flex-col md:flex-row justify-center gap-2">
                                <button type="button"
                                    class="btn-edit bg-white border border-green-600 px-2 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1"
                                    data-id="{{ $guru->id }}"
                                    data-mapel-id="{{ $guru->mapel_id ?? '' }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-white border border-red-500 text-red-600 px-3 py-1 rounded text-sm hover:bg-red-100 flex items-center gap-1 mx-auto">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">Tidak ada data guru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $dataGuru->withQueryString()->links() }}
        </div>
    </div>
</div>

@include("admin.modal_profile_guru")

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function () {
                const guruId = this.dataset.id;
                const mapelId = this.dataset.mapelId;

                const idInput = document.getElementById('editGuruId');
                const selectMapel = document.getElementById('editMapel');
                const form = document.getElementById('editGuruForm');
                const modal = document.getElementById('modalEditGuru');

                if (idInput) idInput.value = guruId;
                if (selectMapel) {
                    Array.from(selectMapel.options).forEach(option => {
                        option.selected = (option.value == mapelId);
                    });
                }

                if (form) form.setAttribute('action', `/admin/guru/${guruId}/atur-mapel`);
                if (modal) modal.classList.remove('hidden');
            });
        });
    });
</script>
@endsection
