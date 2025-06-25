<table class="min-w-full text-base text-gray-800">
    <thead class="text-sm uppercase bg-gray-100 text-center font-semibold text-gray-700">
        <tr>
            <th class="px-6 py-3 border-b border-gray-200">ID</th>
            <th class="px-6 py-3 border-b border-gray-200">NAMA</th>
            <th class="px-6 py-3 border-b border-gray-200">EMAIL</th>
            <th class="px-6 py-3 border-b border-gray-200">AKSI</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @forelse ($users as $index => $user)
            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-gray-100' }} text-center hover:bg-gray-200 transition-colors duration-200"
                data-user-id="{{ $user->id }}">
                <td class="px-6 py-3 text-gray-700 font-mono">{{ $user->custom_identifier ?? $user->id }}</td>
                <td class="px-6 py-3 font-semibold text-gray-900">{{ $user->name }}</td>
                <td class="px-6 py-3 text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-3 whitespace-nowrap flex justify-center gap-2">
                    <button type="button"
                        class="action-btn accept-btn bg-white text-blue-700 border border-blue-700 font-medium px-4 py-2 rounded-lg text-sm shadow-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 inline-flex items-center"
                        data-action="terima">
                        <i class="fas fa-check mr-2"></i> Terima
                    </button>
                    <button type="button"
                        class="action-btn reject-btn bg-white text-red-600 border border-red-600 font-medium px-4 py-2 rounded-lg text-sm shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200 inline-flex items-center"
                        data-action="tolak">
                        <i class="fas fa-times mr-2"></i> Tolak
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500 text-lg">Tidak ada pengguna yang perlu diverifikasi saat ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>
