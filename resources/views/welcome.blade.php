<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    <title>URL Shortener - Smart Link Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- ========================================================= --}}
    {{-- LANDING PAGE ONLY CSS --}}
    {{-- This CSS affects ONLY welcome.blade.php --}}
    {{-- ========================================================= --}}

    <style>

        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;
            background: #ffffff;
            color: #111827;
        }

        .landing-page {
            overflow-x: hidden;
        }

        .hero-gradient {
            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(99, 102, 241, 0.12),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 20%,
                    rgba(59, 130, 246, 0.10),
                    transparent 30%
                ),
                linear-gradient(
                    180deg,
                    #f8faff 0%,
                    #ffffff 100%
                );
        }

        .generator-card {
            border: 1px solid #e5e7eb;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 24px;
            box-shadow:
                0 25px 60px rgba(15, 23, 42, 0.10),
                0 5px 15px rgba(15, 23, 42, 0.05);
            backdrop-filter: blur(12px);
        }

        .url-input {
            width: 100%;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 14px;
            padding: 16px 18px 16px 48px;
            font-size: 15px;
            outline: none;
            transition: all .2s ease;
            box-sizing: border-box;
        }

        .url-input:focus {
            border-color: #6366f1;
            background: #ffffff;
            box-shadow:
                0 0 0 4px rgba(99, 102, 241, 0.10);
        }

        .primary-generator-button {
            min-height: 52px;
            border: 0;
            border-radius: 14px;
            padding: 0 28px;
            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #6366f1
                );
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
            box-shadow:
                0 10px 25px rgba(79, 70, 229, 0.25);
        }

        .primary-generator-button:hover {
            transform: translateY(-1px);
            box-shadow:
                0 14px 30px rgba(79, 70, 229, 0.32);
        }

        .qr-generator-button {
            min-height: 52px;
            border: 1px solid #e0e7ff;
            border-radius: 14px;
            background: #f8faff;
            color: #4f46e5;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
        }

        .qr-generator-button:hover {
            background: #eef2ff;
            border-color: #c7d2fe;
            transform: translateY(-1px);
        }

        .result-card {
            border: 1px solid #dbeafe;
            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f8faff
                );
            border-radius: 24px;
            box-shadow:
                0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .short-url-box {
            display: flex;
            align-items: stretch;
            gap: 10px;
            padding: 6px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            border-radius: 15px;
        }

        .short-url-input {
            min-width: 0;
            flex: 1;
            border: 0;
            background: transparent;
            padding: 12px;
            color: #4f46e5;
            font-size: 15px;
            font-weight: 700;
            outline: none;
        }

        .copy-button {
            flex-shrink: 0;
            border: 0;
            border-radius: 11px;
            background: #111827;
            color: white;
            padding: 0 20px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
        }

        .copy-button:hover {
            background: #1f2937;
        }

        .success-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #dcfce7;
            color: #16a34a;
            font-weight: 800;
        }

        .qr-result-box {
            border: 1px solid #e0e7ff;
            background: #eef2ff;
            border-radius: 16px;
            padding: 18px;
        }

        .download-qr-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 12px;
            background: #4f46e5;
            color: white;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s ease;
        }

        .download-qr-button:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .feature-card {
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 20px;
            padding: 28px;
            transition: all .25s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 20px 40px rgba(15, 23, 42, 0.08);
            border-color: #dbeafe;
        }

        .step-card {
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            margin: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background:
                linear-gradient(
                    135deg,
                    #4f46e5,
                    #6366f1
                );
            color: white;
            font-size: 20px;
            font-weight: 800;
            box-shadow:
                0 12px 25px rgba(79, 70, 229, 0.22);
        }

        @media (max-width: 640px) {

            .short-url-box {
                flex-direction: column;
                padding: 8px;
            }

            .copy-button {
                min-height: 46px;
            }

            .primary-generator-button,
            .qr-generator-button {
                width: 100%;
            }

        }

    </style>

</head>


<body class="landing-page">


{{-- ========================================================= --}}
{{-- NAVBAR --}}
{{-- ========================================================= --}}

