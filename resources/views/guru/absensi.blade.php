<form method="POST" action="{{ route('absensi.store') }}">
    @csrf
    <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
    <input type="hidden" name="minggu_ke" value="{{ $mingguKe }}">

    <!-- Tombol Auto Ceklis -->
    <div class="flex justify-end max-w-3xl mx-auto mb-2">
        <button type="button" onclick="checkAll()" class="bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded text-sm">
            Ceklis Semua Hadir
        </button>
    </div>

    <div class="overflow-y-auto max-h-[400px] border rounded-md w-full max-w-3xl mx-auto mt-2">
        <table class="table-auto w-full border-collapse">
            <thead class="bg-gray-200 sticky top-0 z-10 text-sm">
                <tr>
                    <th class="p-2 border text-left">Nama</th>
                    <th class="p-2 border text-center">Kehadiran</th>
                    <th class="p-2 border text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absensi as $index => $absen)
                    <tr class="even:bg-gray-100 text-sm">
                        <td class="p-2 border">{{ $absen->siswa->nama ?? 'Nama Tidak Ditemukan' }}
                            <input type="hidden" name="siswa_id[{{ $index }}]" value="{{ $absen->siswa->id }}">
                        </td>
                        <td class="p-2 border text-center">
                            <input type="checkbox" class="kehadiran-checkbox" name="kehadiran[{{ $index }}]" value="1" {{ $absen->kehadiran ? 'checked' : '' }}>
                        </td>
                        <td class="p-2 border text-center">
                            <input type="text" name="keterangan[{{ $index }}]" value="{{ $absen->keterangan }}" class="border rounded p-1 text-sm w-full">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex justify-end space-x-2 mt-4 max-w-3xl mx-auto">
        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-3 py-1.5 rounded text-sm">
            Simpan Absensi
        </button>
        <a href="{{ url()->previous() }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded text-sm">
            Kembali
        </a>
    </div>
</form>

<script>
    // Auto ceklis semua siswa
    function checkAll() {
        document.querySelectorAll('.kehadiran-checkbox').forEach(cb => cb.checked = true);
    }
</script>
