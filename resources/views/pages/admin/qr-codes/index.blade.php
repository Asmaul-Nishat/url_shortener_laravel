@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

    {{-- Page Header --}}
    <div class="mb-6">

        <div class="mb-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">

            <a
                href="{{ route('admin.dashboard') }}"
                class="hover:text-brand-500"
            >
                Admin Dashboard
            </a>

            <span>/</span>

            <span class="text-gray-700 dark:text-gray-300">
                QR Codes
            </span>

        </div>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                    All QR Codes
                </h1>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage QR codes generated for all users' short URLs.
                </p>

            </div>

            <a
                href="{{ route('admin.qr-codes.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600"
            >

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                Create QR

            </a>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-success-200 bg-success-50 px-4 py-4 dark:border-success-500/30 dark:bg-success-500/10">

            <p class="text-sm font-medium text-success-700 dark:text-success-400">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-4 dark:border-error-500/30 dark:bg-error-500/10">

            <p class="text-sm font-medium text-error-700 dark:text-error-400">
                {{ session('error') }}
            </p>

        </div>

    @endif


    {{-- QR Codes Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                QR Code Library
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                All QR codes created by users and administrators.
            </p>

        </div>


        @if($qrCodes->count())

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead>

                        <tr class="border-b border-gray-200 dark:border-gray-800">

                            <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                ID
                            </th>

                            <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                User
                            </th>

                            <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Short URL
                            </th>

                            <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Size
                            </th>

                            <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Colors
                            </th>

                            <th class="whitespace-nowrap px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Created
                            </th>

                            <th class="whitespace-nowrap px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                        @foreach($qrCodes as $qrCode)

                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                                {{-- ID --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        #{{ $qrCode->id }}
                                    </span>

                                </td>


                                {{-- User --}}
                                <td class="px-6 py-4">

                                    @if($qrCode->shortUrl?->user)

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-sm font-semibold text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">

                                                {{ strtoupper(
                                                    substr(
                                                        $qrCode->shortUrl->user->name ?? 'U',
                                                        0,
                                                        1
                                                    )
                                                ) }}

                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                                    {{ $qrCode->shortUrl->user->name }}
                                                </p>

                                                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $qrCode->shortUrl->user->email }}
                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            Unknown User
                                        </span>

                                    @endif

                                </td>


                                {{-- Short URL --}}
                                <td class="max-w-xs px-6 py-4">

                                    @if($qrCode->shortUrl)

                                        <div>

                                            <p class="truncate text-sm font-medium text-brand-600 dark:text-brand-400">
                                                {{ $qrCode->shortUrl->short_url }}
                                            </p>

                                            <p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">
                                                {{ $qrCode->shortUrl->original_url }}
                                            </p>

                                        </div>

                                    @else

                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            Short URL unavailable
                                        </span>

                                    @endif

                                </td>


                                {{-- Size --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $qrCode->size }} × {{ $qrCode->size }}
                                    </span>

                                </td>


                                {{-- Colors --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-2">

                                        <span
                                            title="Foreground: {{ $qrCode->foreground_color }}"
                                            class="h-6 w-6 rounded-full border border-gray-300 dark:border-gray-600"
                                            style="background-color: {{ $qrCode->foreground_color }}"
                                        ></span>

                                        <span
                                            title="Background: {{ $qrCode->background_color }}"
                                            class="h-6 w-6 rounded-full border border-gray-300 dark:border-gray-600"
                                            style="background-color: {{ $qrCode->background_color }}"
                                        ></span>

                                    </div>

                                </td>


                                {{-- Created --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $qrCode->created_at?->format('M d, Y') }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center justify-end gap-2">


                                        {{-- PNG --}}
                                        <a
                                            href="{{ route('admin.qr-codes.download.png', $qrCode) }}"
                                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                                            title="Download PNG"
                                        >
                                            PNG
                                        </a>


                                        {{-- SVG --}}
                                        <a
                                            href="{{ route('admin.qr-codes.download.svg', $qrCode) }}"
                                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                                            title="Download SVG"
                                        >
                                            SVG
                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.qr-codes.destroy', $qrCode) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this QR code?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center rounded-lg border border-error-200 bg-error-50 px-3 py-2 text-xs font-medium text-error-700 hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20"
                                                title="Delete QR Code"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($qrCodes->hasPages())

                <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                    {{ $qrCodes->links() }}

                </div>

            @endif

        @else

            {{-- Empty State --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">

                    <svg
                        class="h-8 w-8 text-gray-500 dark:text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h18v18H3V3zm4 4h10v10H7V7zm2 2v6m6-6v6m-3-6v6"
                        />
                    </svg>

                </div>

                <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white/90">
                    No QR codes found
                </h3>

                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Create your first QR code for a user's short URL.
                </p>

                <div class="mt-6">

                    <a
                        href="{{ route('admin.qr-codes.create') }}"
                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                    >
                        Create QR Code
                    </a>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection