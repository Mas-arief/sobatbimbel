<div id="modalTambahMateri" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-md max-h-full mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow">
            <div class="px-6 py-4">
                <h3 class="text-xl font-bold text-center text-gray-800">Tambah Materi</h3>
                <form class="space-y-4 mt-4" action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Jenis File</label>
                        <select name="jenis_file" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            <option value="">Pilih jenis file</option>
                            <option value="pdf">PDF</option>
                            <option value="video">Video</option>
                            <option value="link">Link</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Judul Materi</label>
                        <input type="text" name="judul_materi" class="w-full border border-gray-300 rounded px-2 py-1 text-sm" />
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" class="w-full border border-gray-300 rounded px-2 py-1 text-sm" rows="3"></textarea>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Unggah File</label>
                        <input type="file" name="file_materi" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 mb-4">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Link Video</label>
                        <input type="text" name="link_video" class="w-full border border-gray-300 rounded px-2 py-1 text-sm" />
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Minggu ke</label>
                        <select name="minggu_ke" class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                            <option value="">Pilih minggu</option>
                            @for ($i = 1; $i <= 16; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit"
                            class="bg-[#1F1AA1] hover:bg-indigo-900 text-white px-4 py-2 rounded w-full font-bold text-sm">
                            Simpan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
