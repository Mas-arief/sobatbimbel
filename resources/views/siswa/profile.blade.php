@extends('layouts.app')

@section('title', 'Profil Siswa')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-1">Profil Siswa</h1>

    <div class="flex justify-center">
        <form action="{{ route('siswa.profile.update') }}" method="POST" class="w-full max-w-3xl space-y-2">
            @csrf

            {{-- Tampilkan pesan sukses jika ada --}}
            @if(session('success'))
                <div class="bg-green-500 text-white p-2 rounded text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ID Pengguna --}}
            <div>
                <label class="block text-sm font-medium text-black mb-1">ID</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->id ?? 'N/A' }}
                </div>
            </div>

            {{-- Nama Pengguna --}}
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

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-sm font-medium text-black mb-1">Jenis Kelamin</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->jenis_kelamin ?? 'N/A' }}
                </div>
            </div>

            {{-- Nomor Telepon --}}
            <div>
                <label class="block text-sm font-medium text-black mb-1">Telepon</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->telepon ?? 'N/A' }}
                </div>
            </div>

            {{-- Alamat Email --}}
            <div>
                <label class="block text-sm font-medium text-black mb-1">Email</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->email ?? 'N/A' }}
                </div>
            </div>

            {{-- Tombol Edit Profil --}}
            <div class="flex justify-center pt-3">
                <button type="button"
                    data-modal-target="editProfileModal"
                    data-modal-toggle="editProfileModal"
                    class="text-white bg-[#1F1AA1] hover:bg-[#1a178f] focus:ring-2 focus:outline-none focus:ring-[#1F1AA1]/50 font-medium rounded-xl text-sm px-4 py-2 sm:mt-2">
                    Edit Profil
                </button>
            </div>
        </form>
    </div>
</div>

@include('siswa.modal_edit_profile')
@endsection
