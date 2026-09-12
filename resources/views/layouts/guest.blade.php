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
        {{ config('app.name', 'URL Shortener') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body
    class="min-h-screen bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-white"
>
    <div class="flex min-h-screen">

        <!-- Left Side -->
        <div
            class="hidden w-1/2 bg-gray-900 lg:flex lg:flex-col lg:justify-between lg:p-12"
        >
            <div>
                <a
                    href="{{ url('/') }}"
                    class="text-2xl font-bold text-white"
                >
                    URL Shortener
                </a>

                <div class="mt-24 max-w-lg">
                    <h1 class="text-4xl font-bold leading-tight text-white">
                        Shorten your URLs.
                        <br>
                        Track every click.
                    </h1>

                    <p class="mt-6 text-lg leading-8 text-gray-300">
                        Create short, memorable links and manage your
                        link analytics from one powerful dashboard.
                    </p>
                </div>
            </div>

            <div class="text-sm text-gray-400">
                URL Shortener & QR Analytics Platform
            </div>
        </div>

        <!-- Right Side -->
        <div
            class="flex w-full items-center justify-center px-6 py-12 lg:w-1/2"
        >
            <div class="w-full max-w-md">

                <!-- Logo / Brand -->
                <div class="mb-8 text-center lg:hidden">
                    <a
                        href="{{ url('/') }}"
                        class="text-2xl font-bold text-gray-900 dark:text-white"
                    >
                        URL Shortener
                    </a>
                </div>

                <!-- Content -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-800 sm:p-8"
                >
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
                    © {{ date('Y') }} URL Shortener. All rights reserved.
                </p>

            </div>
        </div>

    </div>
</body>
</html>