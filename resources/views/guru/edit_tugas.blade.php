@extends('layouts.navbar')

@section('title', 'Edit Nilai Tugas')

@section('content')
<div class="max-w-2xl mx-auto mt-6 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Edit Nilai - {{ $pengumpulan->siswa->nama ?? '-' }}</h2>

    <form method="POST" action="{{ route('guru.tugas.update', $pengumpulan->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nilai" class="block font-medium">Nilai</label>
            <input type="number" name="nilai" id="nilai" value="{{ old('nilai', $pengumpulan->nilai) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
