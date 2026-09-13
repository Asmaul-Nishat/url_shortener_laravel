<header
    class="sticky top-0 z-40 flex w-full border-b border-gray-200 bg-white/95 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/95"
>

    <div class="flex w-full flex-col xl:flex-row xl:items-center xl:justify-between xl:px-6">

        {{-- ========================================================= --}}
        {{-- LEFT SIDE --}}
        {{-- ========================================================= --}}

        <div
            class="flex w-full items-center justify-between gap-3 border-b border-gray-200 px-3 py-3 dark:border-gray-800 xl:border-b-0 xl:px-0 xl:py-4"
        >

            {{-- ================================================= --}}
            {{-- DESKTOP SIDEBAR TOGGLE --}}
            {{-- ================================================= --}}

            <button
                type="button"
                class="hidden h-10 w-10 items-center justify-center rounded-xl border border-gray-200 text-gray-500 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-600 dark:border-gray-800 dark:text-gray-400 dark:hover:border-brand-800 dark:hover:bg-brand-500/10 dark:hover:text-brand-400 xl:flex"
                :class="{
                    'bg-gray-100 dark:bg-white/[0.03]':
                        !$store.sidebar.isExpanded
                }"
                @click="$store.sidebar.toggleExpanded()"
                aria-label="Toggle Sidebar"
            >

                <svg
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="none"
                >
                    <path
                        d="M3 5H17M3 10H17M3 15H17"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                    />
                </svg>

            </button>


            {{-- ================================================= --}}
            {{-- MOBILE MENU TOGGLE --}}
            {{-- ================================================= --}}

            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white xl:hidden"
                :class="{
                    'bg-gray-100 dark:bg-white/[0.03]':
                        $store.sidebar.isMobileOpen
                }"
                @click="$store.sidebar.toggleMobileOpen()"
                aria-label="Toggle Mobile Menu"
            >

                {{-- Hamburger --}}

                <svg
                    x-show="!$store.sidebar.isMobileOpen"
                    x-cloak
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="none"
                >
                    <path
                        d="M3 5H17M3 10H17M3 15H17"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                    />
                </svg>


                {{-- Close --}}

                <svg
                    x-show="$store.sidebar.isMobileOpen"
                    x-cloak
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="none"
                >
                    <path
                        d="M5 5L15 15M15 5L5 15"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                    />
                </svg>

            </button>


            {{-- ================================================= --}}
            {{-- MOBILE LOGO --}}
            {{-- ================================================= --}}

            <div class="xl:hidden">

                <a
                    href="{{ url('/dashboard') }}"
                    class="text-lg font-bold tracking-tight text-gray-900 dark:text-white"
                >

                    <span class="text-brand-600 dark:text-brand-400">
                        URL
                    </span>

                    Shortener

                </a>

            </div>


            {{-- ================================================= --}}
            {{-- SEARCH --}}
            {{-- ================================================= --}}

            <div class="hidden xl:block">

                <form
                    action="#"
                    method="GET"
                    @submit.prevent
                >

                    <div class="relative">

                        {{-- Search Icon --}}

                        <svg
                            class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                            viewBox="0 0 20 20"
                            fill="none"
                        >

                            <path
                                d="M9 15.5A6.5 6.5 0 1 0 9 2.5a6.5 6.5 0 0 0 0 13ZM14 14l4 4"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                            />

                        </svg>


                        {{-- Search Input --}}

                        <input
                            type="text"
                            x-ref="searchInput"
                            placeholder="Search or type command..."
                            class="h-11 w-[380px] rounded-xl border border-gray-200 bg-gray-50 pl-12 pr-16 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-brand-500 focus:bg-white focus:ring-4 focus:ring-brand-500/10 dark:border-gray-800 dark:bg-gray-800/50 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500 dark:focus:bg-gray-800"
                        >


                        {{-- Keyboard Shortcut --}}

                        <button
                            type="button"
                            tabindex="-1"
                            @click="$refs.searchInput?.focus()"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium text-gray-500 shadow-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400"
                        >
                            ⌘ K
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- RIGHT SIDE --}}
        {{-- ========================================================= --}}

        <div
            class="flex w-full items-center justify-end gap-3 px-4 py-3 xl:w-auto xl:px-0 xl:py-0"
        >

            {{-- ================================================= --}}
            {{-- THEME TOGGLE --}}
            {{-- ================================================= --}}

            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-500 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-600 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:border-brand-800 dark:hover:bg-brand-500/10 dark:hover:text-brand-400"
                @click="$store.theme.toggle()"
                aria-label="Toggle Theme"
            >

                {{-- ================================================= --}}
                {{-- SUN ICON --}}
                {{-- ================================================= --}}

                <svg
                    x-show="$store.theme.isDark"
                    x-cloak
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="none"
                >

                    <path
                        d="M10 2V3M10 17V18M18 10H17M3 10H2M15.66 4.34L14.95 5.05M5.05 14.95L4.34 15.66M15.66 15.66L14.95 14.95M5.05 5.05L4.34 4.34"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                    />

                    <circle
                        cx="10"
                        cy="10"
                        r="3.5"
                        stroke="currentColor"
                        stroke-width="1.5"
                    />

                </svg>


                {{-- ================================================= --}}
                {{-- MOON ICON --}}
                {{-- ================================================= --}}

                <svg
                    x-show="!$store.theme.isDark"
                    x-cloak
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="none"
                >

                    <path
                        d="M16.5 11.5A6.5 6.5 0 0 1 8.5 3.5a6.5 6.5 0 1 0 8 8Z"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                </svg>

            </button>


            {{-- ================================================= --}}
            {{-- USER DROPDOWN --}}
            {{-- ================================================= --}}

            <x-header.user-dropdown />

        </div>

    </div>

</header>