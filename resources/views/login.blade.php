<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yzK+xOuhvEfrF9D3MGoUczFayVmEr0mTwqkqMZWTtfJLPbOP+6FfqDloTfByywvqlwDZcKQhOj9MYj8+1qJZPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-blue-900 text-white p-8 rounded-3xl w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center mb-6">MASUK</h2>

        {{-- Menampilkan pesan sukses (misalnya, setelah registrasi) --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Menampilkan pesan error validasi (termasuk error 'belum diverifikasi' dari LoginController) --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">{{ $errors->first() }}</span> {{-- Hanya menampilkan pesan pertama --}}
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
                class="w-full bg-white text-blue-900 font-bold py-2 rounded-xl hover:bg-gray-100 transition duration-300">
                MASUK
            </button>

            <p class="text-center mt-4 text-sm text-white">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-blue-300 hover:underline">Daftar</a>
            </p>
        </form>
    </div>
</body>

</html>
