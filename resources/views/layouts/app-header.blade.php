<header
    class="sticky top-0 z-40 flex w-full border-b border-gray-200 bg-white/95 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/95"
>

    <div
        class="flex w-full flex-col xl:flex-row xl:items-center xl:justify-between xl:px-6"
    >

        {{-- ========================================= --}}
        {{-- LEFT SIDE                                 --}}
        {{-- ========================================= --}}

        <div
            class="flex w-full items-center justify-between gap-4 px-4 py-3 xl:w-auto xl:px-0 xl:py-4"
        >

            {{-- Desktop Sidebar Toggle --}}
            <button
                type="button"
                @click="$store.sidebar.toggleExpanded()"
                class="hidden h-10 w-10 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 xl:flex dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                aria-label="Toggle sidebar"
            >

                {{-- Menu Icon --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

            </button>


            {{-- Mobile Sidebar Toggle --}}
            <button
                type="button"
                @click="$store.sidebar.toggleMobileOpen()"
                class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 xl:hidden dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                aria-label="Open menu"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

            </button>


            {{-- Mobile Logo --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center xl:hidden"
            >

                <span
                    class="text-lg font-bold text-gray-800 dark:text-white"
                >
                    URL Shortener
                </span>

            </a>


            {{-- ========================================= --}}
            {{-- SEARCH                                    --}}
            {{-- ========================================= --}}

            <div
                class="hidden max-w-md flex-1 lg:block xl:ml-4"
            >

                <div class="relative">

                    {{-- Search Icon --}}
                    <span
                        class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                            />
                        </svg>

                    </span>


                    {{-- Search Input --}}
                    <input
                        type="text"
                        placeholder="Search..."
                        class="h-10 w-full rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-4 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-500 dark:focus:border-blue-500"
                    >

                </div>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- RIGHT SIDE                                --}}
        {{-- ========================================= --}}

        <div
            class="flex w-full items-center justify-end gap-2 border-t border-gray-100 px-4 py-2 xl:w-auto xl:border-0 xl:px-0 xl:py-0"
        >

            {{-- ========================================= --}}
            {{-- THEME TOGGLE                              --}}
            {{-- ========================================= --}}

            <button
                type="button"
                @click="$store.theme.toggle()"
                class="flex h-10 w-10 items-center justify-center rounded-full text-gray-500 transition hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
                aria-label="Toggle dark mode"
            >

                {{-- Sun Icon - Light Mode --}}
                <svg
                    x-show="$store.theme.theme === 'light'"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364-.707.707M6.343 17.657l-.707.707m12.728 0-.707-.707M6.343 6.343l-.707-.707M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                    />
                </svg>


                {{-- Moon Icon - Dark Mode --}}
                <svg
                    x-show="$store.theme.theme === 'dark'"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"
                    />
                </svg>

            </button>


            {{-- ========================================= --}}
            {{-- USER DROPDOWN                             --}}
            {{-- ========================================= --}}

            <x-header.user-dropdown />

        </div>

    </div>

</header>