<header
    x-data="{ open: false }"
    class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 backdrop-blur"
>

    <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">

        <div class="flex h-20 items-center justify-between">

            {{-- Logo --}}
            <a
                href="{{ route('home') }}"
                class="flex items-center gap-3"
            >

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-xl font-bold text-white shadow-sm"
                >
                    Q
                </div>

                <div>

                    <div class="text-lg font-bold tracking-tight text-gray-900">
                        URL Shortener
                    </div>

                    <div class="text-xs text-gray-500">
                        Smart Link Management
                    </div>

                </div>

            </a>


            {{-- Desktop navigation --}}
            <nav class="hidden items-center gap-8 md:flex">

                <a
                    href="#features"
                    class="text-sm font-medium text-gray-600 hover:text-indigo-600"
                >
                    Features
                </a>

                <a
                    href="#how-it-works"
                    class="text-sm font-medium text-gray-600 hover:text-indigo-600"
                >
                    How It Works
                </a>

                <a
                    href="#analytics"
                    class="text-sm font-medium text-gray-600 hover:text-indigo-600"
                >
                    Analytics
                </a>

            </nav>


            {{-- Auth --}}
            <div class="hidden items-center gap-4 md:flex">

                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="text-sm font-semibold text-gray-700 hover:text-indigo-600"
                    >
                        Dashboard
                    </a>

                    <a
                        href="{{ route('links.create') }}"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
                    >
                        Create Link
                    </a>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="text-sm font-semibold text-gray-700 hover:text-indigo-600"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
                    >
                        Sign Up
                    </a>

                @endauth

            </div>


            {{-- Mobile --}}
            <button
                type="button"
                @click="open = !open"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-700 md:hidden"
            >

                <svg
                    x-show="!open"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

                <svg
                    x-show="open"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

            </button>

        </div>


        {{-- Mobile navigation --}}
        <div
            x-show="open"
            x-cloak
            class="border-t border-gray-100 py-5 md:hidden"
        >

            <nav class="flex flex-col gap-4">

                <a href="#features" class="text-sm text-gray-600">
                    Features
                </a>

                <a href="#how-it-works" class="text-sm text-gray-600">
                    How It Works
                </a>

                <a href="#analytics" class="text-sm text-gray-600">
                    Analytics
                </a>

                @guest

                    <a
                        href="{{ route('login') }}"
                        class="text-sm font-semibold text-gray-700"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="rounded-lg bg-indigo-600 px-5 py-3 text-center text-sm font-semibold text-white"
                    >
                        Sign Up
                    </a>

                @else

                    <a
                        href="{{ route('dashboard') }}"
                        class="text-sm font-semibold text-gray-700"
                    >
                        Dashboard
                    </a>

                @endguest

            </nav>

        </div>

    </div>

</header>



