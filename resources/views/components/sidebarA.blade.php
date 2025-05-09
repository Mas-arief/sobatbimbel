<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-[#1F1AA1] sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            <li><a href="{{ url('admin.dashboard-admin') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-white hover:text-[#1F1AA1]"><i class="fas fa-home"></i><span class="ml-3">HALAMAN UTAMA</span></a></li>
            <li><a href="{{ url('admin.verifikasi') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-white hover:text-[#1F1AA1]"><i class="fas fa-check-circle"></i><span class="ml-3">VERIFIKASI</span></a></li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-white hover:bg-white hover:text-[#1F1AA1]" data-dropdown-toggle="multi-dropdown">
                    <i class="fas fa-users-cog"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">MANAJEMEN</span>
                </button>
                <div id="multi-dropdown" class="hidden z-10 bg-white divide-y divide-gray-100 rounded-lg">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="{{ url('admin.profile_guru') }}" class="block px-4 py-2 hover:bg-gray-100">PROFILE GURU</a></li>
                        <li><a href="{{ url('admin.profile_siswa') }}" class="block px-4 py-2 hover:bg-gray-100">PROFILE SISWA</a></li>
                        <li><a href="{{ url('admin.guru_mapel') }}" class="block px-4 py-2 hover:bg-gray-100">GURU DAN MAPEL</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</aside>
