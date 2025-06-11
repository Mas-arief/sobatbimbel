@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 mt-3">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-5 text-center">Manajemen Profil Siswa</h1>

    <div class="mb-4">
        {{-- Tombol Kembali ke Dashboard Admin --}}
        <a href="{{ route('admin.dashboard') }}">
            <button class="bg-blue-800 hover:bg-blue-700 text-white font-semibold py-1.5 px-4 rounded shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </button>
        </a>
    </div>

    <div class="overflow-x-auto rounded-md shadow-md max-w-5xl mx-auto mt-4">
        <table class="w-full text-sm text-left text-black border border-gray-300 bg-gray-200">
            <thead class="bg-gray-300 text-center font-semibold">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Jenis Kelamin</th>
                    <th class="px-4 py-2 border">Alamat</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Telepon</th>
                    <th class="px-4 py-2 border">Aksi</th> {{-- Tetap ada kolom aksi untuk tombol hapus --}}
                </tr>
            </thead>
            <tbody class="text-center">
                {{-- Pastikan $dataSiswa diteruskan dari controller --}}
                @forelse ($dataSiswa as $siswa)
                    <tr class="border border-gray-300">
                        <td class="px-4 py-2 border">{{ $siswa->id }}</td>
                        <td class="px-4 py-2 border font-semibold">{{ $siswa->name ?: $siswa->username }}</td>
                        <td class="px-4 py-2 border">{{ $siswa->jenis_kelamin ?: '-' }}</td>
                        <td class="px-4 py-2 border">{{ $siswa->alamat ?: '-' }}</td>
                        <td class="px-4 py-2 border">{{ $siswa->email }}</td>
                        <td class="px-4 py-2 border">{{ $siswa->telepon ?: '-' }}</td>
                        <td class="px-4 py-2 border flex justify-center items-center gap-2">
                            {{-- Tombol Hapus --}}
                            {{-- Anda bisa menambahkan modal konfirmasi untuk hapus jika diinginkan --}}
                                <button type="submit" class="bg-white border border-gray-600 px-3 py-1 rounded text-sm hover:bg-gray-100 flex items-center gap-1 text-red-600">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Meskipun tidak ada tombol edit, Anda tetap bisa me-include modalnya
         jika sewaktu-waktu ingin menggunakannya untuk tujuan lain (misalnya, via JavaScript langsung)
         atau untuk jaga-jaga jika tombol edit akan diaktifkan kembali.
         Namun, jika memang tidak ada edit sama sekali, modal ini bisa dihapus.
         Untuk saat ini, saya akan tetap sertakan tapi dengan penyesuaian fungsi JS-nya.
    --}}
    @include('admin.modal_profile_siswa')
</div>

{{-- Script JavaScript untuk modal siswa, disesuaikan tanpa fungsi openEditModal yang di-trigger tombol --}}
<script>
    // Fungsi closeEditModalSiswa (tetap ada untuk menutup modal jika dibuka secara programatis)
    function closeEditModalSiswa() {
        const modal = document.getElementById('editSiswaModal');
        if (modal) {
            if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
                const flowbiteModal = new Flowbite.Modal(modal);
                flowbiteModal.hide();
            } else {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }
        }
    }

    // Event listener untuk submit form Edit Siswa (jika modal dibuka secara programatis)
    document.addEventListener('DOMContentLoaded', function() {
        const editSiswaForm = document.getElementById('editSiswaForm');
        if (editSiswaForm) {
            editSiswaForm.addEventListener('submit', function(event) {
                // event.preventDefault(); // Uncomment ini jika Anda ingin menggunakan AJAX
                // Log data atau kirim via AJAX seperti di contoh sebelumnya
                console.log('Form Siswa disubmit. Data:', new FormData(this));
                // Jika tidak pakai AJAX, form akan disubmit dan halaman refresh
            });
        }

        // Ini penting untuk memastikan modal terbuka kembali jika ada error validasi setelah submit
        // Jika Anda tidak menampilkan tombol edit, Anda perlu cara lain untuk "membuka" modal ini
        // Misalnya, jika admin mencoba melakukan update via POST dan ada error,
        // controller bisa me-flash session untuk membuka modal yang relevan.
        // Contoh: return back()->withErrors($validator)->withInput()->with('open_siswa_modal', true);
        @if ($errors->any() && session('open_siswa_modal'))
            const modalElement = document.getElementById('editSiswaModal');
            if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
                const modal = new Flowbite.Modal(modalElement);
                modal.show();
            } else {
                modalElement.classList.remove('hidden');
                modalElement.setAttribute('aria-hidden', 'false');
            }
            // Populate form if validation errors occur (requires $user in view)
            // You might need to pass the $user object back to the view on validation error
            // to re-populate the modal fields.
            // For example: `document.getElementById('editNamaSiswa').value = '{{ old('name') }}';`
            // Or, if you pass the $user object back to the view, you can use:
            // `openEditModalSiswa({{ json_encode(old()) }});` or `openEditModalSiswa({{ $user->toJson() }});`
            // You need to decide how to re-populate the form with old input/user data after validation error.
        @endif
    });
</script>
@endsection
