<!-- Modal Edit Mapel Guru -->
<div id="modalEditGuru" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-full flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative w-full max-w-md">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold">Ubah Mapel Guru</h3>
                <button data-modal-hide="modalEditGuru" type="button"
                    class="text-gray-400 hover:text-black bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 flex justify-center items-center">
                    ✕
                </button>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form>
                    <label for="mapel" class="block mb-2 text-sm font-medium text-gray-700">Pilih Mapel</label>
                    <select name="mapel" id="mapel" class="mb-4 block w-full border border-gray-300 rounded p-2">
                        <option value="Matematika">Matematika</option>
                        <option value="Bahasa Inggris">Bahasa Inggris</option>
                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                    </select>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
