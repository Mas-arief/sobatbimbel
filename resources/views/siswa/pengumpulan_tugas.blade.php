<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">
</head>

<body class="bg-white font-[Inter]">
    <?php include 'modal/modal_kumpul_tugas.php'; ?>
    <!-- Header -->
    <div class="text-white p-2">
        <div class="container mx-auto flex justify-between items-center">
            <a href="kursus.php">
                <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow-md">
                    Kembali
                </button>
            </a>
        </div>
    </div>

    <!-- Title -->
    <h1 class="text-2xl font-bold text-center mt-6 mb-6">Pengumpulan Tugas</h1>

    <!-- Tabel Status dan Nilai -->
    <div class="max-w-xl mx-auto shadow-md border border-gray-200 rounded">
        <table class="w-full text-left table-auto border-collapse">
            <tbody>
                <tr class="border-b border-gray-200">
                    <td class="p-4 font-medium text-gray-700">Status Tugas</td>
                    <td class="p-4"></td>
                </tr>
                <tr>
                    <td class="p-4 font-medium text-gray-700">Nilai</td>
                    <td class="p-4"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tombol Unggah -->
    <div class="flex justify-center mt-6">
        <button data-modal-target="unggahModal" data-modal-toggle="unggahModal"
            class="bg-blue-900 hover:bg-blue-800 text-white text-sm font-bold py-2 px-6 rounded shadow-md">
            UNGGAH TUGAS
        </button>
    </div>
</body>

</html>