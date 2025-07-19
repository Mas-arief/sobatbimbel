@extends('layouts.navbar') {{-- Mengextends layout 'navbar' --}}

@section('content') {{-- Memulai bagian konten --}}

<style>
    /* Keyframes untuk animasi 'floatingFade' */
    @keyframes floatingFade {
        0% { transform: translateX(0); opacity: 0; } /* Posisi awal dan opasitas 0 */
        25% { opacity: 1.5; } /* Opasitas lebih tinggi dari 1 untuk efek 'terang' */
        50% { transform: translateX(0); opacity: 4; } /* Opasitas sangat tinggi untuk efek terang maksimal */
        75% { opacity: 1.5; } /* Kembali ke opasitas lebih tinggi */
        100% { transform: translateX(0); opacity: 0; } /* Kembali ke opasitas 0 */
    }

    /* Menerapkan animasi ke elemen dengan kelas 'animate-floating-fade' */
    .animate-floating-fade {
        animation: floatingFade 15s ease-in-out infinite; /* Durasi 15s, easing ease-in-out, berulang tak terbatas */
    }
</style>

{{-- Background --}}
{{-- Div ini berfungsi sebagai kontainer untuk gambar latar belakang animasi --}}
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
    {{-- Gambar latar belakang --}}
    <img src="{{ asset('images/9.png') }}" alt="Background"
        class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
</div>

