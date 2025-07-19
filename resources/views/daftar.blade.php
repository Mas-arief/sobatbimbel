<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Daftar Akun</title>
    <style>
        @keyframes floatingFade {
            0% { transform: translateY(0px); opacity: 0.2; }
            25% { opacity: 0.4; }
            50% { transform: translateY(0px); opacity: 0.8; }
            75% { opacity: 0.4; }
            100% { transform: translateY(0px); opacity: 0.2; }
        }
        .animate-floating-fade {
            animation: floatingFade 15s ease-in-out infinite;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100 space-y-10 p-4">

    <!-- background animasi -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/4.png') }}" alt="Background"
            class="absolute top-0 left-0 w-full h-full object-cover scale-110 opacity-5 animate-floating-fade" />
    </div>

    <div class="relative z-10 bg-blue-900 text-white p-8 rounded-3xl w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6">DAFTAR</h2>

        {{-- Pesan Sukses --}}
        @if(session('success'))
            <div id="successAlert"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-700 ease-in-out">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Pesan Error --}}
        @if ($errors->any())
            <div id="errorAlert"
                class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-700 ease-in-out">
                <strong class="font-bold">Terjadi Kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="relative mb-4">{{-- Username --}}
                <input type="text" name="username" placeholder="Nama Pengguna"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 @error('username') border-red-500 @enderror"
                    value="{{ old('username') }}" required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-user"></i>
                </span>
                @error('username')
                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-4"> {{-- Nama --}}
                <input type="text" name="name" placeholder="Nama Lengkap"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 @error('name') border-red-500 @enderror"
                    value="{{ old('name') }}" required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-id-card"></i>
                </span>
                @error('name')
                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-4"> {{-- Email --}}
                <input type="email" name="email" placeholder="Email"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}" required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-envelope"></i>
                </span>
                @error('email')
                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-4"> {{-- Password --}}
                <input type="password" name="password" placeholder="Kata Sandi"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 @error('password') border-red-500 @enderror"
                    required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                @error('password')
                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-4"> {{-- Konfirmasi Password --}}
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400"
                    required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
            </div>

            <div class="relative mb-6">{{-- Role --}}
                <select name="role" class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 @error('role') border-red-500 @enderror" required>
                    <option value="">Pilih Peran</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-user-tag"></i>
                </span>
                @error('role')
                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-white text-blue-900 font-bold py-2 rounded-xl hover:bg-gray-100 transition duration-300 ease-in-out transform hover:scale-105">
                DAFTAR
            </button>

            <p class="text-center mt-4 text-sm text-white">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-blue-300 hover:underline">Masuk</a>
            </p>
        </form>
    </div>

    {{-- Script: Auto-dismiss alert --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const success = document.getElementById('successAlert');
            const error = document.getElementById('errorAlert');

            [success, error].forEach(alert => {
                if (alert) {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 700);
                    }, 4000);
                }
            });
        });
    </script>
</body>
</html>
