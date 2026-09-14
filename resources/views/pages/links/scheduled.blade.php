<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Short URL Not Active</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

<div class="flex min-h-screen items-center justify-center bg-white px-4 dark:bg-gray-950">

    <div class="text-center">

        <div class="text-7xl font-bold text-gray-800 dark:text-white/90">
            403
        </div>

        <h1 class="mt-4 text-xl font-medium text-gray-800 dark:text-white/90">
            This short URL is not active yet.
        </h1>

        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Please try again later.
        </p>

    </div>

</div>

</body>

</html>