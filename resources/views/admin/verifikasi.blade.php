@extends('layouts.navbar')

@section('content')

    <style>
        @keyframes floatingFade {
            0% {
                transform: translateX(0px);
                opacity: 0;
            }

            25% {
                opacity: 1.5;
            }

            50% {
                transform: translateX(0px);
                opacity: 4;
            }

            75% {
                opacity: 1.5;
            }

            100% {
                transform: translateX(0px);
                opacity: 0;
            }
        }

        .animate-floating-fade {
            animation: floatingFade 15s ease-in-out infinite;
        }
    </style>

    <!-- background animasi -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/9.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div class="relative z-10 px-4 sm:px-6 lg:px-8 mt-3">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-500 mb-8 text-center rounded-lg py-2">VERIFIKASI</h1>

        {{-- Notifikasi (session messages from Laravel backend) --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-md text-center">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-md text-center">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="mt-6 flex justify-end max-w-5xl mx-auto">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2.5 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-arrow-left mr-3"></i>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Bagian Guru --}}
        <div class="max-w-5xl mx-auto">
            <h4 class="text-xl font-semibold text-gray-950 mb-4 text-left">Daftar Guru Menunggu Verifikasi</h4>
        </div>
        <div class="flex justify-center transition duration-300 ease-in-out transform hover:scale-105">
            <div class="w-full max-w-5xl overflow-x-auto shadow-lg rounded-xl border border-gray-300 bg-white">
                @include('admin.partials.verifikasi-table', ['users' => $guru])
            </div>
        </div>

        {{-- Bagian Siswa --}}
        <div class="max-w-5xl mx-auto">
            <h4 class="text-xl font-semibold text-gray-950 mt-6 mb-4 text-left">Daftar Siswa Menunggu Verifikasi</h4>
        </div>
        <div class="flex justify-center transition duration-300 ease-in-out transform hover:scale-105">
            <div class="w-full max-w-5xl overflow-x-auto shadow-lg rounded-xl border border-gray-300 bg-white">
                @include('admin.partials.verifikasi-table', ['users' => $siswa])
            </div>
        </div>

        <!-- Modal sederhana untuk pesan (bukan alert() atau window.confirm()) -->
        <!-- Modal ini ditempatkan secara global di luar parsial sehingga hanya ada satu contoh -->
        <div id="messageModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50 p-4">
            <div class="bg-white p-8 rounded-lg shadow-xl max-w-sm w-full text-center border border-gray-300">
                <p id="modalMessage" class="text-lg font-semibold text-gray-950 mb-6"></p>
                <button id="closeModal"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        // Get references to DOM elements for the modal
        const messageModal = document.getElementById('messageModal');
        const modalMessage = document.getElementById('modalMessage');
        const closeModalButton = document.getElementById('closeModal');

        /**
         * Displays a custom modal message to the user.
         * This replaces the use of `alert()` for better UX.
         * @param {string} message - The message to display.
         */
        function showMessageModal(message) {
            modalMessage.textContent = message;
            messageModal.classList.remove('hidden');
        }

        // Event listener to close the message modal when the 'Tutup' button is clicked
        closeModalButton.addEventListener('click', () => {
            messageModal.classList.add('hidden');
        });

        /**
         * Handles the verification action (accept or reject) for a specific user.
         * This function sends an AJAX request to the Laravel backend.
         * Using event delegation for efficiency and robustness with dynamic elements.
         * @param {string} userId - The ID of the user to verify.
         * @param {string} actionType - The action to perform: 'accept' or 'reject'.
         * @param {HTMLElement} rowElement - The table row element corresponding to the user.
         */
        async function handleVerification(userId, actionType, rowElement) {
            // Disable all action buttons in the current row to prevent multiple clicks
            rowElement.querySelectorAll('.action-btn').forEach(btn => {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed'); // Apply disabled styling
            });

            const apiUrl = `{{ route('admin.verify-user', ['userId' => ':userId']) }}`.replace(':userId', userId);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Get CSRF token

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST', // Or 'PUT', 'PATCH' as appropriate for your backend
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken // Essential for Laravel's CSRF protection
                    },
                    body: JSON.stringify({
                        action: actionType // Send the action type (accept or reject)
                    })
                });

                const result = await response.json(); // Parse the JSON response from the server

                if (response.ok) { // Check if the HTTP status is success (2xx)
                    showMessageModal(result.message); // Show success message from backend
                    // Upon successful verification, remove the row from the table
                    rowElement.remove();
                } else { // Handle HTTP errors (e.g., 404, 500, or validation errors from your Controller)
                    showMessageModal(`Error: ${result.message || 'Terjadi kesalahan saat memproses permintaan.'}`);
                    // Re-enable buttons if the action failed
                    rowElement.querySelectorAll('.action-btn').forEach(btn => {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    });
                }

            } catch (error) {
                console.error('Error during verification:', error);
                showMessageModal(`Terjadi kesalahan jaringan atau tak terduga: ${error.message}`);
                // Always re-enable buttons on error to allow user to retry
                rowElement.querySelectorAll('.action-btn').forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                });
            }
        }

        // Use event delegation for buttons. This attaches one listener to the document
        // and handles clicks on dynamically added/removed buttons.
        document.addEventListener('click', (event) => {
            // Check if the clicked element or its parent matches a button with 'action-btn' class
            const button = event.target.closest('.action-btn');
            if (button) {
                const row = button.closest('tr');
                if (row) {
                    const userId = row.getAttribute('data-user-id');
                    let actionType = '';
                    if (button.classList.contains('accept-btn')) {
                        actionType = 'accept';
                    } else if (button.classList.contains('reject-btn')) {
                        actionType = 'reject';
                    }

                    if (userId && actionType) {
                        handleVerification(userId, actionType, row);
                    }
                }
            }
        });
    </script>
@endsection