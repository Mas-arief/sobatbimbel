<table class="min-w-full text-base text-gray-800">
    {{-- Bagian Header Tabel --}}
    <thead class="text-sm uppercase bg-gray-100 text-center font-semibold text-gray-700 ">
        <tr>
            {{-- Kolom ID Pengguna --}}
            <th class="px-6 py-3 border-b border-gray-200">ID</th>
            {{-- Kolom Nama Pengguna --}}
            <th class="px-6 py-3 border-b border-gray-200">Nama</th>
            {{-- Kolom Email Pengguna --}}
            <th class="px-6 py-3 border-b border-gray-200">Email</th>
            {{-- Kolom Aksi (Tombol Terima/Tolak) --}}
            <th class="px-6 py-3 border-b border-gray-200">Aksi</th>
        </tr>
    </thead>
    {{-- Bagian Body Tabel --}}
    <tbody class="divide-y divide-gray-200">
        {{-- Loop melalui setiap pengguna dalam koleksi $users --}}
        {{-- @forelse digunakan untuk menampilkan pesan jika koleksi $users kosong --}}
        @forelse ($users as $index => $user)
            {{-- Baris untuk setiap pengguna --}}
            <tr
                {{-- Menentukan warna latar belakang baris bergantian untuk keterbacaan yang lebih baik --}}
                class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100' }} text-center hover:bg-gray-200 transition-colors duration-200"
                {{-- Menyimpan ID pengguna sebagai atribut data untuk diakses oleh JavaScript --}}
                data-user-id="{{ $user->id }}">
                {{-- Menampilkan ID kustom pengguna jika ada, jika tidak, gunakan ID default --}}
                <td class="px-6 py-3 font-mono text-gray-700">
                    {{ $user->custom_identifier ?? $user->id }}
                </td>
                {{-- Menampilkan nama pengguna --}}
                <td class="px-6 py-3 font-semibold text-gray-900">
                    {{ $user->name }}
                </td>
                {{-- Menampilkan email pengguna --}}
                <td class="px-6 py-3 text-gray-600">
                    {{ $user->email }}
                </td>
                {{-- Kolom Aksi dengan tombol --}}
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="flex justify-center gap-2">
                        {{-- Tombol Terima --}}
                        {{-- Kelas 'action-btn' dan 'accept-btn' digunakan oleh JavaScript untuk menangani klik --}}
                        {{-- Atribut 'data-action' menyimpan jenis aksi yang akan dilakukan ('terima') --}}
                        <button type="button"
                            class="action-btn accept-btn inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium border border-blue-700 text-blue-700 bg-white hover:bg-blue-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                            data-action="terima">
                            {{-- Ikon Font Awesome untuk tanda centang --}}
                            <i class="fas fa-check mr-2"></i> Terima
                        </button>

                        {{-- Tombol Tolak --}}
                        {{-- Kelas 'action-btn' dan 'reject-btn' digunakan oleh JavaScript untuk menangani klik --}}
                        {{-- Atribut 'data-action' menyimpan jenis aksi yang akan dilakukan ('tolak') --}}
                        <button type="button"
                            class="action-btn reject-btn inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium border border-red-600 text-red-600 bg-white hover:bg-red-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition-all"
                            data-action="tolak">
                            {{-- Ikon Font Awesome untuk tanda silang --}}
                            <i class="fas fa-times mr-2"></i> Tolak
                        </button>
                    </div>
                </td>
            </tr>
        {{-- Jika koleksi $users kosong, tampilkan pesan ini --}}
        @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-lg">
                    Tidak ada pengguna yang perlu diverifikasi saat ini.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
