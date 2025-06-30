<table class="min-w-full text-base text-gray-800">
    <thead class="text-sm uppercase bg-gray-100 text-center font-semibold text-gray-700 ">
        <tr>
            <th class="px-6 py-3 border-b border-gray-200">ID</th>
            <th class="px-6 py-3 border-b border-gray-200">Nama</th>
            <th class="px-6 py-3 border-b border-gray-200">Email</th>
            <th class="px-6 py-3 border-b border-gray-200">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse ($users as $index => $user)
            <tr
                class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100' }} text-center hover:bg-gray-200 transition-colors duration-200"
                data-user-id="{{ $user->id }}">
                <td class="px-6 py-3 font-mono text-gray-700">
                    {{ $user->custom_identifier ?? $user->id }}
                </td>
                <td class="px-6 py-3 font-semibold text-gray-900">
                    {{ $user->name }}
                </td>
                <td class="px-6 py-3 text-gray-600">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <div class="flex justify-center gap-2">
                        {{-- Tombol Terima --}}
                        <button type="button"
                            class="action-btn accept-btn inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium border border-blue-700 text-blue-700 bg-white hover:bg-blue-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all"
                            data-action="terima">
                            <i class="fas fa-check mr-2"></i> Terima
                        </button>

                        {{-- Tombol Tolak --}}
                        <button type="button"
                            class="action-btn reject-btn inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium border border-red-600 text-red-600 bg-white hover:bg-red-50 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition-all"
                            data-action="tolak">
                            <i class="fas fa-times mr-2"></i> Tolak
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-lg">
                    Tidak ada pengguna yang perlu diverifikasi saat ini.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

