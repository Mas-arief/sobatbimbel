@extends('layouts.app')

@section('content')

    <style>
        @keyframes floatingFade {
            0% {
                transform: translateX(0px);
                opacity: 0;
            }

            25% {
                opacity: 0.3;
            }

            50% {
                transform: translateX(0px);
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
        <img src="{{ asset('images/6.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">Manajemen Profil Guru</h1>

    <div class="flex justify-center">
        <div class="w-full max-w-6xl overflow-x-auto rounded-md shadow-md">
            @if(session('success'))
                <div class="bg-green-500 text-white p-2 rounded text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="min-w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
                <thead class="bg-gray-300 text-center font-semibold">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">JK</th>
                        <th class="px-4 py-2 border">Alamat</th>
                        <th class="px-4 py-2 border">Guru Mapel</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Telepon</th>
                        <th class="px-4 py-2 border rounded-tr-md">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($dataGuru as $guru)
                    <tr class="border border-gray-300">
                        <td class="px-4 py-2 border">{{ $guru->id }}</td>
                        <td class="px-4 py-2 border font-semibold">{{ $guru->name ?? $guru->username }}</td>
                        <td class="px-4 py-2 border">{{ $guru->jenis_kelamin ?: '-' }}</td>
                        <td class="px-4 py-2 border">{{ $guru->alamat ?: '-' }}</td>
                        {{-- Mengakses nama mapel melalui relasi --}}
                        <td class="px-4 py-2 border">{{ $guru->mapel->nama ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $guru->email }}</td>
                        <td class="px-4 py-2 border">{{ $guru->telepon ?: '-' }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex justify-center gap-2">
                                <button
                                    type="button"
                                    class="btn-edit bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1"
                                    data-id="{{ $guru->id }}"
                                    data-nama="{{ $guru->name ?? $guru->username }}"
                                    data-jenis-kelamin="{{ $guru->jenis_kelamin }}"
                                    data-alamat="{{ $guru->alamat }}"
                                    data-mapel-id="{{ $guru->mapel_id ?? '' }}" {{-- Ambil mapel_id dari kolom DB --}}
                                    data-email="{{ $guru->email }}"
                                    data-telepon="{{ $guru->telepon }}">
                                    <i class="fas fa-edit"></i> Edit Mapel
                                </button>

                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
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
</div>

{{-- Sertakan modal edit mata pelajaran guru di sini --}}
@include("admin.modal_profile_guru") {{-- Ubah nama file include jika Anda menggunakan nama lain --}}

@endsection

@section('scripts')
<script>
    // Fungsi untuk menutup modal
    function closeEditModal() {
        const modal = document.getElementById('modalEditGuru');
        if (modal) {
            modal.classList.add('hidden');
            // Jika Anda menggunakan Flowbite dan menginisialisasi modal,
            // Anda mungkin perlu memanggil hide() di instance Flowbite Modal
            // Contoh: const flowbiteModal = new Flowbite.Modal(modal); flowbiteModal.hide();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const guruId = this.dataset.id;
                const mapelId = this.dataset.mapelId; // Menggunakan data-mapel-id

                // Debugging: Log nilai untuk memastikan ada
                console.log('Guru ID:', guruId);
                console.log('Mapel ID (from data-mapel-id):', mapelId);

                const editGuruIdInput = document.getElementById('editGuruId');
                if (editGuruIdInput) {
                    editGuruIdInput.value = guruId;
                } else {
                    console.error("Elemen 'editGuruId' tidak ditemukan!");
                }

                const selectEditMapel = document.getElementById('editMapel');
                if (selectEditMapel) {
                    // Setel opsi yang terpilih di dropdown
                    // Pastikan mapelId tidak null atau undefined saat mengatur selected
                    if (mapelId) {
                        Array.from(selectEditMapel.options).forEach(option => {
                            option.selected = (option.value === mapelId);
                        });
                    } else {
                        // Jika mapelId null, set default ke opsi pertama atau biarkan tidak terpilih
                        selectEditMapel.selectedIndex = 0; // Pilih opsi pertama jika mapelId null
                    }
                } else {
                    console.error("Elemen 'editMapel' tidak ditemukan!");
                }

                const modal = document.getElementById('modalEditGuru');
                if (modal) {
                    modal.classList.remove('hidden');
                    // Jika Anda menggunakan Flowbite, inisialisasi dan tampilkan modalnya
                    // if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
                    //     const flowbiteModal = new Flowbite.Modal(modal);
                    //     flowbiteModal.show();
                    // }
                } else {
                    console.error("Elemen 'modalEditGuru' tidak ditemukan!");
                }

                const form = document.getElementById('editGuruForm');
                if (form) {
                    // Set action form untuk PUT request ke route atur-mapel
                    form.setAttribute('action', `/admin/guru/${guruId}/atur-mapel`);
                } else {
                    console.error("Elemen 'editGuruForm' tidak ditemukan!");
                }
            });
        });

        // Event listener untuk submit form Edit
        // Ini akan mengirimkan form secara normal ke endpoint yang disetel di action form
        // Anda tidak perlu lagi melakukan event.preventDefault() dan AJAX secara manual
        // jika Anda ingin form disubmit seperti biasa.
        // Jika Anda ingin AJAX, maka Anda harus membatalkan submit default dan menggunakan fetch/axios.
        // Karena form Anda memiliki @csrf dan @method('PUT'), Laravel akan menanganinya sebagai PUT request.
        const editGuruForm = document.getElementById('editGuruForm');
        if (editGuruForm) {
            editGuruForm.addEventListener('submit', function(event) {
                // Opsional: Untuk debugging, Anda bisa log data sebelum submit
                console.log("Form sedang disubmit untuk guru ID:", this.getAttribute('data-id'));
                // Jika Anda ingin reload halaman setelah sukses (setelah redirect dari controller)
                // location.reload(); // Tidak perlu di sini, controller akan me-redirect
            });
        }
    });
</script>
@endsection
