{{-- resources/views/admin/modal_profile_guru.blade.php --}}

{{-- Div utama modal. Menggunakan Tailwind CSS untuk styling. --}}
{{-- 'fixed inset-0 z-50' membuat modal menutupi seluruh layar dan berada di atas elemen lain. --}}
{{-- 'hidden' akan diubah oleh JavaScript saat modal dibuka/ditutup. --}}
{{-- 'flex items-center justify-center' untuk memposisikan modal di tengah layar. --}}
<div id="modalEditGuru" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    {{-- Kontainer relatif untuk konten modal --}}
    <div class="relative w-full max-w-md max-h-full">
        {{-- Konten modal: latar belakang putih, sudut membulat, dan bayangan --}}
        <div class="relative bg-white rounded-lg shadow">
            {{-- Header modal --}}
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                {{-- Judul modal, dipusatkan --}}
                <h3 class="text-xl font-semibold text-center w-full text-black">EDIT MAPEL GURU</h3>
                {{-- Tombol untuk menutup modal --}}
                {{-- 'absolute top-4 right-4' memposisikan tombol di sudut kanan atas --}}
                {{-- 'onclick="closeEditModal()"' memanggil fungsi JavaScript untuk menutup modal --}}
                <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" onclick="closeEditModal()">
                    {{-- Ikon Font Awesome untuk tanda silang --}}
                    <i class="fas fa-times"></i>
                </button>
            </div>
            {{-- Body modal dengan form --}}
            <div class="p-6 space-y-4">
                {{-- Form untuk mengedit mata pelajaran guru --}}
                {{-- ID 'editGuruForm' digunakan oleh JavaScript untuk mengupdate action URL --}}
                <form id="editGuruForm" method="POST">
                    @csrf {{-- Direktif Blade untuk menyertakan token CSRF untuk keamanan --}}
                    @method('PUT') {{-- Direktif Blade untuk spoofing metode HTTP menjadi PUT (untuk update) --}}

                    {{-- Input hidden untuk menyimpan ID guru yang diedit --}}
                    {{-- Nilai ini akan diisi oleh JavaScript saat modal dibuka --}}
                    <input type="hidden" name="guru_id" id="editGuruId">

                    {{-- Label untuk dropdown pemilihan mata pelajaran --}}
                    <label for="editMapel" class="block text-sm font-medium text-black mb-1">Pilih Mata Pelajaran</label>
                    {{-- Dropdown untuk memilih mata pelajaran --}}
                    {{-- Nama 'mapel_id' akan dikirim ke controller --}}
                    {{-- ID 'editMapel' digunakan oleh JavaScript untuk mengatur nilai terpilih --}}
                    <select name="mapel_id" id="editMapel"
                        class="block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                        {{-- Loop untuk menampilkan setiap mata pelajaran dari $mapelList --}}
                        {{-- Pastikan $mapelList tersedia dari controller dan diteruskan ke view ini --}}
                        @foreach ($mapelList as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                        @endforeach
                    </select>

                    {{-- Tombol submit untuk menyimpan perubahan --}}
                    <button type="submit"
                        class="mt-4 w-full bg-indigo-900 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-semibold">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
