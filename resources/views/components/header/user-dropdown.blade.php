<div
    class="relative"
    x-data="{
        isOpen: false,
        languageOpen: false,
        currentLocale: '{{ app()->getLocale() }}',

        languages: [
            {
                id: 'en',
                name: 'English',
                shortName: 'English',
                flag: 'flag-us.svg',
                dir: 'ltr'
            },
            {
                id: 'bn',
                name: 'বাংলা',
                shortName: 'বাংলা',
                flag: 'flag-bd.svg',
                dir: 'ltr'
            }
        ],

        get currentLang() {
            return this.languages.find(
                language => language.id === this.currentLocale
            ) || this.languages[0];
        },

        toggleDropdown() {
            this.isOpen = !this.isOpen;

            if (!this.isOpen) {
                this.languageOpen = false;
            }
        },

        closeDropdown() {
            this.isOpen = false;
            this.languageOpen = false;
        },

        toggleLanguage() {
            this.languageOpen = !this.languageOpen;
        },

        selectLanguage(language) {
            this.currentLocale = language.id;

            localStorage.setItem('locale', language.id);
            localStorage.setItem('dir', language.dir);

            document.documentElement.setAttribute('lang', language.id);
            document.documentElement.setAttribute('dir', language.dir);

            /*
             * Language backend route will be connected later.
             * For now, keep the selected language in localStorage.
             */
            this.languageOpen = false;
        }
    }"
    @click.outside="closeDropdown()"
