<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
    integrity="sha512-papmfwk2jVmNml+3jVv5DFyY6MT6swbxPUpLHvU4iUdYuvh/cGkiXtv5P9Jk5ZoebC4sAHBQxRhRTWuqDk3xmw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
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

    <!-- background animasi -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/4.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div class="relative z-10 bg-blue-900 text-white p-8 rounded-3xl w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6">MASUK</h2>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div id="successAlert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 transition-opacity duration-700 ease-in-out">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Pesan error validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="relative mb-4">
                <input type="text" id="username" name="username" placeholder="Nama Pengguna"
                    value="{{ old('username') }}"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror"
                    required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-user"></i>
                </span>
                @error('username')
                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-4">
                <input type="password" id="password" name="password" placeholder="Kata Sandi"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                    required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                @error('password')
                    <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="relative mb-6">
                <select name="role" id="role"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                    required>
                    <option value="">Pilih Role</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
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
                MASUK
            </button>

            <p class="text-center mt-4 text-sm text-white transition duration-300">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-blue-300 hover:underline">Daftar</a>
            </p>
        </form>
    </div>

    <!-- Script untuk menghilangkan alert -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertBox = document.getElementById('successAlert');
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.opacity = '0';
                    setTimeout(() => alertBox.remove(), 700);
                }, 3000);
            }
        });
    </script>
</body>

</html>
