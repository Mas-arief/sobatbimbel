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

<!-- resources/views/components/navbar.blade.php -->
<nav class="fixed top-0 z-50 w-full bg-[#1F1AA1] border-b border-[#1F1AA1] dark:bg-[#1F1AA1] dark:border-[#1F1AA1]">
    <div class="px-3 py-4 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                    aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-white rounded-lg sm:hidden hover:bg-[#3834c4] focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <img src="{{ asset('images/sb-putih1.png') }}" class="h-8 me-3" alt="FlowBite Logo" />
                <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap text-white">SOBAT BIMBEL</span>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <span class="text-white font-bold hidden sm:inline pr-2 shine-text"><strong>Selamat Datang, Admin!</strong></span>
                </div>
            </div>
        </div>
    </div>
</nav>
