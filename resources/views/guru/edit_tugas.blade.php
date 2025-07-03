@extends('layouts.navbar')

@section('title', 'Edit Nilai Tugas')

@section('content')
<div class="relative z-10 max-w-2xl mx-auto mt-6 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Edit Nilai - {{ $pengumpulan->siswa->nama ?? '-' }}</h2>

    <form method="POST" action="{{ route('penilaian.simpan') }}">
        @csrf

        {{-- Hidden input untuk identifikasi --}}
        <input type="hidden" name="siswa_id" value="{{ $pengumpulan->siswa_id }}">
        <input type="hidden" name="tugas_id" value="{{ $pengumpulan->tugas_id }}">
        <input type="hidden" name="minggu" value="{{ $pengumpulan->minggu_ke }}">

        <div class="mb-4">
            <label for="nilai" class="block font-medium">Nilai</label>
            <input type="number" name="nilai" id="nilai" value="{{ old('nilai', $penilaian->nilai ?? '') }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
