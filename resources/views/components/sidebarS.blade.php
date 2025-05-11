<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-[#1F1AA1] border-r border-[#1F1AA1] sm:translate-x-0 dark:bg-[#1F1AA1] dark:border-[#1F1AA1]"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-[#1F1AA1] dark:bg-[#1F1AA1]">

        <!-- Tambahan Teks Judul -->
        <div class="text-white text-center text-lg font-semibold uppercase leading-tight tracking-wide mb-6">
            Sistem Informasi <br> Siswa/i Sobat Bimbel
        </div>
        <ul class="space-y-3 font-medium">
            <li>
                <a href="{{ url('/siswa.profile') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-white hover:text-[#1F1AA1] group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/siswa.daftar_hadir') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-white hover:text-[#1F1AA1] group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Daftar Hadir</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/siswa.daftar_nilai') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-white hover:text-[#1F1AA1] group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Nilai</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/siswa.kursus') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-white hover:text-[#1F1AA1] group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Kursus</span>
                </a>
            </li>
        </ul>
    </div>
</aside>