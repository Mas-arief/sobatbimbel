@extends('layouts.app')

@section('content')
    <div class="mt-8 sm:mt-16 md:mt-24 ml-0 sm:ml-64 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">PROFILE</h1>

        <form class="max-w-lg mx-auto mt-6 text-base">
            <div class="mb-4 sm:mb-6">
                <label for="id" class="block mb-2 text-base font-medium text-black dark:text-white">
                    ID
                </label>
                <input
                    type="text"
                    id="id"
                    name="id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled
                    value="{{ $user->id ?? 'N/A' }}">
            </div>

            <div class="mb-4 sm:mb-6">
                <label for="nama" class="block mb-2 text-base font-medium text-black dark:text-white">
                    Nama
                </label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled
                    value="{{ $user->name ?? 'N/A' }}">
            </div>

            <div class="mb-4 sm:mb-6">
                <label for="alamat" class="block mb-2 text-base font-medium text-black dark:text-white">
                    Alamat
                </label>
                <input
                    type="text"
                    id="alamat"
                    name="alamat"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled
                    value="{{ $user->alamat ?? 'N/A' }}">
            </div>

            <div class="mb-4 sm:mb-6">
                <label for="jenis_kelamin" class="block mb-2 text-base font-medium text-black dark:text-white">
                    Jenis Kelamin
                </label>
                <input
                    type="text"
                    id="jenis_kelamin"
                    name="jenis_kelamin"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled
                    value="{{ $user->jenis_kelamin ?? 'N/A' }}">
            </div>

            <div class="mb-4 sm:mb-6">
                <label for="telepon" class="block mb-2 text-base font-medium text-black dark:text-white">
                    Telepon
                </label>
                <input
                    type="text"
                    id="telepon"
                    name="telepon"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled
                    value="{{ $user->telepon ?? 'N/A' }}">
            </div>

            <div class="mb-4 sm:mb-6">
                <label for="email" class="block mb-2 text-base font-medium text-black dark:text-white">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-3 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    disabled
                    value="{{ $user->email ?? 'N/A' }}">
            </div>
            <div class="flex justify-center">
                <button data-modal-target="editProfileModal" data-modal-toggle="editProfileModal"
                        class="text-white bg-[#1F1AA1] hover:bg-[#1a178f] focus:ring-4 focus:outline-none
                               focus:ring-[#1F1AA1]/50 font-medium rounded-lg text-base px-6 py-2 text-center"
                        type="button">
                    Edit Profile
                </button>
            </div>
        </form>
    </div>

    {{-- Modal Edit Profile (Pastikan file ini ada di resources/views/siswa/modal_edit_profile.blade.php) --}}
    @include('siswa.modal_edit_profile')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.bundle.min.js"></script>
@endpush