{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

<section class="hero-gradient relative overflow-hidden">

    <div class="mx-auto max-w-7xl px-5 py-20 sm:px-6 lg:px-8 lg:py-28">

        <div class="mx-auto max-w-4xl text-center">

            {{-- Badge --}}
            <div
                class="mb-7 inline-flex items-center gap-2 rounded-full border border-indigo-100 bg-white px-4 py-2 text-sm font-medium text-indigo-700 shadow-sm"
            >

                <span class="h-2 w-2 rounded-full bg-indigo-600"></span>

                Simple. Fast. Powerful.

            </div>


            {{-- Heading --}}
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">

                Shorten URLs.

                <span class="text-indigo-600">
                    Share Smarter.
                </span>

            </h1>


            {{-- Description --}}
            <p class="mx-auto mt-6 max-w-2xl text-base leading-7 text-gray-600 sm:text-lg">

                Create short, memorable links in seconds.
                Generate QR codes, track clicks, manage your links,
                and understand your audience from one powerful platform.

            </p>



            {{-- ================================================= --}}
            {{-- URL GENERATOR --}}
            {{-- ================================================= --}}

            <div
                class="mx-auto mt-10 max-w-4xl"
                x-data="{
                    url: @js(old('original_url', '')),
                    copied: false
                }"
            >

                <div class="generator-card p-4 sm:p-5">

                    {{-- Main Short URL Form --}}
                    <form
                        method="POST"
                        action="{{ route('links.store') }}"
                    >

                        @csrf

                        <div class="flex flex-col gap-3 sm:flex-row">

                            <div class="relative flex-1">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.828 10.172a4 4 0 015.656 0l.344.344a4 4 0 010 5.656l-3.172 3.172a4 4 0 01-5.656 0l-.344-.344a4 4 0 010-5.656m3.172-3.172a4 4 0 00-5.656 0L5 13.344a4 4 0 000 5.656l.344.344a4 4 0 005.656 0l3.172-3.172"
                                    />

                                </svg>

                                <input
                                    type="url"
                                    name="original_url"
                                    x-model="url"
                                    placeholder="Paste your long URL here..."
                                    required
                                    class="url-input"
                                >

                            </div>


                            <button
                                type="submit"
                                class="primary-generator-button"
                            >
                                Shorten URL
                            </button>

                        </div>

                    </form>



                    {{-- QR Form --}}
                    <form
                        method="POST"
                        action="{{ route('qr-codes.guest.generate') }}"
                        class="mt-3"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="original_url"
                            :value="url"
                        >

                        <button
                            type="submit"
                            class="qr-generator-button flex w-full items-center justify-center gap-2"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 4h3m0 0v3m0-3h3m-3 0v-3"
                                />

                            </svg>

                            Generate QR Code

                        </button>

                    </form>

                </div>



                {{-- Validation Error --}}
                @error('original_url')

                    <p class="mt-3 text-left text-sm font-medium text-red-600">
                        {{ $message }}
                    </p>

                @enderror


                <p class="mt-4 text-sm text-gray-500">

                    No registration required to create a basic short URL.

                </p>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- GENERATED RESULT --}}
{{-- ========================================================= --}}

@if(session('guest_short_url') || session('short_url') || session('guest_qr'))

<section class="bg-white px-5 py-12 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-3xl">

        <div class="result-card overflow-hidden">

            <div class="border-b border-gray-100 px-6 py-5 sm:px-8">

                <div class="flex items-center gap-4">

                    <div class="success-icon">

                        ✓

                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-gray-900">

                            Your result is ready

                        </h2>

                        <p class="mt-1 text-sm text-gray-500">

                            Your URL has been processed successfully.

                        </p>

                    </div>

                </div>

            </div>


            <div class="space-y-6 p-6 sm:p-8">


                {{-- ================================================= --}}
                {{-- SHORT URL --}}
                {{-- ================================================= --}}

                @if(session('guest_short_url') || session('short_url'))

                    <div>

                        <label class="mb-2 block text-sm font-bold text-gray-700">

                            Your Short URL

                        </label>


                        <div
                            class="short-url-box"
                            x-data="{ copied: false }"
                        >

                            <input
                                id="generated-short-url"
                                type="text"
                                readonly
                                value="{{ session('guest_short_url') ?? session('short_url') }}"
                                class="short-url-input"
                            >


                            <button
                                type="button"
                                class="copy-button"
                                @click="
                                    navigator.clipboard.writeText(
                                        document.getElementById('generated-short-url').value
                                    ).then(() => {
                                        copied = true;
                                        setTimeout(() => copied = false, 2000);
                                    });
                                "
                            >

                                <span x-text="copied ? 'Copied!' : 'Copy'">
                                    Copy
                                </span>

                            </button>

                        </div>


                        <div class="mt-3 flex items-center gap-2 text-sm text-green-600">

                            <span>✓</span>

                            <span>
                                Short URL created successfully.
                            </span>

                        </div>

                    </div>

                @endif



                {{-- ================================================= --}}
                {{-- QR RESULT --}}
                {{-- ================================================= --}}

                @if(session('guest_qr'))

                    <div class="qr-result-box">

                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <div class="flex items-center gap-2">

                                    <div class="text-lg">
                                        ▦
                                    </div>

                                    <h3 class="font-bold text-gray-900">
                                        QR Code Ready
                                    </h3>

                                </div>

                                <p class="mt-1 text-sm text-gray-600">

                                    Your QR code contains the original URL.

                                </p>

                            </div>


                            <a
                                href="{{ route('qr-codes.guest.download') }}"
                                class="download-qr-button"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                                    />

                                </svg>

                                Download QR Code

                            </a>

                        </div>

                    </div>

                @endif


            </div>

        </div>

    </div>

