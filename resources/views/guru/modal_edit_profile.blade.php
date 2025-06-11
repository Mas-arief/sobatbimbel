{{-- resources/views/guru/modal_edit_profile.blade.php --}}

<div id="editProfileModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editProfileModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>

            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Edit Profil Guru</h3>

                {{-- Form untuk update profil --}}
                <form id="editProfileForm" class="space-y-6" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Penting: Gunakan method PUT/PATCH untuk update --}}

                    {{-- Tampilkan semua error validasi di atas form jika ada (jika ini kembali dari submit dengan error) --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">Oops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Input Nama --}}
                    <div>
                        <label for="editNama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="editNama"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('name') border-red-500 @enderror"
                               value="{{ old('name', $user->name ?? '') }}" required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Username --}}
                    <div>
                        <label for="editUsername" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <input type="text" name="username" id="editUsername"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('username') border-red-500 @enderror"
                               value="{{ old('username', $user->username ?? '') }}" required>
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Alamat --}}
                    <div>
                        <label for="editAlamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                        <textarea name="alamat" id="editAlamat" rows="4"
                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('alamat') border-red-500 @enderror"
                                  placeholder="Masukkan alamat Anda">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Jenis Kelamin (menggunakan Select, bukan radio seperti sebelumnya) --}}
                    <div>
                        <label for="editJenisKelamin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                        <select id="editJenisKelamin" name="jenis_kelamin"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('jenis_kelamin') border-red-500 @enderror">
                            <option value="">Pilih Jenis Kelamin</option> {{-- Opsi default --}}
                            <option value="Laki-laki" {{ (old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ (old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Telepon --}}
                    <div>
                        <label for="editTelepon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telepon</label>
                        <input type="text" name="telepon" id="editTelepon"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('telepon') border-red-500 @enderror"
                               value="{{ old('telepon', $user->telepon ?? '') }}">
                        @error('telepon')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input Email --}}
                    <div>
                        <label for="editEmail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="editEmail"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('email') border-red-500 @enderror"
                               value="{{ old('email', $user->email ?? '') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Guru Mata Pelajaran (Read-only) --}}
                    <div>
                        <label for="editMapel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Guru Mata Pelajaran</label>
                        <input type="text" id="editMapel"
                               class="bg-gray-100 border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed"
                               value="{{ $user->mapel ?? '' }}" readonly>
                        {{-- Tidak perlu name karena tidak akan dikirim saat update oleh guru --}}
                    </div>

                    <button type="submit" class="w-full text-white bg-[#1F1AA1] hover:bg-[#1a178f] focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editProfileModalButton = document.querySelector('[data-modal-toggle="editProfileModal"]');
        const editProfileForm = document.getElementById('editProfileForm');

        if (editProfileModalButton && editProfileForm) {
            editProfileModalButton.addEventListener('click', function() {
                // Mengisi data ke dalam form modal
                document.getElementById('editNama').value = "{{ $user->name ?? '' }}";
                document.getElementById('editUsername').value = "{{ $user->username ?? '' }}";
                document.getElementById('editAlamat').value = "{{ $user->alamat ?? '' }}";
                document.getElementById('editTelepon').value = "{{ $user->telepon ?? '' }}";
                document.getElementById('editEmail').value = "{{ $user->email ?? '' }}";
                document.getElementById('editMapel').value = "{{ $user->mapel ?? '' }}"; // Set read-only mapel

                // Mengisi nilai untuk dropdown Jenis Kelamin
                const jenisKelamin = "{{ $user->jenis_kelamin ?? '' }}";
                const selectJenisKelamin = document.getElementById('editJenisKelamin');
                if (selectJenisKelamin) {
                    selectJenisKelamin.value = jenisKelamin;
                }

                // Jika ada error validasi dari request sebelumnya, modal akan otomatis terbuka.
                // Logika ini memastikan modal terbuka jika ada error
                @if ($errors->any())
                    const modalElement = document.getElementById('editProfileModal');
                    if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
                        const modal = new Flowbite.Modal(modalElement);
                        modal.show();
                    } else {
                        modalElement.classList.remove('hidden');
                        modalElement.setAttribute('aria-hidden', 'false');
                    }
                @endif
            });
        }

        // Ini penting untuk memastikan modal terbuka kembali jika ada error validasi setelah submit
        @if ($errors->any())
            const modalElement = document.getElementById('editProfileModal');
            if (typeof Flowbite !== 'undefined' && Flowbite.Modal) {
                const modal = new Flowbite.Modal(modalElement);
                modal.show();
            } else {
                modalElement.classList.remove('hidden');
                modalElement.setAttribute('aria-hidden', 'false');
            }
        @endif
    });
</script>
