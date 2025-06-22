<div id="modalBuatTugas" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-md max-h-full mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-100">
            <div class="px-6 py-4">
                <h3 class="text-xl font-bold text-center">Buat Tugas</h3>
                <form class="space-y-4 mt-4" action="{{ route('guru.tugas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Input tersembunyi untuk mapel_id dan minggu_ke --}}
                    <input type="hidden" name="mapel_id" id="mapel_id_tugas">
                    <input type="hidden" name="minggu_ke" id="minggu_ke_tugas_hidden"> {{-- Digunakan untuk mengirim nilai minggu ke controller --}}

                    <div>
                        <label for="judul_tugas" class="block mb-1 text-sm font-medium">Judul Tugas</label>
                        <input type="text" name="judul_tugas" id="judul_tugas"
                               class="w-full border border-gray-300 rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="file_tugas_input" class="block mb-1 text-sm font-medium">File Tugas (PDF)</label>
                        <input type="file" name="file_path" id="file_tugas_input" accept=".pdf"
                               class="w-full border border-gray-300 rounded px-2 py-1" required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hanya file PDF yang diizinkan (maks 2MB).</p>
                    </div>

                    <div>
                        <label for="tanggal_deadline" class="block mb-1 text-sm font-medium">Tanggal Deadline</label>
                        <input type="date" name="tanggal_deadline" id="tanggal_deadline"
                               class="w-full border border-gray-300 rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="minggu_ke_select" class="block mb-1 text-sm font-medium">Minggu ke</label>
                        {{-- Ini adalah bagian yang diubah dari <select> menjadi <input type="text" readonly> --}}
                        <input type="text" name="minggu_ke_display" id="minggu_ke_select"
                               class="w-full border border-gray-300 rounded px-2 py-1" readonly>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                                class="bg-[#1F1AA1] hover:bg-indigo-900 text-white px-4 py-2 rounded w-full font-bold text-sm">Simpan Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function setTugasModalValues(mapelId, mingguKe) {
        setTimeout(() => {
            const mapelInput = document.getElementById('mapel_id_tugas');
            const mingguSelect = document.getElementById('minggu_ke_select'); // Ini sekarang merujuk ke input teks
            const mingguHiddenInput = document.getElementById('minggu_ke_tugas_hidden');

            if (mapelInput) {
                mapelInput.value = mapelId;
                console.log('mapel_id_tugas set to:', mapelId);
            } else {
                console.error('Element with ID mapel_id_tugas not found.');
            }

            if (mingguSelect) {
                mingguSelect.value = mingguKe; // Mengatur nilai input teks
                console.log('minggu_ke_select set to:', mingguKe);
            } else {
                console.error('Element with ID minggu_ke_select not found.');
            }

            if (mingguHiddenInput) {
                mingguHiddenInput.value = mingguKe;
                console.log('minggu_ke_tugas_hidden set to:', mingguKe);
            }

        }, 750); // Jeda 750ms
    }
</script>
@endpush
