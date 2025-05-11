<nav class="fixed top-0 z-50 w-full bg-[#1F1AA1] border-b border-[#1F1AA1] dark:bg-[#1F1AA1] dark:border-[#1F1AA1]">
    <div class="px-3 py-4 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-white rounded-lg sm:hidden hover:bg-[#3834c4] focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                              d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <img src="{{ asset('images/sb putih1.png') }}" class="h-8 me-3" alt="SOBAT BIMBEL Logo" />
                <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-white">SOBAT BIMBEL</span>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <span class="text-white font-medium hidden sm:inline pr-4">Selamat Datang, Siswa!</span>
                    <div>
                        <button type="button"
                                class="flex text-sm bg-white rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke-width="1.5" stroke="currentColor" class="size-8 bg-transparent">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-[#1F1AA1] divide-y divide-white rounded-sm shadow-sm"
                         id="dropdown-user">
                        <ul class="py-1 text-center" role="none">
                            <li>
                                <a href="{{ url('/ganti_sandi') }}"
                                   class="block px-4 py-2 text-sm text-white hover:bg-blue-800 hover:text-white"
                                   role="menuitem">GANTI KATA SANDI</a>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ url('/logout') }}"
                                   class="block px-4 py-2 text-sm text-white hover:bg-blue-800 hover:text-white"
                                   role="menuitem">KELUAR</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
