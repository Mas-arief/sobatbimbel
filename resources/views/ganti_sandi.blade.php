<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yzK+xOuhvEfrF9D3MGoUczFayVmEr0mTwqkqMZWTtfJLPbOP+6FfqDloTfByywvqlwDZcKQhOj9MYj8+1qJZPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="flex items-center justify-center min-h-screen bg-transparent">
    <div class="text-white p-12 rounded-3xl w-full max-w-md bg-transparent">
        <h2 class="text-3xl font-bold text-center mb-6 text-blue-900">GANTI KATA SANDI</h2>
        <form action="ganti_password.php" method="POST">
            <!-- Kata Sandi Lama -->
            <div class="relative mb-6">
                <label for="new_password" class="block text-gray-700 text-base font-medium mb-2">Kata Sandi Baru</label>
                <input type="password" id="new_password" name="new_password" placeholder="Kata Sandi Lama"
                    class="w-full pl-10 pr-4 py-3 rounded-full text-gray-700 placeholder-gray-400 bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
            <!-- Kata Sandi Baru -->
            <div class="relative mb-6">
                <label for="confirm_new_password" class="block text-gray-700 text-base font-medium mb-2">Konfirmasi Kata Sandi Baru</label>
                <input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="Kata Sandi Baru"
                    class="w-full pl-10 pr-4 py-3 rounded-full text-gray-700 placeholder-gray-400 bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
            <p class="text-gray-700 text-sm italic text-center mb-4">*Kata sandi harus terdiri dari 8 karakter</p>
            <!-- Tombol Ganti -->
            <button type="submit"
                class="w-1/2 bg-blue-900 text-white font-bold py-2 px-6 rounded-xl hover:bg-blue-800 transition duration-300 mx-auto block text-sm">
                GANTI KATA SANDI
            </button>
        </form>
    </div>
</body>

</html>