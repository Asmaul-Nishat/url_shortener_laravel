<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
>
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ $title ?? config('app.name', 'URL Shortener') }}
    </title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ========================================= --}}
    {{-- Alpine Stores                             --}}
    {{-- ========================================= --}}

    <script>
        document.addEventListener('alpine:init', () => {

            /*
            |--------------------------------------------------------------------------
            | Theme Store
            |--------------------------------------------------------------------------
            */

            Alpine.store('theme', {

                theme: 'light',

                init() {
                    const savedTheme = localStorage.getItem('theme');

                    this.theme = savedTheme === 'dark'
                        ? 'dark'
                        : 'light';

                    this.updateTheme();
                },

                toggle() {

                    this.theme =
                        this.theme === 'light'
                            ? 'dark'
                            : 'light';

                    localStorage.setItem(
                        'theme',
                        this.theme
                    );

                    this.updateTheme();
                },

                updateTheme() {

                    const html =
                        document.documentElement;

                    if (this.theme === 'dark') {

                        html.classList.add('dark');

                    } else {

                        html.classList.remove('dark');

                    }
                }
            });


            /*
            |--------------------------------------------------------------------------
            | Sidebar Store
            |--------------------------------------------------------------------------
            */

            Alpine.store('sidebar', {

                isExpanded:
                    window.innerWidth >= 1280,

                isMobileOpen: false,

                isHovered: false,


                /*
                |--------------------------------------------------------------------------
                | Desktop Sidebar
                |--------------------------------------------------------------------------
                */

                toggleExpanded() {

                    this.isExpanded =
                        !this.isExpanded;

                    this.isMobileOpen = false;
                },


                /*
                |--------------------------------------------------------------------------
                | Mobile Sidebar
                |--------------------------------------------------------------------------
                */

                toggleMobileOpen() {

                    this.isMobileOpen =
                        !this.isMobileOpen;
                },


                setMobileOpen(value) {

                    this.isMobileOpen = value;
                },


                /*
                |--------------------------------------------------------------------------
                | Collapsed Sidebar Hover
                |--------------------------------------------------------------------------
                */

                setHovered(value) {

                    if (
                        window.innerWidth >= 1280 &&
                        !this.isExpanded
                    ) {

                        this.isHovered = value;

                    }

                }

            });

        });
    </script>


    {{-- ========================================= --}}
    {{-- Theme + Direction Initialization           --}}
    {{-- ========================================= --}}

    <script>
        (function () {

            /*
            |--------------------------------------------------------------------------
            | Theme
            |--------------------------------------------------------------------------
            */

            const savedTheme =
                localStorage.getItem('theme');

            if (savedTheme === 'dark') {

                document.documentElement
                    .classList.add('dark');

            } else {

                document.documentElement
                    .classList.remove('dark');

            }


            /*
            |--------------------------------------------------------------------------
            | Direction
            |--------------------------------------------------------------------------
            */

            const savedDir =
                localStorage.getItem('dir');

            document.documentElement.setAttribute(
                'dir',
                savedDir === 'rtl'
                    ? 'rtl'
                    : 'ltr'
            );

        })();
    </script>

</head>


<body
    class="min-h-screen bg-gray-50 dark:bg-gray-900"
    x-data
    x-init="
        $store.theme.init();

        const checkMobile = () => {

            if (window.innerWidth < 1280) {

                $store.sidebar.setMobileOpen(false);

                $store.sidebar.isExpanded = false;

            } else {

                $store.sidebar.isMobileOpen = false;

                $store.sidebar.isExpanded = true;

            }

        };

        window.addEventListener(
            'resize',
            checkMobile
        );
    "
>

    {{-- ========================================= --}}
    {{-- Guest Pages                               --}}
    {{-- ========================================= --}}

    @guest

        @yield('content')

    @else

        {{-- ========================================= --}}
        {{-- TailAdmin Sidebar                        --}}
        {{-- ========================================= --}}

        @include('layouts.sidebar')


        {{-- ========================================= --}}
        {{-- Main Application Area                     --}}
        {{-- ========================================= --}}

        <div
            class="min-h-screen transition-all duration-300"
            :class="
                $store.sidebar.isExpanded
                    ? 'xl:ml-[290px]'
                    : 'xl:ml-[90px]'
            "
        >

            {{-- ========================================= --}}
            {{-- Header                                    --}}
            {{-- ========================================= --}}

            @include('layouts.app-header')


            {{-- ========================================= --}}
            {{-- Page Content                              --}}
            {{-- ========================================= --}}

            <main
                class="mx-auto max-w-screen-2xl p-4 md:p-6"
            >

                @yield('content')

            </main>

        </div>


        {{-- ========================================= --}}
        {{-- Mobile Sidebar Backdrop                    --}}
        {{-- ========================================= --}}

        @include('layouts.backdrop')

    @endguest


    {{-- ========================================= --}}
    {{-- Additional Page Scripts                  --}}
    {{-- ========================================= --}}

    @stack('scripts')

</body>
</html>