@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">Manajemen Profile Guru</h1>

    <div class="mb-4">
        <a href="{{ route('guru.index') }}">
            <button class="bg-blue-800 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>
        </a>
    </div>

    <div class="flex justify-center">
        <div class="w-full max-w-6xl overflow-x-auto rounded-md shadow-md">
            <table class="min-w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
                <thead class="bg-gray-300 text-center font-semibold">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Tempat Lahir</th>
                        <th class="px-4 py-2 border">Tanggal Lahir</th>
                        <th class="px-4 py-2 border">JK</th>
                        <th class="px-4 py-2 border">Guru Mapel</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border rounded-tr-md">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($dataGuru as $guru)
                        <tr class="border border-gray-300">
                            <td class="px-4 py-2 border">{{ $guru['id'] }}</td>
                            <td class="px-4 py-2 border font-semibold">{{ $guru['nama'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['tempat_lahir'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['tanggal_lahir'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['jk'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['mapel'] }}</td>
                            <td class="px-4 py-2 border">{{ $guru['email'] }}</td>
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center gap-2">
                                    <button onclick="openEditModal({{ json_encode($guru) }})" class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include("admin.modal_profile_guru")
</div>

<script>
    function openEditModal(guru) {
        document.getElementById('modalEditGuru').classList.remove('hidden');
        document.getElementById('editGuruForm').setAttribute('data-id', guru.id);
        document.getElementById('editNama').value = guru.nama;
        document.getElementById('editTempatLahir').value = guru.tempat_lahir;
        document.getElementById('editTanggalLahir').value = guru.tanggal_lahir;

        if (guru.jk === 'L') {
            document.getElementById('editJKL').checked = true;
        } else if (guru.jk === 'P') {
            document.getElementById('editJKP').checked = true;
        }

        document.getElementById('editMapel').value = guru.mapel;
        document.getElementById('editEmail').value = guru.email;
        // Anda mungkin perlu menambahkan isian untuk No HP jika ada di data guru
    }

    function closeEditModal() {
        document.getElementById('modalEditGuru').classList.add('hidden');
    }

    document.getElementById('editGuruForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const guruId = this.getAttribute('data-id');
        const nama = document.getElementById('editNama').value;
        const tempatLahir = document.getElementById('editTempatLahir').value;
        const tanggalLahir = document.getElementById('editTanggalLahir').value;
        const jk = document.querySelector('input[name="jenisKelamin"]:checked').value;
        const mapel = document.getElementById('editMapel').value;
        const email = document.getElementById('editEmail').value;
        // Dapatkan juga nilai No HP jika ada inputnya

        // Lakukan logika pengiriman data ke server atau update data lokal di sini
        console.log('Data guru yang akan diupdate:', {
            id: guruId,
            nama: nama,
            tempat_lahir: tempatLahir,
            tanggal_lahir: tanggalLahir,
            jk: jk,
            mapel: mapel,
            email: email,
            // tambahkan no_hp jika ada
        });

        // Setelah berhasil menyimpan, tutup modal
        closeEditModal();
    });
</script>
@endsection