</section>

@endif



{{-- ========================================================= --}}
{{-- TRUST --}}
{{-- ========================================================= --}}

<section class="border-y border-gray-100 bg-white">

    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8">

        <div class="grid gap-10 text-center sm:grid-cols-3">

            <div>

                <div class="text-3xl font-bold text-gray-900">
                    Fast
                </div>

                <p class="mt-2 text-sm text-gray-500">
                    Create short links in seconds.
                </p>

            </div>


            <div>

                <div class="text-3xl font-bold text-gray-900">
                    Secure
                </div>

                <p class="mt-2 text-sm text-gray-500">
                    Keep your links organized and protected.
                </p>

            </div>


            <div>

                <div class="text-3xl font-bold text-gray-900">
                    Powerful
                </div>

                <p class="mt-2 text-sm text-gray-500">
                    Understand clicks and audience activity.
                </p>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- FEATURES --}}
{{-- ========================================================= --}}

<section
    id="features"
    class="bg-gray-50 px-5 py-20 sm:px-6 lg:px-8"
>

    <div class="mx-auto max-w-7xl">

        <div class="mx-auto max-w-2xl text-center">

            <p class="text-sm font-bold uppercase tracking-wider text-indigo-600">
                Powerful Features
            </p>

            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Everything you need to manage your links
            </h2>

            <p class="mt-4 text-base leading-7 text-gray-600">
                From simple URL shortening to advanced analytics,
                everything is available in one place.
            </p>

        </div>


        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">


            <div class="feature-card">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                    🔗
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Short Links
                </h3>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Turn long URLs into clean and memorable links.
                </p>

            </div>


            <div class="feature-card">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                    ▦
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    QR Codes
                </h3>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Generate downloadable QR codes for your URLs.
                </p>

            </div>


            <div class="feature-card">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                    ↗
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Analytics
                </h3>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Track clicks and understand your link performance.
                </p>

            </div>


            <div class="feature-card">

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-orange-600">
                    🔒
                </div>

                <h3 class="mt-6 text-lg font-bold text-gray-900">
                    Link Security
                </h3>

                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Protect links with passwords and expiration.
                </p>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- ANALYTICS --}}
{{-- ========================================================= --}}

<section
    id="analytics"
    class="bg-white px-5 py-20 sm:px-6 lg:px-8"
