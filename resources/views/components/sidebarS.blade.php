<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-[#1F1AA1] sm:translate-x-0 rounded-br-[100px]"
    aria-label="Sidebar">

    <div class="h-full px-4 pb-4 overflow-y-auto text-white">
        <!-- Judul -->
        <div class="text-center text-lg font-semibold uppercase leading-tight tracking-wide mb-6">
            Sistem Informasi <br> Siswa/i Sobat Bimbel
        </div>

        <ul class="space-y-3 text-base font-medium">
            <!-- Profile -->
            <li>
                <a href="{{ url('/siswa.profile') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-user"></i>
                    <span class="ml-3">PROFIL</span>
                </a>
            </li>

            <!-- Daftar Hadir -->
            <li>
                <a href="{{ url('/siswa.daftar_hadir') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-calendar-check"></i>
                    <span class="ml-3">DAFTAR HADIR</span>
                </a>
            </li>

            <!-- Nilai -->
            <li>
                <a href="{{ url('/siswa.daftar_nilai') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-clipboard-list"></i>
                    <span class="ml-3">NILAI</span>
                </a>
            </li>

            <!-- Kursus -->
            <li>
                <a href="{{ url('/siswa.kursus') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-book-open"></i>
                    <span class="ml-3">KURSUS</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
