@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Profil Guru</h2>

    <!-- Tampilkan pesan sukses jika ada -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Menampilkan detail profil -->
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <!-- ID -->
        <div class="mb-6">
            <label for="id" class="block mb-2 text-base font-medium text-black">ID</label>
            <input type="text" id="id" class="bg-gray-75 border border-gray-250 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-not-allowed" disabled value="{{ $user['id'] }}">
        </div>

        <!-- Nama -->
        <div class="mb-6">
            <label for="nama" class="block mb-2 text-base font-medium text-black">Nama</label>
            <input type="text" id="nama" name="nama" class="bg-gray-75 border border-gray-250 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" value="{{ $user['nama'] }}">
        </div>

        <!-- Guru Mata Pelajaran -->
        <div class="mb-6">
            <label for="guru_mata_pelajaran" class="block mb-2 text-base font-medium text-black">Guru Mata Pelajaran</label>
            <input type="text" id="guru_mata_pelajaran" name="guru_mata_pelajaran" class="bg-gray-75 border border-gray-250 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" value="{{ $user['guru_mata_pelajaran'] }}">
        </div>

        <!-- Jenis Kelamin -->
        <div class="mb-6">
            <label for="jenis_kelamin" class="block mb-2 text-base font-medium text-black">Jenis Kelamin</label>
            <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="bg-gray-75 border border-gray-250 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" value="{{ $user['jenis_kelamin'] }}">
        </div>

        <!-- Telepon -->
        <div class="mb-6">
            <label for="telepon" class="block mb-2 text-base font-medium text-black">Telepon</label>
            <input type="text" id="telepon" name="telepon" class="bg-gray-75 border border-gray-250 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" value="{{ $user['telepon'] }}">
        </div>

        <!-- Email -->
        <div class="mb-6">
            <label for="email" class="block mb-2 text-base font-medium text-black">Email</label>
            <input type="email" id="email" name="email" class="bg-gray-75 border border-gray-250 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" value="{{ $user['email'] }}">
        </div>

        <!-- Tombol Edit Profile -->
        <div class="flex justify-center">
            <button type="submit" class="text-white bg-[#1F1AA1] hover:bg-[#1a178f] focus:ring-4 focus:outline-none focus:ring-[#1F1AA1]/50 font-medium rounded-lg text-base px-6 py-2 text-center">
                Perbarui Profil
            </button>
        </div>
    </form>
</div>
@endsection