>

    <div class="mx-auto max-w-7xl">

        <div class="grid items-center gap-14 lg:grid-cols-2">

            <div>

                <p class="text-sm font-bold uppercase tracking-wider text-indigo-600">
                    Link Analytics
                </p>

                <h2 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Know how your links are performing
                </h2>

                <p class="mt-5 text-base leading-7 text-gray-600">

                    Registered users can monitor link performance
                    through a centralized analytics dashboard.

                </p>

                <div class="mt-8 space-y-5">

                    <div class="flex gap-4">

                        <div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                            ✓
                        </div>

                        <div>

                            <h3 class="font-semibold text-gray-900">
                                Click Tracking
                            </h3>

                            <p class="mt-1 text-sm text-gray-600">
                                Monitor how many times your links are opened.
                            </p>

                        </div>

                    </div>


                    <div class="flex gap-4">

                        <div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                            ✓
                        </div>

                        <div>

                            <h3 class="font-semibold text-gray-900">
                                Organized Dashboard
                            </h3>

                            <p class="mt-1 text-sm text-gray-600">
                                Manage your links and statistics from one place.
                            </p>

                        </div>

                    </div>


                    <div class="flex gap-4">

                        <div class="mt-1 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                            ✓
                        </div>

                        <div>

                            <h3 class="font-semibold text-gray-900">
                                Detailed Insights
                            </h3>

                            <p class="mt-1 text-sm text-gray-600">
                                Understand your audience and link usage.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Dashboard preview --}}
            <div>

                <div class="rounded-3xl border border-gray-200 bg-gray-50 p-4 shadow-xl">

                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">

                            <div>

                                <div class="text-sm font-bold text-gray-900">
                                    Link Analytics
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    Performance overview
                                </div>

                            </div>

                            <div class="rounded-lg bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-600">
                                Last 30 days
                            </div>

                        </div>


                        <div class="grid grid-cols-3 gap-3 p-5">

                            <div class="rounded-xl bg-gray-50 p-4">

                                <div class="text-xs text-gray-500">
                                    Total Clicks
                                </div>

                                <div class="mt-2 text-xl font-bold text-gray-900">
                                    12,480
                                </div>

                                <div class="mt-1 text-xs font-medium text-green-600">
                                    +18.4%
                                </div>

                            </div>


                            <div class="rounded-xl bg-gray-50 p-4">

                                <div class="text-xs text-gray-500">
                                    Active Links
                                </div>

                                <div class="mt-2 text-xl font-bold text-gray-900">
                                    248
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    Currently active
                                </div>

                            </div>


                            <div class="rounded-xl bg-gray-50 p-4">

                                <div class="text-xs text-gray-500">
                                    QR Codes
                                </div>

                                <div class="mt-2 text-xl font-bold text-gray-900">
                                    86
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    Generated
                                </div>

                            </div>

                        </div>


                        <div class="px-5 pb-6">

                            <div class="rounded-xl border border-gray-100 bg-white p-4">

                                <div class="mb-5 flex items-center justify-between">

                                    <div class="text-sm font-semibold text-gray-900">
                                        Click Activity
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        Weekly
                                    </div>

                                </div>


                                <div class="flex h-40 items-end gap-2">

                                    <div class="h-[35%] flex-1 rounded-t-md bg-indigo-100"></div>
                                    <div class="h-[48%] flex-1 rounded-t-md bg-indigo-200"></div>
                                    <div class="h-[42%] flex-1 rounded-t-md bg-indigo-300"></div>
                                    <div class="h-[68%] flex-1 rounded-t-md bg-indigo-400"></div>
                                    <div class="h-[55%] flex-1 rounded-t-md bg-indigo-500"></div>
                                    <div class="h-[82%] flex-1 rounded-t-md bg-indigo-600"></div>
                                    <div class="h-[72%] flex-1 rounded-t-md bg-indigo-500"></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- HOW IT WORKS --}}
{{-- ========================================================= --}}

<section
    id="how-it-works"
    class="bg-gray-50 px-5 py-20 sm:px-6 lg:px-8"
>

    <div class="mx-auto max-w-7xl">

        <div class="mx-auto max-w-2xl text-center">

            <p class="text-sm font-bold uppercase tracking-wider text-indigo-600">
                How It Works
            </p>

            <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Three simple steps
            </h2>

        </div>


        <div class="mt-14 grid gap-10 md:grid-cols-3">

            <div class="step-card text-center">

                <div class="step-number">
                    1
                </div>

                <h3 class="mt-6 text-xl font-bold text-gray-900">
                    Paste Your URL
                </h3>

                <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-gray-600">
                    Enter the long URL you want to shorten or convert into a QR code.
                </p>

            </div>


            <div class="step-card text-center">

                <div class="step-number">
                    2
                </div>

                <h3 class="mt-6 text-xl font-bold text-gray-900">
                    Generate
                </h3>

                <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-gray-600">
                    Generate a short URL or QR code instantly.
                </p>

            </div>


            <div class="step-card text-center">

                <div class="step-number">
                    3
                </div>

                <h3 class="mt-6 text-xl font-bold text-gray-900">
                    Share & Track
                </h3>

                <p class="mx-auto mt-3 max-w-xs text-sm leading-6 text-gray-600">
                    Share your links and track their performance.
                </p>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- CTA --}}
{{-- ========================================================= --}}

