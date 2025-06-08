<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yzK+xOuhvF9D3MGoUczFayVmEr0mTwqkqMZWTtfJLPbOP+6FfqDloTfByywvqlwDZcKQhOj9MYj8+1qJZPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Daftar Akun</title>
</head>

<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100 space-y-10 p-4">
    <div class="bg-blue-900 text-white p-8 rounded-3xl w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6">DAFTAR</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf

            {{-- Menampilkan semua error validasi di bagian atas form --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Nama Pengguna (Username) --}}
            <div class="relative mb-4">
                <input type="text" id="username" name="username" placeholder="Nama Pengguna"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror"
                    required value="{{ old('username') }}" />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-user"></i>
                </span>
                @error('username')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div class="relative mb-4">
                <input type="text" id="name" name="name" placeholder="Nama Lengkap"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    required value="{{ old('name') }}" />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-id-card"></i>
                </span>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="relative mb-4">
                <input type="email" id="email" name="email" placeholder="Email"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                    required value="{{ old('email') }}" />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-envelope"></i>
                </span>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="relative mb-4">
                <input type="password" id="password" name="password" placeholder="Kata Sandi"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                    required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="relative mb-4">
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Konfirmasi Kata Sandi"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
            </div>

            {{-- Pilih Role (Siswa/Guru) --}}
            <div class="relative mb-6">
                <select name="role" id="role"
                    class="w-full pl-10 pr-4 py-2 rounded-full text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror"
                    required>
                    <option value="">Pilih Peran</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                </select>
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-user-tag"></i>
                </span>
                @error('role')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-white text-blue-900 font-bold py-2 rounded-xl hover:bg-gray-100 transition duration-300">DAFTAR</button>

            <p class="text-center mt-4 text-sm text-white">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-blue-300 hover:underline">Masuk</a>
            </p>
        </form>
    </div>

    <script>

    </script>
</body>

</html>
