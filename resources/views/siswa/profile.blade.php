@extends('layouts.app')

@section('content')

<main class="pt-25 px-6">
    <div class="w-full max-w-6xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">PROFIL SISWA</h2>

        <form class="space-y-4">
            <!-- ID -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">ID</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700">
                    {{ $user->id ?? 'N/A' }}
                </div>
            </div>

            <!-- Nama -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Nama</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700">
                    {{ $user->name ?? 'N/A' }}
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Alamat</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700">
                    {{ $user->alamat ?? 'N/A' }}
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Jenis Kelamin</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700">
                    {{ $user->jenis_kelamin ?? 'N/A' }}
                </div>
            </div>

            <!-- Telepon -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Telepon</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700">
                    {{ $user->telepon ?? 'N/A' }}
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Email</label>
                <div class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-700">
                    {{ $user->email ?? 'N/A' }}
                </div>
            </div>

            <!-- Edit Button -->
            <div class="pt-4">
                <button type="button"
                    data-modal-target="editProfileModal"
                    data-modal-toggle="editProfileModal"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-300">
                    Edit Profile
                </button>
            </div>
        </form>
    </div>
    </div>
    </div>

    @include('siswa.modal_edit_profile')
    @endsection