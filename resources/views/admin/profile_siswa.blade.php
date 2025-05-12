<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-yzK+xOuhvEfrF9D3MGoUczFayVmEr0mTwqkqMZWTtfJLPbOP+6FfqDloTfByywvqlwDZcKQhOj9MYj8+1qJZPQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include 'navbar.php'; ?>
    <?php include 'modal_profile_siswa.php'; ?>

    <div class="text-white p-2 mt-20">
        <div class="container mx-auto flex justify-between items-center">
            <a href="halaman_utama.php">
                <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded shadow-md">
                    Kembali
                </button>
            </a>
        </div>
    </div>

    <div class="px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 text-center my-6">MANAJEMEN PROFILE SISWA</h1>
        </div>
    </div>

    <div class="overflow-x-auto rounded-md shadow-md max-w-7xl mx-auto mt-4">
        <table class="w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
            <thead class="bg-gray-300 text-center font-semibold">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Tempat Lahir</th>
                    <th class="px-4 py-2 border">Tanggal Lahir</th>
                    <th class="px-4 py-2 border">Jenis Kelamin</th>
                    <th class="px-4 py-2 border">Alamat</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr class="border border-gray-300">
                    <td class="px-4 py-2 border">001</td>
                    <td class="px-4 py-2 border font-semibold">Nama Siswa</td>
                    <td class="px-4 py-2 border">Bandung</td>
                    <td class="px-4 py-2 border">2005-01-01</td>
                    <td class="px-4 py-2 border">Laki-Laki</td>
                    <td class="px-4 py-2 border">Jl. Merdeka No. 1</td>
                    <td class="px-4 py-2 border">siswa1@example.com</td>
                    <td class="px-4 py-2 border flex justify-center items-center gap-2">
                        <button data-modal-target="modalEditSiswa" data-modal-toggle="modalEditSiswa" class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">
                            Edit
                        </button>
                        <button class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
