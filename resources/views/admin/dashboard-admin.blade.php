@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        @keyframes floatingFade {
            0% {
                transform: translateX(30px);
                opacity: 0;
            }

            25% {
                opacity: 4;
            }

            50% {
                transform: translateX(-10px);
                opacity: 7;
            }

            75% {
                opacity: 5;
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

    <!-- background animasi -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/10.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">
        <h1 class="text-2xl font-bold text-gray-800">HALAMAN UTAMA</h1>

        <div class="relative z-10 flex justify-center mt-20">
            <div class="flex flex-wrap gap-10 pl-4 pr-4">
                <div
                    class="w-64 h-64 bg-[#1F1AA1] text-white rounded-2xl flex flex-col justify-center items-center shadow-md px-4 py-6 transition duration-300 ease-in-out transform hover:scale-105">
                    <h5 class="text-lg font-semibold mb-2">DATA PENDAFTARAN</h5>
                    {{-- Ini akan menampilkan jumlah user dengan role 'siswa' --}}
                    <p class="text-4xl font-bold mb-2">{{ $totalSiswa ?? 0 }}</p>
                    <p class="text-sm mb-4 text-center">TOTAL PENDAFTARAN</p>
                    <a href="{{ url('admin.verifikasi') }}"
                        class="bg-white text-[#1F1AA1] text-sm font-semibold px-4 py-1 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                        LIHAT
                    </a>
                </div>

                <div
                    class="w-64 h-64 bg-[#1F1AA1] text-white rounded-2xl flex flex-col justify-center items-center shadow-md px-4 py-6 transition duration-300 ease-in-out transform hover:scale-105">
                    <h5 class="text-lg font-semibold mb-2">DATA SISWA</h5>
                    {{-- Ini akan menampilkan jumlah user dengan role 'siswa' --}}
                    <p class="text-4xl font-bold mb-2">{{ $totalSiswa ?? 0 }}</p>
                    <p class="text-sm mb-4 text-center">TOTAL AKUN SISWA</p>
                    <a href="{{ url('admin.profile_siswa') }}"
                        class="bg-white text-[#1F1AA1] text-sm font-semibold px-4 py-1 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                        LIHAT
                    </a>
                </div>

                <div
                    class="w-64 h-64 bg-[#1F1AA1] text-white rounded-2xl flex flex-col justify-center items-center shadow-md px-4 py-6 transition duration-300 ease-in-out transform hover:scale-105">
                    <h5 class="text-lg font-semibold mb-2">DATA GURU</h5>
                    {{-- Ini akan menampilkan jumlah user dengan role 'guru' --}}
                    <p class="text-4xl font-bold mb-2">{{ $totalGuru ?? 0 }}</p>
                    <p class="text-sm mb-4 text-center">TOTAL AKUN GURU</p>
                    <a href="{{ url('admin.profile_guru') }}"
                        class="bg-white text-[#1F1AA1] text-sm font-semibold px-4 py-1 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                        LIHAT
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection