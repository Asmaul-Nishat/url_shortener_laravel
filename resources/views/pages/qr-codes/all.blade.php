@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">


{{-- Alerts --}}
@if(session('success'))

    <div class="mb-6 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400">
        {{ session('error') }}
    </div>

@endif


{{-- Page Header --}}
<div class="mb-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                All QR Codes
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                View and manage all QR codes you have created.
            </p>

        </div>


        <a
            href="{{ route('qr-codes.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
        >

            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
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


{{-- QR Codes Card --}}
<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

    {{-- Card Header --}}
    <div class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 dark:border-gray-800 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Your QR Codes
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                All QR codes generated from your short links.
            </p>

        </div>


        <div class="rounded-lg bg-gray-100 px-3 py-2 text-sm font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

            {{ $qrCodes->total() }}

            {{ $qrCodes->total() === 1 ? 'QR Code' : 'QR Codes' }}

        </div>

    </div>


    {{-- Desktop Table --}}
    <div class="hidden overflow-x-auto lg:block">

        <table class="w-full">

            <thead>

                <tr class="border-b border-gray-200 dark:border-gray-800">

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        QR Code
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Short Link
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Size
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Colors
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Logo
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Created
                    </th>

                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                @forelse($qrCodes as $qrCode)

                    <tr class="transition hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                        {{-- QR Preview --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-xl border border-gray-200 bg-white p-1 dark:border-gray-700 dark:bg-gray-900">

                                    @php

                                        $previewQr = new \Endroid\QrCode\QrCode(
                                            data: $qrCode->shortUrl->short_url,
                                            encoding: new \Endroid\QrCode\Encoding\Encoding('UTF-8'),
                                            errorCorrectionLevel: \Endroid\QrCode\ErrorCorrectionLevel::High,
                                            size: 120,
                                            margin: 8,
                                            roundBlockSizeMode: \Endroid\QrCode\RoundBlockSizeMode::Margin,
                                            foregroundColor: new \Endroid\QrCode\Color\Color(
                                                hexdec(substr(ltrim($qrCode->foreground_color, '#'), 0, 2)),
                                                hexdec(substr(ltrim($qrCode->foreground_color, '#'), 2, 2)),
                                                hexdec(substr(ltrim($qrCode->foreground_color, '#'), 4, 2))
                                            ),
                                            backgroundColor: new \Endroid\QrCode\Color\Color(
                                                hexdec(substr(ltrim($qrCode->background_color, '#'), 0, 2)),
                                                hexdec(substr(ltrim($qrCode->background_color, '#'), 2, 2)),
                                                hexdec(substr(ltrim($qrCode->background_color, '#'), 4, 2))
                                            )
                                        );

                                        $previewWriter = new \Endroid\QrCode\Writer\PngWriter();

                                        $previewResult = $previewWriter->write(
                                            $previewQr
                                        );

                                        $previewQrImage =
                                            'data:image/png;base64,' .
                                            base64_encode(
                                                $previewResult->getString()
                                            );

                                    @endphp


                                    <img
                                        src="{{ $previewQrImage }}"
                                        alt="QR Code"
                                        class="h-full w-full object-contain"
                                    >

                                </div>


                                <div>

                                    <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                        QR #{{ $qrCode->id }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $qrCode->created_at->format('M d, Y') }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Short Link --}}
                        <td class="max-w-xs px-6 py-4">

                            @if($qrCode->shortUrl)

                                <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $qrCode->shortUrl->short_url }}
                                </p>


                                <p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">
                                    {{ $qrCode->shortUrl->custom_alias ?: $qrCode->shortUrl->short_code }}
                                </p>

                            @else

                                <span class="text-sm text-gray-400">
                                    Link unavailable
                                </span>

                            @endif

                        </td>


                        {{-- Size --}}
                        <td class="px-6 py-4">

                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                {{ $qrCode->size }} px
                            </span>

                        </td>


                        {{-- Colors --}}
                        <td class="px-6 py-4">

                            <div class="flex flex-wrap gap-2">

                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                    <span
                                        class="h-3 w-3 rounded-full border border-gray-300"
                                        style="background-color: {{ $qrCode->foreground_color }}"
                                    ></span>

                                    FG

                                </span>


                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                    <span
                                        class="h-3 w-3 rounded-full border border-gray-300"
                                        style="background-color: {{ $qrCode->background_color }}"
                                    ></span>

                                    BG

                                </span>

                            </div>

                        </td>


                        {{-- Logo --}}
                        <td class="px-6 py-4">

                            @if($qrCode->logo_path)

                                <span class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    Included
                                </span>

                            @else

                                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                    None
                                </span>

                            @endif

                        </td>


                        {{-- Created --}}
                        <td class="whitespace-nowrap px-6 py-4">

                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                {{ $qrCode->created_at->format('M d, Y') }}
                            </p>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $qrCode->created_at->format('h:i A') }}
                            </p>

                        </td>


                        {{-- Actions --}}
                        <td class="px-6 py-4">

                            <div class="flex items-center justify-end gap-2">

                                @if($qrCode->shortUrl)

                                    <a
                                        href="{{ route('qr-codes.download.png', $qrCode) }}"
                                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-3 py-2 text-xs font-medium text-white transition hover:bg-brand-600"
                                        title="Download PNG"
                                    >
                                        PNG
                                    </a>


                                    <a
                                        href="{{ route('qr-codes.download.svg', $qrCode) }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                                        title="Download SVG"
                                    >
                                        SVG
                                    </a>

                                @endif


                                <form
                                    method="POST"
                                    action="{{ route('qr-codes.destroy', $qrCode) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this QR code?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-lg border border-error-200 bg-error-50 px-3 py-2 text-xs font-medium text-error-600 transition hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400"
                                        title="Delete QR Code"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="px-6 py-16"
                        >

                            <div class="text-center">

                                <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">

                                    <svg
                                        class="h-10 w-10 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z"
                                        />
                                    </svg>

                                </div>


                                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                                    No QR Codes Yet
                                </h3>


                                <p class="mx-auto mt-1 max-w-md text-sm text-gray-500 dark:text-gray-400">
                                    You have not generated any QR codes yet. Create your first QR code from one of your short links.
                                </p>


                                <a
                                    href="{{ route('qr-codes.create') }}"
                                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
                                >

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 4v16m8-8H4"
                                        />
                                    </svg>

                                    Create QR Code

                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Mobile Cards --}}
    <div class="divide-y divide-gray-200 lg:hidden dark:divide-gray-800">

        @forelse($qrCodes as $qrCode)

            <div class="p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-gray-200 bg-white p-1 dark:border-gray-700 dark:bg-gray-900">

                        @php

                            $mobilePreviewQr = new \Endroid\QrCode\QrCode(
                                data: $qrCode->shortUrl->short_url,
                                encoding: new \Endroid\QrCode\Encoding\Encoding('UTF-8'),
                                errorCorrectionLevel: \Endroid\QrCode\ErrorCorrectionLevel::High,
                                size: 140,
                                margin: 8,
                                roundBlockSizeMode: \Endroid\QrCode\RoundBlockSizeMode::Margin,
                                foregroundColor: new \Endroid\QrCode\Color\Color(
                                    hexdec(substr(ltrim($qrCode->foreground_color, '#'), 0, 2)),
                                    hexdec(substr(ltrim($qrCode->foreground_color, '#'), 2, 2)),
                                    hexdec(substr(ltrim($qrCode->foreground_color, '#'), 4, 2))
                                ),
                                backgroundColor: new \Endroid\QrCode\Color\Color(
                                    hexdec(substr(ltrim($qrCode->background_color, '#'), 0, 2)),
                                    hexdec(substr(ltrim($qrCode->background_color, '#'), 2, 2)),
                                    hexdec(substr(ltrim($qrCode->background_color, '#'), 4, 2))
                                )
                            );

                            $mobileWriter = new \Endroid\QrCode\Writer\PngWriter();

                            $mobileResult = $mobileWriter->write(
                                $mobilePreviewQr
                            );

                            $mobileQrImage =
                                'data:image/png;base64,' .
                                base64_encode(
                                    $mobileResult->getString()
                                );

                        @endphp


                        <img
                            src="{{ $mobileQrImage }}"
                            alt="QR Code"
                            class="h-full w-full object-contain"
                        >

                    </div>


                    <div class="min-w-0 flex-1">

                        <div class="flex items-start justify-between gap-3">

                            <div>

                                <p class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                    QR Code #{{ $qrCode->id }}
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $qrCode->created_at->format('M d, Y h:i A') }}
                                </p>

                            </div>


                            @if($qrCode->logo_path)

                                <span class="shrink-0 inline-flex items-center rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                    Logo
                                </span>

                            @endif

                        </div>


                        @if($qrCode->shortUrl)

                            <p class="mt-3 break-all text-sm font-medium text-gray-800 dark:text-white/90">
                                {{ $qrCode->shortUrl->short_url }}
                            </p>

                        @endif


                        <div class="mt-3 flex flex-wrap gap-2">

                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                {{ $qrCode->size }} px
                            </span>


                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                <span
                                    class="h-3 w-3 rounded-full border border-gray-300"
                                    style="background-color: {{ $qrCode->foreground_color }}"
                                ></span>

                                {{ $qrCode->foreground_color }}

                            </span>


                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                <span
                                    class="h-3 w-3 rounded-full border border-gray-300"
                                    style="background-color: {{ $qrCode->background_color }}"
                                ></span>

                                {{ $qrCode->background_color }}

                            </span>

                        </div>

                    </div>

                </div>


                <div class="mt-4 grid grid-cols-3 gap-2">

                    <a
                        href="{{ route('qr-codes.download.png', $qrCode) }}"
                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-3 py-2.5 text-xs font-medium text-white transition hover:bg-brand-600"
                    >
                        PNG
                    </a>


                    <a
                        href="{{ route('qr-codes.download.svg', $qrCode) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-xs font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
                    >
                        SVG
                    </a>


                    <form
                        method="POST"
                        action="{{ route('qr-codes.destroy', $qrCode) }}"
                        onsubmit="return confirm('Are you sure you want to delete this QR code?');"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center rounded-lg border border-error-200 bg-error-50 px-3 py-2.5 text-xs font-medium text-error-600 transition hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400"
                        >
                            Delete
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="px-6 py-16 text-center">

                <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">

                    <svg
                        class="h-10 w-10 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z"
                        />
                    </svg>

                </div>


                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                    No QR Codes Yet
                </h3>


                <p class="mx-auto mt-1 max-w-md text-sm text-gray-500 dark:text-gray-400">
                    You have not generated any QR codes yet.
                </p>


                <a
                    href="{{ route('qr-codes.create') }}"
                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-brand-600"
                >
                    Create QR Code
                </a>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if($qrCodes->hasPages())

        <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

            {{ $qrCodes->links() }}

        </div>

    @endif

</div>


</div>

@endsection
