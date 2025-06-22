@extends('layouts.navbar')

@section('title', 'Input Nilai')

@section('content')

    <style>
        @keyframes floatingFade {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }

            25% {
                opacity: 0.1;
            }

            50% {
                transform: translateY(-10px);
                opacity: 0.2;
            }

            75% {
                opacity: 0.1;
            }

            100% {
                transform: translateY(0px);
                opacity: 0;
            }
        }

        .animate-floating-fade {
            animation: floatingFade 10s ease-in-out infinite;
        }
    </style>

    <!-- background animasi -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <img src="{{ asset('images/6.png') }}" alt="Background"
            class="absolute w-full h-full object-cover opacity-5 animate-floating-fade" />
    </div>

    <div class="relative z-10 flex justify-center mt-10 w-full px-4">
        <div class="w-full max-w-3xl">
            <h2 class="text-2xl font-bold mb-4 text-center">INPUT NILAI</h2>

            <p><strong>Mapel:</strong> {{ $mapel->nama }}</p>
            <p><strong>Minggu Ke:</strong> Minggu ke-{{ $minggu }}</p>

            <form action="{{ route('penilaian.store') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
                <input type="hidden" name="minggu_ke" value="{{ $minggu }}">

                <table class="w-full text-center border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Nama</th>
                            <th class="p-2">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $s)
                            <tr class="border-t">
                                <td class="p-2">{{ $s->name }}</td>
                                <td class="p-2">
                                    <input type="number" name="nilai[{{ $s->id }}]" placeholder="Angka" min="0" max="100"
                                        value="{{ $penilaian->get($s->id)?->nilai }}"
                                        class="w-24 border rounded px-2 py-1 text-center text-sm dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex justify-end space-x-2">
                    <a href="{{ url()->previous() }}"
                        class="bg-indigo-700 hover:bg-indigo-800 text-white px-6 py-2 rounded text-sm font-medium shadow-md transition duration-200">
                        Kembali
                    </a>
                    <button type="submit"
                        class="bg-indigo-700 hover:bg-indigo-800 text-white px-6 py-2 rounded text-sm font-medium shadow-md transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection