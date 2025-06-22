<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-[#1F1AA1] sm:translate-x-0 rounded-br-[100px]"
    aria-label="Sidebar"
    x-data="{ open: false }">
    
    <div class="h-full px-4 pb-4 overflow-y-auto text-white">
        <!-- Judul -->
        <div class="text-center text-lg font-semibold uppercase leading-tight tracking-wide mb-6">
            Sistem Informasi <br> Siswa/i Sobat Bimbel
        </div>

        <ul class="space-y-3 text-base font-medium">
            <!-- Halaman Utama -->
            <li>
                <a href="{{ url('admin.dashboard-admin') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-home"></i>
                    <span class="ml-3">HALAMAN UTAMA</span>
                </a>
            </li>

            <!-- Verifikasi -->
            <li>
                <a href="{{ url('admin.verifikasi') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-check-circle"></i>
                    <span class="ml-3">VERIFIKASI</span>
                </a>
            </li>

            <!-- Dropdown Manajemen -->
            <li x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center w-full p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] focus:outline-none transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-users-cog"></i>
                    <span class="ml-3 flex-1 text-left">MANAJEMEN</span>
                    <svg :class="{'rotate-90': open}" class="w-4 h-4 transition-transform ml-auto" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <ul x-show="open" x-collapse class="ml-8 mt-2 space-y-2 text-sm">
                    <li>
                        <a href="{{ url('admin.profile_guru') }}"
                            class="flex items-center px-2 py-1 rounded hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-user mr-2 w-4"></i>
                            <span>PROFILE GURU</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin.profile_siswa') }}"
                            class="flex items-center px-2 py-1 rounded hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-user-graduate mr-2 w-4"></i>
                            <span>PROFILE SISWA</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
