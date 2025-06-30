@extends('layouts.navbar')

@section('content')

<style>
    @keyframes floatingFade {
        0% { transform: translateX(0); opacity: 0; }
        25% { opacity: 1.5; }
        50% { transform: translateX(0); opacity: 4; }
        75% { opacity: 1.5; }
        100% { transform: translateX(0); opacity: 0; }
    }

    .animate-floating-fade {
        animation: floatingFade 15s ease-in-out infinite;
    }
</style>

{{-- Background --}}
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
    <img src="{{ asset('images/9.png') }}" alt="Background"
        class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
</div>

<div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">

    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-8 text-center rounded-lg py-2">
        VERIFIKASI
    </h1>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-md text-center">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-md text-center">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Tombol kembali --}}
    <div class="max-w-5xl mx-auto mt-6 flex justify-between items-center">
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
            <i class="fas fa-arrow-left mr-3"></i> Kembali ke Dashboard
        </a>

        {{-- Tombol Verifikasi Semua --}}
        <form method="POST" action="{{ route('admin.verifikasi.semua') }}"
              onsubmit="return confirm('Yakin ingin memverifikasi semua guru dan siswa?');">
            @csrf
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-check-double mr-2"></i> Verifikasi Semua
            </button>
        </form>
    </div>

    {{-- Daftar Guru --}}
    <div class="max-w-5xl mx-auto mt-8">
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Daftar Guru Menunggu Verifikasi</h4>
        <div class="w-full overflow-x-auto shadow-lg rounded-xl border border-gray-300 bg-white duration-300 ease-in-out transform hover:scale-105">
            @include('admin.partials.verifikasi-table', ['users' => $guru])
        </div>
    </div>

    {{-- Daftar Siswa --}}
    <div class="max-w-5xl mx-auto mt-6">
        <h4 class="text-xl font-semibold text-gray-700 mb-4">Daftar Siswa Menunggu Verifikasi</h4>
        <div class="w-full overflow-x-auto shadow-lg rounded-xl border border-gray-300 bg-white duration-300 ease-in-out transform hover:scale-105">
            @include('admin.partials.verifikasi-table', ['users' => $siswa])
        </div>
    </div>

    {{-- Modal pesan --}}
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
    const messageModal = document.getElementById('messageModal');
    const modalMessage = document.getElementById('modalMessage');
    const closeModalButton = document.getElementById('closeModal');

    function showMessageModal(message) {
        modalMessage.textContent = message;
        messageModal.classList.remove('hidden');
    }

    closeModalButton.addEventListener('click', () => {
        messageModal.classList.add('hidden');
    });

    async function handleVerification(userId, actionType, rowElement) {
        rowElement.querySelectorAll('.action-btn').forEach(btn => {
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        });

        const apiUrl = `{{ route('admin.verify-user', ['userId' => ':userId']) }}`.replace(':userId', userId);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ action: actionType })
            });

            const result = await response.json();

            if (response.ok) {
                showMessageModal(result.message);
                rowElement.remove();
            } else {
                showMessageModal(`Error: ${result.message || 'Terjadi kesalahan.'}`);
                rowElement.querySelectorAll('.action-btn').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            }
        } catch (error) {
            console.error('Error:', error);
            showMessageModal(`Terjadi kesalahan jaringan: ${error.message}`);
            rowElement.querySelectorAll('.action-btn').forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        }
    }

    document.addEventListener('click', (event) => {
        const button = event.target.closest('.action-btn');
        if (button) {
            const row = button.closest('tr');
            const userId = row.getAttribute('data-user-id');
            const actionType = button.classList.contains('accept-btn') ? 'accept' :
                               button.classList.contains('reject-btn') ? 'reject' : '';

            if (userId && actionType) {
                handleVerification(userId, actionType, row);
            }
        }
    });
</script>

@endsection
