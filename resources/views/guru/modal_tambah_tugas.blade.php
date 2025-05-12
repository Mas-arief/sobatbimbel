<div id="modalBuatTugas" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-md max-h-full mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-100">
            <div class="px-6 py-4">
                <h3 class="text-xl font-bold text-center">Buat Tugas</h3>
                <form class="space-y-4 mt-4" action="{{ route('tugas.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="judul_tugas" class="block mb-1 text-sm font-medium">Judul Tugas</label>
                        <input type="text" name="judul_tugas" id="judul_tugas"
                               class="w-full border border-gray-300 rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="deskripsi_tugas" class="block mb-1 text-sm font-medium">Deskripsi</label>
                        <textarea name="deskripsi_tugas" id="deskripsi_tugas"
                                  class="w-full border border-gray-300 rounded px-2 py-1"></textarea>
                    </div>
                    <div>
                        <label for="tanggal_deadline" class="block mb-1 text-sm font-medium">Tanggal Deadline</label>
                        <input type="date" name="tanggal_deadline" id="tanggal_deadline"
                               class="w-full border border-gray-300 rounded px-2 py-1">
                    </div>
                    <div>
                        <label for="minggu_ke" class="block mb-1 text-sm font-medium">Minggu ke</label>
                        <select name="minggu_ke" id="minggu_ke" class="w-full border border-gray-300 rounded px-2 py-1">
                            <option value="">Pilih minggu</option>
                            @for ($i = 1; $i <= 16; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                            </select>
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
