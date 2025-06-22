<!-- Main modal -->
<div id="unggahModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Unggah Tugas
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="unggahModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                {{-- PASTIKAN BARIS INI BENAR: route('siswa.pengumpulan_tugas.store') --}}
                <form action="{{ route('siswa.pengumpulan_tugas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    {{-- Hidden inputs untuk mapel_id, minggu_ke, dan tugas_id (akan diisi via JS) --}}
                    <input type="hidden" name="mapel_id" id="modal_mapel_id">
                    <input type="hidden" name="minggu_ke" id="modal_minggu_ke">
                    <input type="hidden" name="tugas_id" id="modal_tugas_id">

                    <div>
                        <label for="file_tugas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih File Tugas:</label>
                        <input type="file" name="file_tugas" id="file_tugas" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        @error('file_tugas')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Keterangan (Opsional):</label>
                        <textarea name="keterangan" id="keterangan" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tambahkan keterangan untuk tugas Anda..."></textarea>
                        @error('keterangan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Kirim Tugas
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk mengisi hidden input di modal saat tombol "Kumpulkan Tugas Minggu X" diklik
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href*="/siswa/pengumpulan-tugas"]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah navigasi langsung
                const url = new URL(this.href);
                const mapelSlug = url.searchParams.get('mapel_slug');
                const mingguKe = url.searchParams.get('minggu_ke');

                // Dapatkan mapel_id dari slug (perlu logic tambahan jika bukan static)
                // Ini adalah kode PHP yang akan dieksekusi di server saat Blade dirender
                @php
                    $allMapelsForJs = \App\Models\Mapel::all()->mapWithKeys(function ($mapel) {
                        return [strtolower(str_replace(' ', '', $mapel->nama)) => $mapel->id];
                    })->toJson();
                @endphp
                const mapelLookup = JSON.parse('{!! $allMapelsForJs !!}'); // Pastikan ini aman dari XSS jika menggunakan data dinamis

                let mapelId = mapelLookup[mapelSlug.replace(' ', '')]; // Hapus spasi dari slug jika ada

                if (mapelId) {
                    document.getElementById('modal_mapel_id').value = mapelId;
                }
                document.getElementById('modal_minggu_ke').value = mingguKe;

                // --- PENTING: Mendapatkan Tugas ID ---
                // Anda perlu mendapatkan `tugas_id` yang sesuai dengan `mapelId` dan `mingguKe`.
                // Untuk sementara, kita akan mengasumsikan tugasId dapat diambil dari halaman pengumpulan tugas itu sendiri
                // atau bahwa ini adalah satu-satunya tugas untuk mapel/minggu tersebut.
                // Jika halaman pengumpulan_tugas.blade.php memiliki variabel $tugas yang sudah dilewatkan,
                // kita bisa menggunakannya di sini.
                // Misalnya:
                const tugasIdElement = document.getElementById('modal_tugas_id');
                if (tugasIdElement && typeof currentTugasIdFromPhp !== 'undefined') {
                    tugasIdElement.value = currentTugasIdFromPhp; // Ambil dari variabel PHP jika tersedia
                } else if (tugasIdElement) {
                    // Fallback: Jika tidak ada variabel PHP, coba cari di URL atau hardcode untuk testing
                    const urlParams = new URLSearchParams(window.location.search);
                    const tugasIdFromUrl = urlParams.get('tugas_id'); // Jika Anda menambahkan tugas_id ke URL kursus
                    if (tugasIdFromUrl) {
                        tugasIdElement.value = tugasIdFromUrl;
                    } else {
                        // Jika tidak ada di URL, coba ambil dari elemen di halaman
                        // Misalnya, jika Anda menampilkan judul tugas dengan ID di suatu tempat
                        const currentTaskDisplay = document.querySelector('[data-current-task-id]');
                        if(currentTaskDisplay) {
                           tugasIdElement.value = currentTaskDisplay.dataset.currentTaskId;
                        } else {
                           console.warn('Could not determine tugas_id. Modal might submit with empty tugas_id.');
                        }
                    }
                }


                // Tampilkan modal Flowbite
                const modalElement = document.getElementById('unggahModal');
                const modal = new Flowbite.Modal(modalElement); // Pastikan Flowbite JS dimuat
                modal.show();
            });
        });
    });
</script>
