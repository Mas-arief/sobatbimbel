@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">Manajemen Profile Siswa</h1>

    <div class="mb-4">
        <a href="{{ route('dashboard') }}">
            <button class="bg-blue-800 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>
        </a>
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
                @php
                    $dataSiswa = [
                        [
                            'id' => '001',
                            'nama' => 'Budi Santoso',
                            'tempat_lahir' => 'Jakarta',
                            'tanggal_lahir' => '2006-03-15',
                            'jenis_kelamin' => 'Laki-Laki',
                            'alamat' => 'Jl. Kenanga No. 10',
                            'email' => 'budi.s@example.com',
                        ],
                        [
                            'id' => '002',
                            'nama' => 'Siti Aminah',
                            'tempat_lahir' => 'Bandung',
                            'tanggal_lahir' => '2005-11-20',
                            'jenis_kelamin' => 'Perempuan',
                            'alamat' => 'Gg. Mawar No. 5',
                            'email' => 'siti.a@example.com',
                        ],
                        [
                            'id' => '003',
                            'nama' => 'Rizky Pratama',
                            'tempat_lahir' => 'Surabaya',
                            'tanggal_lahir' => '2007-01-05',
                            'jenis_kelamin' => 'Laki-Laki',
                            'alamat' => 'Jl. Anggrek No. 123',
                            'email' => 'rizky.p@example.com',
                        ],
                        // Tambahkan data siswa lainnya di sini
                    ];
                @endphp
                @foreach ($dataSiswa as $siswa)
                    <tr class="border border-gray-300">
                        <td class="px-4 py-2 border">{{ $siswa['id'] }}</td>
                        <td class="px-4 py-2 border font-semibold">{{ $siswa['nama'] }}</td>
                        <td class="px-4 py-2 border">{{ $siswa['tempat_lahir'] }}</td>
                        <td class="px-4 py-2 border">{{ $siswa['tanggal_lahir'] }}</td>
                        <td class="px-4 py-2 border">{{ $siswa['jenis_kelamin'] }}</td>
                        <td class="px-4 py-2 border">{{ $siswa['alamat'] }}</td>
                        <td class="px-4 py-2 border">{{ $siswa['email'] }}</td>
                        <td class="px-4 py-2 border flex justify-center items-center gap-2">
                            <button onclick="openEditModal({{ json_encode($siswa) }})" data-modal-target="modalEditSiswa" data-modal-toggle="modalEditSiswa" class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">
                                Edit
                            </button>
                            <button class="bg-white border border-gray-600 px-2 py-1 rounded text-sm hover:bg-gray-100">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('admin.modal_profile_siswa')
</div>

<script>
    function openEditModal(siswa) {
        document.getElementById('modalEditSiswa').classList.remove('hidden');
        document.getElementById('editSiswaForm').setAttribute('data-id', siswa.id);
        document.getElementById('editNama').value = siswa.nama;
        document.getElementById('editTempatLahir').value = siswa.tempat_lahir;
        document.getElementById('editTanggalLahir').value = siswa.tanggal_lahir;

        if (siswa.jenis_kelamin === 'Laki-Laki') {
            document.getElementById('editJKL').checked = true;
        } else if (siswa.jenis_kelamin === 'Perempuan') {
            document.getElementById('editJKP').checked = true;
        }

        document.getElementById('editAlamat').value = siswa.alamat;
        document.getElementById('editEmail').value = siswa.email;
        // Anda mungkin perlu menambahkan isian untuk kolom lain jika ada
    }

    function closeEditModal() {
        document.getElementById('modalEditSiswa').classList.add('hidden');
    }

    document.getElementById('editSiswaForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const siswaId = this.getAttribute('data-id');
        const nama = document.getElementById('editNama').value;
        const tempatLahir = document.getElementById('editTempatLahir').value;
        const tanggalLahir = document.getElementById('editTanggalLahir').value;
        const jenisKelamin = document.querySelector('input[name="jenisKelamin"]:checked').value;
        const alamat = document.getElementById('editAlamat').value;
        const email = document.getElementById('editEmail').value;
        // Dapatkan juga nilai kolom lain jika ada

        // Karena tidak ada database, kita hanya bisa menampilkan data yang diubah di konsol
        console.log('Data siswa setelah diubah (tanpa database):', {
            id: siswaId,
            nama: nama,
            tempat_lahir: tempatLahir,
            tanggal_lahir: tanggalLahir,
            jenis_kelamin: jenisKelamin,
            alamat: alamat,
            email: email,
            // tambahkan kolom lain jika ada
        });

        // Setelah "menyimpan" (hanya menampilkan di konsol), tutup modal
        closeEditModal();
    });
</script>
@endsection