{{-- Konten utama halaman --}}
<div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">

    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-8 text-center rounded-lg py-2">
        VERIFIKASI
    </h1>

    {{-- Notifikasi sukses atau error (jika ada) --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-md text-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-md text-center">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Tombol kembali dan Verifikasi Semua --}}
    <div class="max-w-5xl mx-auto mt-6 flex justify-between items-center">
        {{-- Tombol Kembali ke Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
            <i class="fas fa-arrow-left mr-3"></i> Kembali ke Dashboard
        </a>

        {{-- Tombol Verifikasi Semua --}}
        {{-- Menggunakan form untuk mengirim permintaan POST ke route 'admin.verifikasi.semua' --}}
        {{-- Ada konfirmasi JavaScript sebelum submit --}}
        <form method="POST" action="{{ route('admin.verifikasi.semua') }}"
              onsubmit="return confirm('Yakin ingin memverifikasi semua guru dan siswa?');">
            @csrf {{-- Token CSRF untuk keamanan --}}
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-check-double mr-2"></i> Verifikasi Semua
            </button>
        </form>
    </div>

    {{-- Daftar Guru Menunggu Verifikasi --}}
    <div class="max-w-5xl mx-auto mt-8">
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Daftar Guru Menunggu Verifikasi</h4>
        {{-- Menyertakan partial Blade 'verifikasi-table' dan meneruskan koleksi $guru ke dalamnya --}}
        <div class="w-full overflow-x-auto shadow-lg rounded-xl border border-gray-300 bg-white duration-300 ease-in-out transform hover:scale-105">
            @include('admin.partials.verifikasi-table', ['users' => $guru])
        </div>
    </div>

    {{-- Daftar Siswa Menunggu Verifikasi --}}
    <div class="max-w-5xl mx-auto mt-6">
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Daftar Siswa Menunggu Verifikasi</h4>
        {{-- Menyertakan partial Blade 'verifikasi-table' dan meneruskan koleksi $siswa ke dalamnya --}}
        <div class="w-full overflow-x-auto shadow-lg rounded-xl border border-gray-300 bg-white duration-300 ease-in-out transform hover:scale-105">
            @include('admin.partials.verifikasi-table', ['users' => $siswa])
        </div>
    </div>

    {{-- Modal pesan (digunakan oleh JavaScript untuk menampilkan notifikasi) --}}
    <div id="messageModal"
         class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-sm w-full text-center border border-gray-300">
            <p id="modalMessage" class="text-lg font-semibold text-gray-800 mb-6"></p>
            <button id="closeModal"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Script verifikasi --}}
<script>
    // Mendapatkan referensi ke elemen modal dan tombolnya
    const messageModal = document.getElementById('messageModal');
    const modalMessage = document.getElementById('modalMessage');
    const closeModalButton = document.getElementById('closeModal');

    // Fungsi untuk menampilkan modal pesan
    function showMessageModal(message) {
        modalMessage.textContent = message; // Mengatur teks pesan
        messageModal.classList.remove('hidden'); // Menghapus kelas 'hidden' untuk menampilkan modal
    }

    // Event listener untuk tombol tutup modal
    closeModalButton.addEventListener('click', () => {
        messageModal.classList.add('hidden'); // Menambahkan kelas 'hidden' untuk menyembunyikan modal
    });

    /**
     * Fungsi asinkron untuk menangani verifikasi pengguna (terima/tolak).
     * Mengirim permintaan AJAX ke backend.
     * @param {string} userId ID pengguna yang akan diverifikasi.
     * @param {string} actionType Tipe aksi ('accept' atau 'reject').
     * @param {HTMLElement} rowElement Elemen baris tabel (<tr>) yang terkait dengan pengguna.
     */
    async function handleVerification(userId, actionType, rowElement) {
        // Menonaktifkan tombol aksi sementara permintaan sedang diproses
        rowElement.querySelectorAll('.action-btn').forEach(btn => {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        });

        // Membangun URL API dengan ID pengguna yang dinamis
        const apiUrl = `{{ route('admin.verify-user', ['userId' => ':userId']) }}`.replace(':userId', userId);
        // Mengambil token CSRF dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            // Mengirim permintaan fetch (AJAX) ke backend
            const response = await fetch(apiUrl, {
                method: 'POST', // Menggunakan metode POST
                headers: {
                    'Content-Type': 'application/json', // Mengirim data dalam format JSON
                    'X-CSRF-TOKEN': csrfToken // Menyertakan token CSRF untuk keamanan
                },
                body: JSON.stringify({ action: actionType }) // Mengirim tipe aksi dalam body JSON
            });

            const result = await response.json(); // Mengurai respons JSON

            if (response.ok) { // Jika respons berhasil (status 2xx)
                showMessageModal(result.message); // Tampilkan pesan sukses
                rowElement.remove(); // Hapus baris pengguna dari tabel
            } else { // Jika respons gagal (status non-2xx)
                showMessageModal(`Error: ${result.message || 'Terjadi kesalahan.'}`); // Tampilkan pesan error
                // Aktifkan kembali tombol aksi jika terjadi kesalahan
                rowElement.querySelectorAll('.action-btn').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            }
        } catch (error) { // Menangani kesalahan jaringan atau lainnya
            console.error('Error:', error);
            showMessageModal(`Terjadi kesalahan jaringan: ${error.message}`);
            // Aktifkan kembali tombol aksi jika terjadi kesalahan
            rowElement.querySelectorAll('.action-btn').forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }
    }

    // Event listener global untuk menangani klik pada tombol verifikasi
    document.addEventListener('click', (event) => {
        // Mencari tombol terdekat dengan kelas 'action-btn' dari elemen yang diklik
        const button = event.target.closest('.action-btn');
        if (button) {
            // Mendapatkan elemen baris tabel (<tr>) terdekat
            const row = button.closest('tr');
            // Mengambil ID pengguna dari atribut 'data-user-id' pada baris
            const userId = row.getAttribute('data-user-id');
            // Menentukan tipe aksi berdasarkan kelas tombol
            const actionType = button.classList.contains('accept-btn') ? 'accept' :
                               button.classList.contains('reject-btn') ? 'reject' : '';

            // Jika ID pengguna dan tipe aksi valid, panggil fungsi handleVerification
            if (userId && actionType) {
                handleVerification(userId, actionType, row);
            }
        }
    });
</script>

@endsection {{-- Mengakhiri bagian konten --}}
