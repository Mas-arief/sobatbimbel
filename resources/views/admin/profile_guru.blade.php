@extends('layouts.app') {{-- Mengextends layout utama aplikasi --}}

@section('content') {{-- Memulai bagian konten --}}

<style>
    /* Keyframes untuk animasi 'floatingFade' */
    @keyframes floatingFade {
        0%, 100% { transform: translateX(0); opacity: 0; } /* Posisi awal dan akhir, opasitas 0 */
        25%, 75% { opacity: 0.3; } /* Opasitas menengah */
        50% { opacity: 0.6; } /* Opasitas tertinggi di tengah animasi */
    }

    /* Menerapkan animasi ke elemen dengan kelas 'animate-floating-fade' */
    .animate-floating-fade {
        animation: floatingFade 15s ease-in-out infinite; /* Durasi 15s, easing ease-in-out, berulang tak terbatas */
    }
</style>

<!-- Background animasi -->
{{-- Div ini berfungsi sebagai kontainer untuk gambar latar belakang animasi --}}
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
    {{-- Gambar latar belakang --}}
    <img src="{{ asset('images/6.png') }}" alt="Background"
        class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
</div>

{{-- Konten utama halaman --}}
<div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">Manajemen Profil Guru</h1>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('admin.profile_guru') }}" class="mb-4 flex justify-center">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}" {{-- Menjaga nilai pencarian sebelumnya --}}
            placeholder="Cari berdasarkan ID atau Nama..."
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700">
            Cari
        </button>
    </form>

    {{-- Notifikasi sukses (jika ada) --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 rounded text-sm mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Data Guru --}}
    <div class="overflow-auto rounded-md shadow-md">
        <table class="min-w-full table-fixed text-sm text-left text-black border border-gray-300 bg-gray-200">
            {{-- Header Tabel --}}
            <thead class="bg-gray-300 text-center font-semibold">
                <tr>
                    <th class="w-24 px-2 py-2 border">ID</th>
                    <th class="w-40 px-2 py-2 border">Nama</th>
                    <th class="w-16 px-2 py-2 border">JK</th> {{-- Jenis Kelamin --}}
                    <th class="w-48 px-2 py-2 border">Alamat</th>
                    <th class="w-40 px-2 py-2 border">Guru Mapel</th> {{-- Mata Pelajaran yang diajar --}}
                    <th class="w-60 px-2 py-2 border">Email</th>
                    <th class="w-32 px-2 py-2 border">Telepon</th>
                    <th class="w-40 px-2 py-2 border rounded-tr-md">Aksi</th>
                </tr>
            </thead>
            {{-- Body Tabel --}}
            <tbody class="text-center">{{-- Loop melalui setiap guru dalam koleksi $dataGuru --}}
                @forelse ($dataGuru as $guru){{-- @forelse digunakan untuk menampilkan pesan jika koleksi $dataGuru kosong --}}
                    <tr class="border border-gray-300">
                        <td class="px-2 py-2 border break-words">{{ $guru->custom_identifier }}</td> {{-- Menampilkan ID kustom --}}
                        <td class="px-2 py-2 border font-semibold">{{ $guru->name ?? $guru->username }}</td> {{-- Nama atau username --}}
                        <td class="px-2 py-2 border">{{ $guru->jenis_kelamin ?: '-' }}</td> {{-- Jenis Kelamin atau '-' --}}
                        <td class="px-2 py-2 border break-words">{{ $guru->alamat ?: '-' }}</td> {{-- Alamat atau '-' --}}
                        <td class="px-2 py-2 border break-words">{{ $guru->mapel->nama ?? '-' }}</td> {{-- Nama Mapel atau '-' --}}
                        <td class="px-2 py-2 border break-words">{{ $guru->email }}</td> {{-- Email --}}
                        <td class="px-2 py-2 border">{{ $guru->telepon ?: '-' }}</td> {{-- Telepon atau '-' --}}
                        <td class="px-2 py-2 border">
                            <div class="flex flex-col md:flex-row justify-center gap-2">
                                {{-- Tombol Edit --}}
                                {{-- Kelas 'btn-edit' digunakan oleh JavaScript untuk menangani klik --}}
                                {{-- Atribut 'data-id' dan 'data-mapel-id' menyimpan ID guru dan mapelnya --}}
                                <button type="button"
                                    class="btn-edit bg-white border border-green-600 px-2 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1"
                                    data-id="{{ $guru->id }}"
                                    data-mapel-id="{{ $guru->mapel_id ?? '' }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                {{-- Form Hapus --}}
                                {{-- Menggunakan form terpisah untuk tombol hapus agar bisa menggunakan metode DELETE --}}
                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');"> {{-- Konfirmasi penghapusan --}}
                                    @csrf {{-- Token CSRF untuk keamanan --}}
                                    @method('DELETE') {{-- Spoofing metode HTTP menjadi DELETE --}}
                                    <button type="submit"
                                        class="bg-white border border-red-500 text-red-600 px-3 py-1 rounded text-sm hover:bg-red-100 flex items-center gap-1 mx-auto">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- Pesan jika tidak ada data guru --}}
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">Tidak ada data guru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Tautan Paginasi --}}
        <div class="mt-4">
            {{ $dataGuru->withQueryString()->links() }} {{-- Menampilkan tautan paginasi, mempertahankan query string --}}
        </div>
    </div>
</div>

@include("admin.modal_profile_guru") {{-- Menyertakan modal edit guru --}}

@endsection

@section('scripts') {{-- Memulai bagian skrip JavaScript --}}
<script>
    // Menunggu DOM sepenuhnya dimuat sebelum menjalankan skrip
    document.addEventListener('DOMContentLoaded', function () {
        // Mendapatkan semua tombol dengan kelas 'btn-edit'
        document.querySelectorAll('.btn-edit').forEach(button => {
            // Menambahkan event listener 'click' ke setiap tombol edit
            button.addEventListener('click', function () {
                // Mengambil ID guru dan ID mapel dari atribut data tombol
                const guruId = this.dataset.id;
                const mapelId = this.dataset.mapelId;

                // Mendapatkan elemen-elemen modal
                const idInput = document.getElementById('editGuruId');
                const selectMapel = document.getElementById('editMapel');
                const form = document.getElementById('editGuruForm');
                const modal = document.getElementById('modalEditGuru');

                // Mengisi input hidden 'editGuruId' dengan ID guru
                if (idInput) idInput.value = guruId;

                // Mengatur opsi terpilih di dropdown mata pelajaran
                if (selectMapel) {
                    Array.from(selectMapel.options).forEach(option => {
                        // Memilih opsi jika nilainya cocok dengan mapelId guru
                        option.selected = (option.value == mapelId);
                    });
                }

                // Mengatur action URL form untuk mengirim data ke route yang benar
                // Contoh: /admin/guru/123/atur-mapel
                if (form) form.setAttribute('action', `/admin/guru/${guruId}/atur-mapel`);

                // Menampilkan modal dengan menghapus kelas 'hidden'
                if (modal) modal.classList.remove('hidden');
            });
        });
    });

    // Fungsi untuk menutup modal (dipanggil dari tombol silang di modal)
    function closeEditModal() {
        const modal = document.getElementById('modalEditGuru');
        if (modal) modal.classList.add('hidden'); // Menambahkan kelas 'hidden' untuk menyembunyikan modal
    }
</script>
@endsection {{-- Mengakhiri bagian skrip --}}
