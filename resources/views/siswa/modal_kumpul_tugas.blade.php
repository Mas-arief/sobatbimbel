<!-- Modal -->
<div id="unggahModal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 max-w-md w-full">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Unggah Tugas</h3>

        <form action="{{ route('siswa.pengumpulan_tugas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <input type="hidden" name="mapel_id" id="modal_mapel_id">
            <input type="hidden" name="minggu_ke" id="modal_minggu_ke">
            <input type="hidden" name="tugas_id" id="modal_tugas_id">

            <div>
                <label for="file_tugas" class="block text-sm font-medium text-gray-700 dark:text-white">Pilih File</label>
                <input type="file" name="file_tugas" id="file_tugas" class="w-full mt-1 text-sm border rounded">
            </div>

            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-white">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="w-full mt-1 border rounded"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 bg-gray-300 text-black rounded" onclick="document.getElementById('unggahModal').classList.add('hidden')">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded">Kirim</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('modal_mapel_id').value = button.dataset.mapelId;
                document.getElementById('modal_minggu_ke').value = button.dataset.mingguKe;
                document.getElementById('modal_tugas_id').value = button.dataset.tugasId;
                document.getElementById('unggahModal').classList.remove('hidden');
            });
        });
    });
</script>
