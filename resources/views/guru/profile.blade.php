@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-1">Profil Guru</h1>

    <div class="flex justify-center">
        {{-- Form ini hanya untuk menampilkan data. Tombol di bawah akan membuka modal edit. --}}
        <form class="w-full max-w-3xl space-y-2">
            {{-- Tidak perlu @csrf atau @method('PUT') di sini karena form ini tidak disubmit --}}

            @if(session('success'))
                <div class="bg-green-500 text-white p-2 rounded text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-black mb-1">ID</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->id ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Nama</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->name ?? 'N/A' }}
                </div>
            </div>

            {{-- Alamat Lengkap --}}
            <div>
                <label class="block text-sm font-medium text-black mb-1">Alamat</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->alamat ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Guru Mata Pelajaran</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->mapel ?? 'N/A' }} {{-- Asumsi kolom di DB adalah 'mapel' --}}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Jenis Kelamin</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->jenis_kelamin ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Telepon</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->telepon ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Email</label> {{-- Typo fixed: removed extra " --}}
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->email ?? 'N/A' }}
                </div>
            </div>

            <div class="flex justify-center pt-3">
                <button type="button"
                        data-modal-target="editProfileModal" data-modal-toggle="editProfileModal"
                        class="text-white bg-[#1F1AA1] hover:bg-[#1a178f] focus:ring-2 focus:outline-none focus:ring-[#1F1AA1]/50 font-medium rounded-xl text-sm px-4 py-2 sm:mt-2">
                    Perbarui Profil
                </button>
            </div>
        </form>
    </div>
</div>

@include('guru.modal_edit_profile')
@endsection
