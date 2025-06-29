<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SOBAT BIMBEL')</title>

    {{-- Peringatan TailwindCSS CDN: Disarankan untuk tidak digunakan di produksi.
         Anda bisa mengabaikan ini untuk pengembangan, tetapi untuk produksi sebaiknya instal Tailwind sebagai PostCSS plugin. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex h-screen flex-col">
        {{-- Navbar dan Sidebar dinamis --}}
        <header>
            @if (isset($tipe) && $tipe === 'admin')
                @include('components.navbarA')
                @include('components.sidebarA')
            @elseif (isset($tipe) && $tipe === 'guru')
                @include('components.navbarG')
                @include('components.sidebarG')
            @elseif (isset($tipe) && $tipe === 'siswa')
                @include('components.navbarS')
                @include('components.sidebarS')
            @endif
        </header>

        <main class="flex-1 overflow-y-auto transition-all duration-200 p-4 sm:pl-64 pt-20">
            @yield('content')
        </main>

    </div>

    {{-- SCRIPTS UTAMA: Letakkan di sini untuk performa terbaik dan menghindari konflik --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    {{-- Penting: Muat plugin Alpine.js Collapse SEBELUM Alpine.js inti --}}
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Script kustom Anda --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('main');
            const sidebarToggle = document.getElementById('sidebarToggle');

            if (sidebar && mainContent && sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('sm:block');
                    mainContent.classList.toggle('sm:pl-64');
                });
            }
        });
    </script>
    {{-- Ini akan me-render semua script yang didefinisikan di @section('scripts') di view lain --}}
    @yield('scripts')
</body>

</html>
