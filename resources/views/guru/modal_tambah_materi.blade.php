<div id="modal_Tambah_Materi" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Materi Baru
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modal_Tambah_Materi">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form id="materiForm" action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Judul Materi
                        </label>
                        <input type="text" name="judul_materi" id="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                            placeholder="Masukkan judul materi" required>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Upload File (PDF, DOCX, PPTX)
                        </label>
                        <input type="file" name="file_materi" id="file"
                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-400 dark:file:bg-gray-800 dark:file:text-blue-300 dark:hover:file:bg-gray-700"
                            accept=".pdf,.docx,.pptx" required>
                        <p class="mt-1 text-xs text-gray-500">Maksimal 10MB</p>
                    </div>

                    <!-- Hidden fields for week and subject -->
                    <input type="hidden" name="minggu_ke" id="minggu_ke" value="">
                    <input type="hidden" name="mapel_id" id="mapel_id" value="">

                    <!-- Display current selection -->
                    <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-600 rounded-md">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <strong>Minggu:</strong> <span id="display_minggu">-</span><br>
                            <strong>Mata Pelajaran:</strong> <span id="display_mapel">-</span>
                        </p>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                            data-modal-hide="modal_Tambah_Materi">
                            Batal
                        </button>
                        <button type="submit" id="submitBtn"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-800 dark:hover:bg-blue-900">
                            <span id="submitText">Simpan Materi</span>
                            <svg id="submitSpinner" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('coursePage', () => ({
            tab: 'mtk',
            open: null,
            tugasOpen: null,
            materiOpen: null,

            openMateriModal(week, tab) {
                const mingguKe = document.getElementById('minggu_ke');
                const mapelId = document.getElementById('mapel_id');
                const displayMinggu = document.getElementById('display_minggu');
                const displayMapel = document.getElementById('display_mapel');

                const mapelMap = {
                    indo: {
                        id: 1,
                        name: 'Bahasa Indonesia'
                    },
                    inggris: {
                        id: 2,
                        name: 'Bahasa Inggris'
                    },
                    mtk: {
                        id: 3,
                        name: 'Matematika'
                    }
                };

                const selected = mapelMap[tab];

                mingguKe.value = week;
                mapelId.value = selected.id;
                displayMinggu.textContent = week;
                displayMapel.textContent = selected.name;

                document.getElementById('modal_Tambah_Materi').classList.remove('hidden');
            }
        }));
    });

    // AJAX Form submission handler
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('materiForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading
            submitBtn.disabled = true;
            submitText.textContent = 'Menyimpan...';
            submitSpinner.classList.remove('hidden');

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Materi berhasil ditambahkan!');
                        form.reset();
                        document.getElementById('modal_Tambah_Materi').classList.add('hidden');
                        location.reload();
                    } else {
                        alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan saat menyimpan materi');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitText.textContent = 'Simpan Materi';
                    submitSpinner.classList.add('hidden');
                });
        });
    });
</script>