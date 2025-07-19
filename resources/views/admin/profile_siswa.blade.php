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

{{-- Background animasi --}}
{{-- Div ini berfungsi sebagai kontainer untuk gambar latar belakang animasi --}}
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
    {{-- Gambar latar belakang --}}
    <img src="{{ asset('images/6.png') }}" alt="Background"
        class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
</div>

{{-- Konten utama halaman --}}
<div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 text-center mb-6">Manajemen Profil Siswa</h1>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('admin.profile_siswa') }}" class="mb-4 flex justify-center">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}" {{-- Menjaga nilai pencarian sebelumnya --}}
            placeholder="Cari berdasarkan ID atau Nama..."
            class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-400"
        >
        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-700"
        >
            Cari
        </button>
    </form>

    {{-- Pesan sukses / error (jika ada) --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 rounded text-sm mb-4 text-center w-full max-w-2xl mx-auto">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-2 rounded text-sm mb-4 text-center w-full max-w-2xl mx-auto">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Data Siswa --}}
    <div class="overflow-x-auto rounded-md shadow-md max-w-5xl mx-auto">
        <table class="w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
            {{-- Header Tabel --}}
            <thead class="bg-gray-300 text-center font-semibold">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Jenis Kelamin</th>
                    <th class="px-4 py-2 border">Alamat</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Telepon</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            {{-- Body Tabel --}}
            <tbody class="text-center">
                {{-- Loop melalui setiap siswa dalam koleksi $dataSiswa --}}
                {{-- @forelse digunakan untuk menampilkan pesan jika koleksi $dataSiswa kosong --}}
                @forelse ($dataSiswa as $siswa)
                    <tr class="border border-gray-300">
                        <td class="px-4 py-2 border break-words">{{ $siswa->custom_identifier }}</td> {{-- Menampilkan ID kustom --}}
                        <td class="px-4 py-2 border font-semibold">{{ $siswa->name ?: $siswa->username }}</td> {{-- Nama atau username --}}
                        <td class="px-4 py-2 border">{{ $siswa->jenis_kelamin ?: '-' }}</td> {{-- Jenis Kelamin atau '-' --}}
                        <td class="px-4 py-2 border break-words">{{ $siswa->alamat ?: '-' }}</td> {{-- Alamat atau '-' --}}
                        <td class="px-4 py-2 border break-words">{{ $siswa->email }}</td> {{-- Email --}}
                        <td class="px-4 py-2 border">{{ $siswa->telepon ?: '-' }}</td> {{-- Telepon atau '-' --}}
                        <td class="px-4 py-2 border flex justify-center items-center gap-2">
                            {{-- Tombol Hapus --}}
                            {{-- Menggunakan form terpisah untuk tombol hapus agar bisa menggunakan metode DELETE --}}
                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun siswa {{ $siswa->name ?: $siswa->username }}?');"> {{-- Konfirmasi penghapusan --}}
                                @csrf {{-- Token CSRF untuk keamanan --}}
                                @method('DELETE') {{-- Spoofing metode HTTP menjadi DELETE --}}
                                <button type="submit"
                                    class="bg-white border border-red-500 text-red-600 px-3 py-1 rounded text-sm hover:bg-red-100 flex items-center gap-1">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    {{-- Pesan jika tidak ada data siswa --}}
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginasi --}}
        <div class="mt-4 px-4">
            {{ $dataSiswa->withQueryString()->links() }} {{-- Menampilkan tautan paginasi, mempertahankan query string --}}
        </div>
    </div>
</div>

@endsection

@section('scripts')
{{-- Tambahkan script JavaScript jika dibutuhkan di sini --}}
@endsection
