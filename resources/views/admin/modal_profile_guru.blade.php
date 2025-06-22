{{-- resources/views/admin/modal_profile_guru.blade.php --}}

<div id="modalEditGuru" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-center w-full text-black">EDIT MAPEL GURU</h3>
                <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" onclick="closeEditModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <form id="editGuruForm" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- Input hidden untuk menyimpan ID guru yang diedit --}}
                    <input type="hidden" name="guru_id" id="editGuruId">

                    <label for="editMapel" class="block text-sm font-medium text-black mb-1">Pilih Mata Pelajaran</label>
                    <select name="mapel_id" id="editMapel"
                        class="block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                        {{-- Pastikan $mapelList tersedia dari controller dan diteruskan ke view ini --}}
                        @foreach ($mapelList as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="mt-4 w-full bg-indigo-900 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-semibold">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