>

    <!-- =========================
         User Trigger
    ========================== -->
    <button
        type="button"
        @click="toggleDropdown()"
        class="flex items-center text-gray-700 dark:text-gray-400"
    >

        <!-- User Avatar -->
        <span
            class="mr-3 overflow-hidden rounded-full h-11 w-11 rtl:mr-0 rtl:ml-3"
        >
            <img
                src="{{ auth()->user()->profile_photo_path
                    ? asset('storage/' . auth()->user()->profile_photo_path)
                    : asset('images/user/owner.png') }}"
                alt="{{ auth()->user()->name }}"
                class="object-cover w-full h-full"
            />
        </span>

        <!-- User Name -->
        <span
            class="block mr-1 font-medium text-theme-sm rtl:mr-0 rtl:ml-1"
        >
            {{ auth()->user()->name }}
        </span>

        <!-- Chevron -->
        <svg
            :class="isOpen ? 'rotate-180' : ''"
            class="transition-transform duration-200 stroke-gray-500 dark:stroke-gray-400"
            width="18"
            height="18"
            viewBox="0 0 18 18"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M4.5 6.75L9 11.25L13.5 6.75"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>

    </button>


    <!-- =========================
         Dropdown Menu
    ========================== -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"

        class="absolute ltr:right-0 rtl:left-0 mt-[17px] flex w-[280px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark z-50"

        style="display: none;"
    >

        <!-- =========================
             User Information
        ========================== -->
        <div class="px-3 py-2">

            <span
                class="block font-medium text-gray-800 text-theme-sm dark:text-white"
            >
                {{ auth()->user()->name }}
            </span>

            <span
                class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400"
            >
                {{ auth()->user()->email }}
            </span>

        </div>


        <!-- =========================
             Account Menu
        ========================== -->
        <ul
            class="flex flex-col gap-1 pt-3 pb-3 border-b border-gray-200 dark:border-gray-800"
        >

            <!-- Edit Profile -->
            <li>

                <a
                    href="{{ route('profile.edit') }}"
                    @click="closeDropdown()"
                    class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                >

                    <!-- Profile Icon -->
                    <span
                        class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300"
                    >

                        <svg
                            class="w-5 h-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z"
                                stroke="currentColor"
                                stroke-width="1.5"
                            />

                            <path
                                d="M4 20C4.8 16.8 7.6 15 12 15C16.4 15 19.2 16.8 20 20"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                            />
                        </svg>

                    </span>

                    Edit Profile

                </a>

            </li>


            <!-- Account Settings -->
            <li>

                <a
                    href="{{ route('settings') }}"
                    @click="closeDropdown()"
                    class="flex items-center gap-3 px-3 py-2 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                >

                    <!-- Settings Icon -->
                    <span
                        class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300"
                    >

                        <svg
                            class="w-5 h-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M12 15.5C13.933 15.5 15.5 13.933 15.5 12C15.5 10.067 13.933 8.5 12 8.5C10.067 8.5 8.5 10.067 8.5 12C8.5 13.933 10.067 15.5 12 15.5Z"
                                stroke="currentColor"
                                stroke-width="1.5"
                            />

                            <path
                                d="M19.4 15C19.55 14.67 19.68 14.33 19.77 14L21.5 12.75L19.5 9.25L17.5 9.75C17.1 9.45 16.67 9.2 16.2 9.02L15.5 7L11.5 7L10.8 9.02C10.33 9.2 9.9 9.45 9.5 9.75L7.5 9.25L5.5 12.75L7.23 14C7.32 14.33 7.45 14.67 7.6 15L7 17L10.5 19L12 18.2L13.5 19L17 17L16.4 15"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                    </span>

                    Account Settings

                </a>

            </li>


            <!-- Language -->
            <li>

                <button
                    type="button"
                    @click.stop="toggleLanguage()"
                    class="group flex w-full items-center justify-between gap-2 rounded-lg px-3 py-2 text-theme-sm font-medium transition-colors"
                    :class="languageOpen
                        ? 'bg-gray-100 text-gray-900 dark:bg-white/5 dark:text-white'
                        : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white'"
                >

                    <span class="flex items-center gap-3">

                        <!-- Language Icon -->
                        <span
                            class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300"
                        >

                            <svg
                                class="w-5 h-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />

                                <path
                                    d="M3 12H21"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="M12 3C14.2 5.4 15.3 8.4 15.3 12C15.3 15.6 14.2 18.6 12 21C9.8 18.6 8.7 15.6 8.7 12C8.7 8.4 9.8 5.4 12 3Z"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                />
                            </svg>

                        </span>

                        <span>
                            Language
                        </span>

                    </span>


                    <!-- Current Language -->
                    <span
                        class="flex items-center gap-1.5 rounded-lg border border-gray-200 bg-gray-50 px-2 py-1 text-theme-xs font-medium text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300"
                    >

                        <span x-text="currentLang.shortName"></span>

                        <img
                            :src="'/images/icons/' + currentLang.flag"
                            :alt="currentLang.shortName"
                            class="size-3.5 shrink-0 overflow-hidden rounded-full object-cover"
                        />

                    </span>

                </button>


                <!-- Language Options -->
                <div
                    x-show="languageOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"

                    class="mt-1 ml-8 rounded-xl border border-gray-200 bg-gray-50 p-1.5 dark:border-gray-800 dark:bg-white/[0.03]"

                    style="display: none;"
                >

                    <template
                        x-for="language in languages"
                        :key="language.id"
                    >

                        <button
                            type="button"
                            @click="selectLanguage(language)"
                            class="flex w-full items-center gap-2 rounded-lg px-2.5 py-2 text-theme-sm font-medium transition-colors"
                            :class="currentLocale === language.id
                                ? 'bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400'
                                : 'text-gray-700 hover:bg-white hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white'"
                        >

                            <!-- Selected Indicator -->
                            <span
                                class="size-1.5 shrink-0 rounded-full"
                                :class="currentLocale === language.id
                                    ? 'bg-brand-500 opacity-100 dark:bg-brand-400'
                                    : 'opacity-0'"
                            ></span>

                            <!-- Flag -->
                            <img
                                :src="'/images/icons/' + language.flag"
                                :alt="language.name"
                                class="size-5 shrink-0 overflow-hidden rounded-full object-cover"
                            />

                            <!-- Language Name -->
                            <span
                                class="truncate"
                                x-text="language.name"
                            ></span>

                        </button>

                    </template>

                </div>

            </li>

        </ul>


        <!-- =========================
             Sign Out
        ========================== -->
        <form
            method="POST"
            action="{{ route('logout') }}"
        >
            @csrf

            <button
                type="submit"
                @click="closeDropdown()"
                class="flex items-center w-full gap-3 px-3 py-2 mt-3 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
            >

                <!-- Sign Out Icon -->
                <span
                    class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300"
                >

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M15 3H6C4.89543 3 4 3.89543 4 5V19C4 20.1046 4.89543 21 6 21H15M10 12H21M21 12L17 8M21 12L17 16"
                        />
                    </svg>

                </span>

                Sign Out

            </button>

        </form>

    </div>

</div>
