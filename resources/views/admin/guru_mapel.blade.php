<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yzK+xOuhvEfrF9D3MGoUczFayVmEr0mTwqkqMZWTtfJLPbOP+6FfqDloTfByywvqlwDZcKQhOj9MYj8+1qJZPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100">
    @extends('layouts.app')
    @include('admin.modal_guru_mapel')

    <!-- Header -->
    <div class="text-white p-2 mt-20">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/halaman_utama') }}">
                <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow-md">
                    Kembali
                </button>
            </a>
        </div>
    </div>

    <div class="px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 text-center my-6">MANAJEMEN GURU & MAPEL</h1>
        </div>
    </div>

    <div class="overflow-x-auto rounded-md shadow-md max-w-7xl mx-auto mt-4">
        <table class="w-full text-sm text-left text-black border border-white bg-gray-200">
            <thead class="bg-gray-300 text-center font-semibold">
                <tr>
                    <th class="px-4 py-2 border border-white">ID</th>
                    <th class="px-4 py-2 border border-white">Nama</th>
                    <th class="px-4 py-2 border border-white">Email</th>
                    <th class="px-4 py-2 border border-white">Guru Mapel</th>
                    <th class="px-4 py-2 border border-white rounded-tr-md">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td class="px-4 py-2 border border-white">001</td>
                    <td class="px-4 py-2 border border-white font-semibold">Nama Guru 1</td>
                    <td class="px-4 py-2 border border-white">guru1@example.com</td>
                    <td class="px-4 py-2 border border-white">Matematika</td>
                    <td class="px-4 py-2 border border-white">
                        <button data-modal-target="modalEditGuru" data-modal-toggle="modalEditGuru"
                            class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">
                            Pilih Mapel
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border border-white">002</td>
                    <td class="px-4 py-2 border border-white font-semibold">Nama Guru 2</td>
                    <td class="px-4 py-2 border border-white">guru2@example.com</td>
                    <td class="px-4 py-2 border border-white">Bahasa Inggris</td>
                    <td class="px-4 py-2 border border-white">
                        <button data-modal-target="modalEditGuru" data-modal-toggle="modalEditGuru"
                            class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">
                            Pilih Mapel
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
