@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">Manajemen Profile Guru</h1>

    <div class="mb-4">
        {{-- Tombol Kembali ke Dashboard Admin --}}
        <a href="{{ route('admin.dashboard') }}">
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
                        <th class="px-4 py-2 border">JK</th>
                        <th class="px-4 py-2 border">Alamat</th>
                        <th class="px-4 py-2 border">Guru Mapel</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Telepon</th> {{-- Menambahkan kolom Telepon --}}
                        <th class="px-4 py-2 border rounded-tr-md">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    {{-- Pastikan $dataGuru diteruskan dari controller (GuruController@index) --}}
                    @forelse ($dataGuru as $guru)
                        <tr class="border border-gray-300">
                            <td class="px-4 py-2 border">{{ $guru->id }}</td>
                            {{-- Mengakses properti dari objek $guru --}}
                            <td class="px-4 py-2 border font-semibold">{{ $guru->name ?? $guru->username }}</td> {{-- Gunakan 'name' atau 'username' --}}
                            <td class="px-4 py-2 border">{{ $guru->jenis_kelamin ?: '-' }}</td> {{-- Sesuaikan dengan nama kolom di DB Anda --}}
                            <td class="px-4 py-2 border">{{ $guru->alamat ?: '-' }}</td>
                            <td class="px-4 py-2 border">{{ $guru->guru_mata_pelajaran ?: '-' }}</td> {{-- Asumsi kolom 'mapel' ada di tabel 'users' --}}
                            <td class="px-4 py-2 border">{{ $guru->email }}</td>
                            <td class="px-4 py-2 border">{{ $guru->telepon ?: '-' }}</td> {{-- Asumsi kolom 'telepon' ada di tabel 'users' --}}
                            <td class="px-4 py-2 border">
                                <div class="flex justify-center gap-2">
                                    {{-- Tombol Edit (diaktifkan kembali dengan event onclick) --}}
                                    {{-- Tombol Hapus --}}
                                    <button class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-center text-gray-500">Tidak ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Sertakan modal edit guru yang akan digunakan oleh admin --}}
    @include("admin.modal_profile_guru")
</div>

<script>
    // Pastikan modalEditGuru dan elemen-elemen form ada di file 'admin.modal_profile_guru.blade.php'
    function openEditModal(guru) {
        const modal = document.getElementById('modalEditGuru');
        if (modal) {
            modal.classList.remove('hidden');
            // Jika Anda menggunakan Flowbite, Anda mungkin perlu inisialisasi modalnya di sini
            if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
                const flowbiteModal = new Flowbite.Modal(modal);
                flowbiteModal.show();
            } else {
                console.warn("Flowbite Modal library not found. Please ensure Flowbite JS is loaded.");
            }
        }

        const editGuruForm = document.getElementById('editGuruForm');
        if (editGuruForm) {
            editGuruForm.setAttribute('data-id', guru.id);
            // Mengakses properti dari objek guru, sesuaikan dengan nama kolom di tabel users Anda
            document.getElementById('editNama').value = guru.name || guru.username || '';
            document.getElementById('editTempatLahir').value = guru.tempat_lahir || '';
            document.getElementById('editTanggalLahir').value = guru.tanggal_lahir || '';

            const editJKL = document.getElementById('editJKL');
            const editJKP = document.getElementById('editJKP');

            if (editJKL && editJKP) {
                if (guru.jenis_kelamin === 'Laki-Laki') { // Sesuaikan nilai 'L' atau 'Laki-Laki'
                    editJKL.checked = true;
                } else if (guru.jenis_kelamin === 'Perempuan') { // Sesuaikan nilai 'P' atau 'Perempuan'
                    editJKP.checked = true;
                } else {
                    editJKL.checked = false;
                    editJKP.checked = false;
                }
            }

            document.getElementById('editMapel').value = guru.mapel || '';
            document.getElementById('editEmail').value = guru.email || '';
            document.getElementById('editTelepon').value = guru.telepon || '';
        }
    }

    // Fungsi closeEditModal
    function closeEditModal() {
        const modal = document.getElementById('modalEditGuru');
        if (modal) {
            if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
                const flowbiteModal = new Flowbite.Modal(modal);
                flowbiteModal.hide();
            } else {
                modal.classList.add('hidden');
            }
        }
    }

    // Event listener untuk submit form Edit (simulasi)
    document.getElementById('editGuruForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form disubmit secara default

        const guruId = this.getAttribute('data-id');
        const nama = document.getElementById('editNama').value;
        const tempatLahir = document.getElementById('editTempatLahir').value;
        const tanggalLahir = document.getElementById('editTanggalLahir').value;
        const jenisKelaminElement = document.querySelector('input[name="jenisKelamin"]:checked');
        const jenisKelamin = jenisKelaminElement ? jenisKelaminElement.value : '';
        const mapel = document.getElementById('editMapel').value;
        const email = document.getElementById('editEmail').value;
        const telepon = document.getElementById('editTelepon').value;

        console.log('Data guru yang akan diupdate (simulasi tanpa database):', {
            id: guruId,
            name: nama,
            tempat_lahir: tempatLahir,
            tanggal_lahir: tanggalLahir,
            jenis_kelamin: jenisKelamin,
            mapel: mapel,
            email: email,
            telepon: telepon,
        });

        // Di sini Anda akan melakukan AJAX request untuk mengirim data ke server
        // Contoh: fetch('/admin/gurus/' + guruId, { method: 'PUT', body: JSON.stringify({ ...data }) })
        // Setelah berhasil, Anda bisa me-refresh tabel atau memperbarui baris yang relevan

        closeEditModal();
        // Anda mungkin ingin me-reload halaman atau memperbarui baris tabel secara dinamis di sini
        // location.reload(); // Hanya jika Anda ingin me-refresh halaman setelah update
    });
</script>
@endsection
