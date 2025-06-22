<div id="modalTambahMateri" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-md max-h-full mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-100">
            <div class="px-6 py-4">
                <h3 class="text-xl font-bold text-center">Tambah Materi</h3>
                <form class="space-y-4 mt-4" action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Input tersembunyi untuk mapel_id dan minggu_ke --}}
                    <input type="hidden" name="mapel_id" id="mapel_id_materi">
                    <input type="hidden" name="minggu_ke" id="minggu_ke_materi_hidden"> {{-- Digunakan untuk mengirim nilai minggu ke controller --}}

                    <div>
                        <label for="judul_materi" class="block mb-1 text-sm font-medium">Judul Materi</label>
                        <input type="text" name="judul_materi" id="judul_materi"
                               class="w-full border border-gray-300 rounded px-2 py-1" required>
                    </div>

                    <div>
                        <label for="file_materi_input" class="block mb-1 text-sm font-medium">File Materi (PDF, DOCX, PPTX)</label>
                        <input type="file" name="file_materi" id="file_materi_input" accept=".pdf,.doc,.docx,.ppt,.pptx"
                               class="w-full border border-gray-300 rounded px-2 py-1" required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hanya file PDF, DOCX, PPTX yang diizinkan (maks 10MB).</p>
                    </div>

                    <div>
                        <label for="minggu_ke_materi_select" class="block mb-1 text-sm font-medium">Minggu ke</label>
                        {{-- Ini adalah input readonly yang akan menampilkan nilai minggu_ke --}}
                        <input type="text" name="minggu_ke_display" id="minggu_ke_materi_select"
                               class="w-full border border-gray-300 rounded px-2 py-1" readonly>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                                class="bg-[#1F1AA1] hover:bg-indigo-900 text-white px-4 py-2 rounded w-full font-bold text-sm">Simpan Materi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