<section class="px-5 py-20 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-6xl rounded-3xl bg-indigo-600 px-7 py-14 text-center shadow-xl sm:px-12">

        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
            Ready to manage your links smarter?
        </h2>

        <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-indigo-100">
            Create an account to unlock advanced link management,
            analytics, QR codes, reports, and more.
        </p>


        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">

            @auth

                <a
                    href="{{ route('dashboard') }}"
                    class="rounded-xl bg-white px-7 py-3.5 text-sm font-bold text-indigo-600 hover:bg-gray-100"
                >
                    Go to Dashboard
                </a>

                <a
                    href="{{ route('links.create') }}"
                    class="rounded-xl border border-indigo-400 px-7 py-3.5 text-sm font-bold text-white hover:bg-indigo-700"
                >
                    Create a Link
                </a>

            @else

                <a
                    href="{{ route('register') }}"
                    class="rounded-xl bg-white px-7 py-3.5 text-sm font-bold text-indigo-600 hover:bg-gray-100"
                >
                    Create Free Account
                </a>

                <a
                    href="{{ route('login') }}"
                    class="rounded-xl border border-indigo-400 px-7 py-3.5 text-sm font-bold text-white hover:bg-indigo-700"
                >
                    Login
                </a>

            @endauth

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="border-t border-gray-100 bg-white">

    <div class="mx-auto max-w-7xl px-5 py-12 sm:px-6 lg:px-8">

        <div class="grid gap-10 md:grid-cols-4">

            <div class="md:col-span-2">

                <a
                    href="{{ route('home') }}"
                    class="flex items-center gap-3"
                >

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 font-bold text-white">
                        Q
                    </div>

                    <div>

                        <div class="font-bold text-gray-900">
                            URL Shortener
                        </div>

                        <div class="text-xs text-gray-500">
                            Smart Link Management
                        </div>

                    </div>

                </a>

                <p class="mt-5 max-w-md text-sm leading-6 text-gray-500">
                    A simple and powerful platform for shortening,
                    managing, sharing, and analyzing your links.
                </p>

            </div>


            <div>

                <h3 class="text-sm font-bold text-gray-900">
                    Product
                </h3>

                <div class="mt-5 space-y-3">

                    <a
                        href="#features"
                        class="block text-sm text-gray-500 hover:text-indigo-600"
                    >
                        Features
                    </a>

                    <a
                        href="#analytics"
                        class="block text-sm text-gray-500 hover:text-indigo-600"
                    >
                        Analytics
                    </a>

                    <a
                        href="#how-it-works"
                        class="block text-sm text-gray-500 hover:text-indigo-600"
                    >
                        How It Works
                    </a>

                    <a
                        href="{{ route('links.create') }}"
                        class="block text-sm text-gray-500 hover:text-indigo-600"
                    >
                        Create Link
                    </a>

                </div>

            </div>


            <div>

                <h3 class="text-sm font-bold text-gray-900">
                    Account
                </h3>

                <div class="mt-5 space-y-3">

                    @auth

                        <a
                            href="{{ route('dashboard') }}"
                            class="block text-sm text-gray-500 hover:text-indigo-600"
                        >
                            Dashboard
                        </a>

                        <a
                            href="{{ route('settings') }}"
                            class="block text-sm text-gray-500 hover:text-indigo-600"
                        >
                            Settings
                        </a>

                    @else

                        <a
                            href="{{ route('login') }}"
                            class="block text-sm text-gray-500 hover:text-indigo-600"
                        >
                            Login
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="block text-sm text-gray-500 hover:text-indigo-600"
                        >
                            Sign Up
                        </a>

                    @endauth

                </div>

            </div>

        </div>


        <div class="mt-10 border-t border-gray-100 pt-8">

            <div class="flex flex-col gap-3 text-sm text-gray-500 sm:flex-row sm:items-center sm:justify-between">

                <p>
                    © {{ date('Y') }} URL Shortener. All rights reserved.
                </p>

                <p>
                    Smart Link Management
                </p>

            </div>

        </div>

    </div>

</footer>


</body>
</html>