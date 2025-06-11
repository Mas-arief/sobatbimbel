{{-- resources/views/auth/passwords/change-password.blade.php --}}

@extends('layouts.app') {{-- Asumsi Anda memiliki layout utama --}}

@section('title', 'Ganti Kata Sandi')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8 mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ganti Kata Sandi</h1>

        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('password.change') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">Password Lama</label>
                    <input type="password" name="current_password" id="current_password"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('current_password') border-red-500 @enderror"
                           required>
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                    <input type="password" name="password" id="password"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') border-red-500 @enderror"
                           required>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           required>
                </div>

                <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Ganti Kata Sandi
                </button>
            </form>
        </div>
    </div>
@endsection
