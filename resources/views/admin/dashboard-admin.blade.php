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
                opacity: 0.3; /* Mengurangi opacity dari 4 agar lebih halus */
            }

            50% {
                transform: translateX(-10px);
                opacity: 0.6; /* Mengurangi opacity dari 7 agar lebih halus */
            }

            75% {
                opacity: 0.3; /* Mengurangi opacity dari 5 agar lebih halus */
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
                    {{-- PERBAIKAN DI SINI: Menampilkan jumlah user yang belum diverifikasi --}}
                    <p class="text-4xl font-bold mb-2">{{ $totalUnverifiedUsers ?? 0 }}</p>
                    <p class="text-sm mb-4 text-center">TOTAL PENDAFTARAN BARU</p> {{-- Ubah teks agar lebih jelas --}}
                    <a href="{{ route('admin.verifikasi') }}" {{-- Gunakan route() helper --}}
                        class="bg-white text-[#1F1AA1] text-sm font-semibold px-4 py-1 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                        LIHAT
                    </a>
                </div>

                <div
                    class="w-64 h-64 bg-[#1F1AA1] text-white rounded-2xl flex flex-col justify-center items-center shadow-md px-4 py-6 transition duration-300 ease-in-out transform hover:scale-105">
                    <h5 class="text-lg font-semibold mb-2">DATA SISWA</h5>
                    <p class="text-4xl font-bold mb-2">{{ $totalSiswa ?? 0 }}</p>
                    <p class="text-sm mb-4 text-center">TOTAL AKUN SISWA</p>
                    <a href="{{ route('admin.profile_siswa') }}" {{-- Gunakan route() helper dan nama rute yang benar --}}
                        class="bg-white text-[#1F1AA1] text-sm font-semibold px-4 py-1 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                        LIHAT
                    </a>
                </div>

                <div
                    class="w-64 h-64 bg-[#1F1AA1] text-white rounded-2xl flex flex-col justify-center items-center shadow-md px-4 py-6 transition duration-300 ease-in-out transform hover:scale-105">
                    <h5 class="text-lg font-semibold mb-2">DATA GURU</h5>
                    <p class="text-4xl font-bold mb-2">{{ $totalGuru ?? 0 }}</p>
                    <p class="text-sm mb-4 text-center">TOTAL AKUN GURU</p>
                    <a href="{{ route('admin.profile_guru') }}" {{-- Gunakan route() helper dan nama rute yang benar --}}
                        class="bg-white text-[#1F1AA1] text-sm font-semibold px-4 py-1 rounded-md hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                        LIHAT
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
