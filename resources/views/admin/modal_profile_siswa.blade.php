<!-- Modal untuk Edit Data Siswa -->
<div id="modalEditSiswa" tabindex="-1" aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-center w-full text-black">
                    EDIT PROFILE SISWA
                </h3>
                <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" data-modal-hide="modalEditSiswa">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <form>
                    <input type="text" id="namaSiswa" placeholder="Nama Siswa"
                        class="block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">

                    <div class="flex gap-2 mt-2">
                        <input type="text" id="tempatLahir" placeholder="Tempat Lahir"
                            class="w-1/2 bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                        <input type="date" id="tanggalLahir"
                            class="w-1/2 bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                    </div>

                    <div class="mt-2 text-black">
                        <label class="inline-flex items-center">
                            <input type="radio" name="jenisKelamin" value="L" class="mr-1"> Laki-laki
                        </label>
                        <label class="inline-flex items-center ml-4">
                            <input type="radio" name="jenisKelamin" value="P" class="mr-1"> Perempuan
                        </label>
                    </div>

                    <textarea id="alamatDomisili" placeholder="Alamat Domisili"
                        class="mt-2 block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black resize-none" rows="2"></textarea>

                    <input type="text" id="nohp" placeholder="No HP"
                        class="mt-2 block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">
                    <input type="email" id="email" placeholder="Email"
                        class="mt-2 block w-full bg-gray-200 px-3 py-2 rounded border border-gray-400 text-black">

                    <button type="submit"
                        class="mt-4 w-24 mx-auto block bg-indigo-900 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-semibold">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
