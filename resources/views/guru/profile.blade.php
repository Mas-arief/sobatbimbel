@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')

    <style>
        @keyframes floatingFade {
            0% {
                transform: translateX(30px);
                opacity: 0;
            }

            25% {
                opacity: 0.3;
            }

            50% {
                transform: translateX(-10px);
                opacity: 0.6;
            }

            75% {
                opacity: 0.3;
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

    <div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-1">Profil Guru</h1>

    <div class="flex justify-center">
        {{-- Form ini hanya untuk menampilkan data. Tombol di bawah akan membuka modal edit. --}}
        <form class="w-full max-w-3xl space-y-2">
            @if(session('success'))
                <div class="bg-green-500 text-white p-2 rounded text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-black mb-1">ID</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->custom_identifier  ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Nama</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->name ?? 'N/A' }}
                </div>
            </div>

            {{-- Alamat Lengkap --}}
            <div>
                <label class="block text-sm font-medium text-black mb-1">Alamat</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->alamat ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Guru Mata Pelajaran</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->mapel->nama ?? 'N/A' }} {{-- Akses 'nama' dari relasi mapel--}}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Jenis Kelamin</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->jenis_kelamin ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Telepon</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->telepon ?? 'N/A' }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-black mb-1">Email</label>
                <div class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-700 text-sm">
                    {{ $user->email ?? 'N/A' }}
                </div>
            </div>

            <div class="flex justify-center pt-3">
                <button type="button"
                        data-modal-target="editProfileModal" data-modal-toggle="editProfileModal"
                        class="text-white bg-[#1F1AA1] hover:bg-[#1a178f] focus:ring-2 focus:outline-none focus:ring-[#1F1AA1]/50 font-medium rounded-xl text-sm px-4 py-2 sm:mt-2">
                    Perbarui Profil
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Sertakan modal edit profil lengkap di sini --}}
@include('guru.modal_edit_profile')
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Script for admin.profile_guru is running.'); // Debugging log

        const editButton = document.querySelector('[data-modal-target="editProfileModal"]');
        const modal = document.getElementById('editProfileModal'); // ID modal dari Flowbite
        const form = document.getElementById('editProfileForm'); // Asumsikan form di dalam modal memiliki ID ini

        if (editButton && modal && form) {
            editButton.addEventListener('click', function() {
                console.log('Perbarui Profil button clicked!'); // Debugging log

                // Ambil data dari variabel $user yang diteruskan dari Laravel Blade
                // Pastikan variabel $user tersedia di view ini
                const userId = "{{ $user->id ?? '' }}";
                const userName = "{{ $user->name ?? '' }}";
                const userAlamat = "{{ $user->alamat ?? '' }}";
                const userJenisKelamin = "{{ $user->jenis_kelamin ?? '' }}";
                const userTelepon = "{{ $user->telepon ?? '' }}";
                const userEmail = "{{ $user->email ?? '' }}";
                const userMapelId = "{{ $user->mapel_id ?? '' }}"; // Ambil mapel_id dari kolom DB

                // Mengisi input di dalam modal
                const inputId = document.getElementById('editUserId');
                if (inputId) {
                    inputId.value = userId;
                } else {
                    console.error("Elemen 'editUserId' tidak ditemukan di modal!");
                }

                const inputName = document.getElementById('editName');
                if (inputName) {
                    inputName.value = userName;
                } else {
                    console.error("Elemen 'editName' tidak ditemukan di modal!");
                }

                const inputAlamat = document.getElementById('editAlamat');
                if (inputAlamat) {
                    inputAlamat.value = userAlamat;
                } else {
                    console.error("Elemen 'editAlamat' tidak ditemukan di modal!");
                }

                const selectMapel = document.getElementById('editMapel');
                if (selectMapel) {
                    if (userMapelId) {
                        Array.from(selectMapel.options).forEach(option => {
                            option.selected = (option.value == userMapelId);
                        });
                    } else {
                        selectMapel.selectedIndex = 0; // Pilih opsi pertama jika tidak ada mapel
                    }
                } else {
                    console.error("Elemen 'editMapel' tidak ditemukan di modal!");
                }

                const radioJKelaminL = document.getElementById('editJenisKelaminL');
                const radioJKelaminP = document.getElementById('editJenisKelaminP');

                if (radioJKelaminL && radioJKelaminP) {
                    if (userJenisKelamin === 'Laki-laki') {
                        radioJKelaminL.checked = true;
                    } else if (userJenisKelamin === 'Perempuan') {
                        radioJKelaminP.checked = true;
                    }
                } else {
                    console.error("Elemen radio button Jenis Kelamin tidak ditemukan di modal!");
                }

                const inputTelepon = document.getElementById('editTelepon');
                if (inputTelepon) {
                    inputTelepon.value = userTelepon;
                } else {
                    console.error("Elemen 'editTelepon' tidak ditemukan di modal!");
                }

                const inputEmail = document.getElementById('editEmail');
                if (inputEmail) {
                    inputEmail.value = userEmail;
                } else {
                    console.error("Elemen 'editEmail' tidak ditemukan di modal!");
                }

                // Set action form untuk PUT request ke rute update profil guru
                // Asumsi rute update profil guru adalah 'guru.update_profile'
                // Pastikan rute ini benar di web.php Anda, contoh: Route::put('/guru/profile/{id}', [GuruController::class, 'updateProfile'])->name('guru.update_profile');
                form.setAttribute('action', `/guru/profile/${userId}`);
            });
        } else {
            console.error("Tombol edit, modal, atau form tidak ditemukan.");
        }
    });
</script>
@endsection
