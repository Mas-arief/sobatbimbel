<!-- Modal untuk Edit Data Siswa -->
{{-- Div utama modal. Menggunakan Tailwind CSS untuk styling. --}}
{{-- 'fixed inset-0 z-50' membuat modal menutupi seluruh layar dan berada di atas elemen lain. --}}
{{-- 'hidden' akan diubah oleh JavaScript saat modal dibuka/ditutup. --}}
{{-- 'flex items-center justify-center' untuk memposisikan modal di tengah layar. --}}
<div id="modalEditSiswa" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    {{-- Kontainer relatif untuk konten modal --}}
    <div class="relative w-full max-w-md max-h-full">
        {{-- Konten modal: latar belakang putih, sudut membulat, dan bayangan --}}
        <div class="relative bg-white rounded-lg shadow">
            {{-- Header modal --}}
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                {{-- Judul modal, dipusatkan --}}
                <h3 class="text-xl font-semibold text-center w-full text-black">
                    EDIT PROFILE SISWA
                </h3>
                {{-- Tombol untuk menutup modal --}}
                {{-- 'absolute top-4 right-4' memposisikan tombol di sudut kanan atas --}}
                {{-- 'data-modal-hide="modalEditSiswa"' digunakan oleh Flowbite JS atau custom JS untuk menutup modal --}}
                <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" data-modal-hide="modalEditSiswa">
                    {{-- Ikon Font Awesome untuk tanda silang --}}
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {{-- Body modal dengan form --}}
            <div class="p-6 space-y-4">
                {{-- Form untuk mengedit data siswa. Perlu ditambahkan action dan method (POST/PUT) --}}
                {{-- Serta @csrf dan @method('PUT') jika menggunakan Laravel --}}
                <form>
                    {{-- Input untuk Nama Siswa --}}
                    <input type="text" id="namaSiswa" placeholder="Nama Siswa"
                        class="block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">

                    {{-- Kontainer untuk Tempat dan Tanggal Lahir --}}
                    <div class="flex gap-2 mt-2">
                        {{-- Input untuk Tempat Lahir --}}
                        <input type="text" id="tempatLahir" placeholder="Tempat Lahir"
                            class="w-1/2 bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                        {{-- Input untuk Tanggal Lahir --}}
                        <input type="date" id="tanggalLahir"
                            class="w-1/2 bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                    </div>

                    {{-- Pilihan Jenis Kelamin (Radio Buttons) --}}
                    <div class="mt-2 text-black">
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenisKelamin" value="L" class="mr-1"> Laki-laki
                        </label>
                        <label class="inline-flex items-center ml-4">
                            <input type="radio" name="jenisKelamin" value="P" class="mr-1"> Perempuan
                        </label>
                    </div>

                    {{-- Textarea untuk Alamat Domisili --}}
                    <textarea id="alamatDomisili" placeholder="Alamat Domisili"
                        class="mt-2 block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black resize-none" rows="2"></textarea>

                    {{-- Input untuk Nomor HP --}}
                    <input type="text" id="nohp" placeholder="No HP"
                        class="mt-2 block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                    {{-- Input untuk Email --}}
                    <input type="email" id="email" placeholder="Email"
                        class="mt-2 block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">

                    {{-- Tombol Simpan --}}
                    <button type="submit"
                        class="mt-4 w-24 mx-auto block bg-indigo-900 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-semibold">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
