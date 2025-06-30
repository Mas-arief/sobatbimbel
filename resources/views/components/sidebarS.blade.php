<style>
    .shine-text {
        position: relative;
        display: inline-block;
        font-weight: bold;
        color: white;
        background-image: linear-gradient(90deg,
                white 0%,
                white 30%,
                #1F1AA1 50%,
                white 70%,
                white 100%);
        background-size: 200% auto;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: sweep-light 7s linear infinite;
    }

    @keyframes sweep-light {
        0% {
            background-position: 200% center;
        }

        100% {
            background-position: -200% center;
        }
    }
</style>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-[#1F1AA1] sm:translate-x-0 rounded-br-[100px]"
    aria-label="Sidebar">

    <div class="h-full px-4 pb-4 overflow-y-auto text-white">
        <!-- Judul -->
        <div class="text-center text-lg font-semibold uppercase leading-tight tracking-wide mb-6">
            <span class="shine-text block">Sistem Informasi</span>
            <span class="shine-text block">Siswa/i Sobat Bimbel</span>
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

            <hr class="my-1 border-gray-300 dark:border-gray-600 shadow-[0_4px_16px_rgba(0,0,0,0.45)]">

            <!-- Ganti Password -->
            <li>
                <a href="{{ url('ganti_sandi') }}"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-key"></i>
                    <span class="ml-3">GANTI SANDI</span>
                </a>
            </li>
            
            <!-- Logout -->
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-2 rounded-lg hover:bg-white hover:text-[#1F1AA1] transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="ml-3">KELUAR</span>
                </a>

                <!-- Hidden logout form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</aside>
