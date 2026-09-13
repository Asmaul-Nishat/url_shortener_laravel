@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-7xl">

{{-- Alerts --}}
@if(session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-900/50 dark:bg-green-900/10 dark:text-green-400">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600 dark:border-red-900/50 dark:bg-red-900/10 dark:text-red-400">
        {{ $errors->first() }}
    </div>
@endif


{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
        QR Codes
    </h1>
</div>


{{-- ========================================================= --}}
{{-- QR GENERATOR --}}
{{-- ========================================================= --}}

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

    {{-- Generator --}}
    <div class="xl:col-span-2">

        <div
            x-data="{
                size: {{ old('size', 300) }},
                foreground: '{{ old('foreground_color', '#111827') }}',
                background: '{{ old('background_color', '#ffffff') }}',
                includeLogo: false,
                selectedLink: '{{ old('short_url_id', '') }}'
            }"
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
        >

            {{-- Generator Header --}}
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Generate QR Code
                </h2>

            </div>


            {{-- Generator Form --}}
            <form
                method="POST"
                action="{{ route('qr-codes.generate') }}"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="space-y-6 p-6">

                    {{-- Short Link --}}
                    <div>

                        <label
                            for="short_url_id"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Short Link
                        </label>

                        <select
                            id="short_url_id"
                            name="short_url_id"
                            x-model="selectedLink"
                            required
                            class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >

                            <option value="">
                                Select a short link
                            </option>

                            @if(isset($shortUrls) && $shortUrls->count())

                                @foreach($shortUrls as $shortUrl)

                                    <option
                                        value="{{ $shortUrl->id }}"
                                        data-url="{{ $shortUrl->short_url }}"
                                        @selected(old('short_url_id') == $shortUrl->id)
                                    >
                                        /{{ $shortUrl->custom_alias ?: $shortUrl->short_code }}
                                        — {{ \Illuminate\Support\Str::limit($shortUrl->original_url, 55) }}
                                    </option>

                                @endforeach

                            @else

                                <option value="" disabled>
                                    No short links available
                                </option>

                            @endif

                        </select>


                        {{-- Selected URL --}}
                        <div
                            x-show="selectedLink"
                            x-cloak
                            class="mt-3 rounded-lg bg-gray-50 px-4 py-3 dark:bg-white/[0.03]"
                        >

                            <p
                                class="break-all text-sm text-gray-600 dark:text-gray-300"
                                x-text="
                                    document.querySelector('#short_url_id option:checked')
                                        ?.getAttribute('data-url') || ''
                                "
                            ></p>

                        </div>

                    </div>


                    {{-- Size --}}
                    <div>

                        <div class="mb-3 flex items-center justify-between">

                            <label
                                for="size"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Size
                            </label>

                            <span
                                class="text-sm text-gray-500 dark:text-gray-400"
                                x-text="size + ' × ' + size + ' px'"
                            ></span>

                        </div>

                        <input
                            id="size"
                            type="range"
                            name="size"
                            min="150"
                            max="800"
                            step="50"
                            x-model="size"
                            class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700"
                        />

                    </div>


                    {{-- Colors --}}
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                        {{-- Foreground --}}
                        <div>

                            <label
                                for="foreground_color"
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Foreground
                            </label>

                            <div class="flex gap-3">

                                <input
                                    id="foreground_color"
                                    type="color"
                                    name="foreground_color"
                                    x-model="foreground"
                                    required
                                    class="h-11 w-14 cursor-pointer rounded-lg border border-gray-300 bg-white p-1 dark:border-gray-700 dark:bg-gray-900"
                                />

                                <input
                                    type="text"
                                    x-model="foreground"
                                    maxlength="7"
                                    class="h-11 flex-1 rounded-lg border border-gray-300 bg-white px-4 text-sm uppercase text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                />

                            </div>

                        </div>


                        {{-- Background --}}
                        <div>

                            <label
                                for="background_color"
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Background
                            </label>

                            <div class="flex gap-3">

                                <input
                                    id="background_color"
                                    type="color"
                                    name="background_color"
                                    x-model="background"
                                    required
                                    class="h-11 w-14 cursor-pointer rounded-lg border border-gray-300 bg-white p-1 dark:border-gray-700 dark:bg-gray-900"
                                />

                                <input
                                    type="text"
                                    x-model="background"
                                    maxlength="7"
                                    class="h-11 flex-1 rounded-lg border border-gray-300 bg-white px-4 text-sm uppercase text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                />

                            </div>

                        </div>

                    </div>


                    {{-- Logo --}}
                    <div class="rounded-xl border border-gray-200 p-4 dark:border-gray-800">

                        <div class="flex items-center justify-between">

                            <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">
                                Logo
                            </h3>

                            <button
                                type="button"
                                @click="includeLogo = !includeLogo"
                                :class="
                                    includeLogo
                                        ? 'bg-gray-800 dark:bg-white'
                                        : 'bg-gray-200 dark:bg-gray-700'
                                "
                                class="relative h-6 w-11 rounded-full transition"
                                :aria-pressed="includeLogo"
                            >

                                <span
                                    :class="
                                        includeLogo
                                            ? 'translate-x-5 bg-white dark:bg-gray-800'
                                            : 'translate-x-0.5 bg-white'
                                    "
                                    class="absolute top-0.5 h-5 w-5 rounded-full shadow-sm transition"
                                ></span>

                            </button>

                        </div>


                        {{-- Logo Upload --}}
                        <div
                            x-show="includeLogo"
                            x-cloak
                            class="mt-4"
                        >

                            <label
                                for="logo"
                                class="flex cursor-pointer items-center justify-center rounded-lg border border-dashed border-gray-300 px-4 py-6 dark:border-gray-700"
                            >

                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Choose logo
                                </span>

                                <input
                                    id="logo"
                                    type="file"
                                    name="logo"
                                    class="hidden"
                                    accept="image/png,image/jpeg,image/jpg"
                                />

                            </label>

                        </div>

                    </div>


                    {{-- Generate --}}
                    <div class="flex justify-end border-t border-gray-200 pt-6 dark:border-gray-800">

                        <button
                            type="submit"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-gray-800 px-5 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
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
                                    stroke-width="1.8"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>

                            Generate QR Code

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PREVIEW --}}
    {{-- ========================================================= --}}

    <div>

        <div class="h-full rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            {{-- Preview Header --}}
            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Preview
                </h2>

            </div>


            {{-- Preview Content --}}
            <div class="flex min-h-[420px] flex-col items-center justify-center p-6">

                @php

                    $selectedQrCode = null;

                    if (request()->filled('qr') && isset($qrCodes)) {

                        $selectedQrCode = $qrCodes->firstWhere(
                            'id',
                            (int) request('qr')
                        );

                    }

                @endphp


                @if($selectedQrCode)

                    {{-- QR Image --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800">

                        <img
                            src="{{ route('qr-codes.download.png', $selectedQrCode->id) }}"
                            alt="QR Code"
                            class="h-64 w-64 object-contain"
                        >

                    </div>


                    {{-- URL --}}
                    <div class="mt-5 text-center">

                        <p class="break-all text-sm font-medium text-gray-800 dark:text-white/90">
                            {{ $selectedQrCode->shortUrl->short_url }}
                        </p>

                    </div>


                    {{-- Preview Actions --}}
                    <div class="mt-5 flex w-full gap-3">

                        <a
                            href="{{ route('qr-codes.download.png', $selectedQrCode->id) }}"
                            class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:bg-white/[0.04]"
                        >
                            PNG
                        </a>

                        <a
                            href="{{ route('qr-codes.download.svg', $selectedQrCode->id) }}"
                            class="inline-flex h-10 flex-1 items-center justify-center rounded-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:bg-white/[0.04]"
                        >
                            SVG
                        </a>

                    </div>

                @else

                    {{-- Empty Preview --}}
                    <div class="flex h-64 w-64 items-center justify-center rounded-xl border border-dashed border-gray-300 dark:border-gray-700">

                        <svg
                            class="h-16 w-16 text-gray-300 dark:text-gray-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M3 3h7v7H3V3Zm11 0h7v7h-7V3ZM3 14h7v7H3v-7Zm11 0h3v3h-3v-3Zm4 0h3v3h-3v-3Zm0 4h3v3h-3v-3Zm-4 0h3v3h-3v-3Z"
                            />
                        </svg>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- QR CODE HISTORY --}}
{{-- ========================================================= --}}

<div class="mt-6">

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- History Header --}}
        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                QR Code History
            </h2>

        </div>


        {{-- History Table --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[800px]">

                <thead>

                    <tr class="border-b border-gray-200 dark:border-gray-800">

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            QR Code
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Short Link
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Size
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Created
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @if(isset($qrCodes) && $qrCodes->count())

                        @foreach($qrCodes as $qrCode)

                            <tr class="border-b border-gray-100 last:border-0 dark:border-gray-800">

                                {{-- QR Code Image --}}
                                <td class="px-6 py-4">

                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg border border-gray-200 bg-white p-1 dark:border-gray-700">

                                        <img
                                            src="{{ route('qr-codes.download.png', $qrCode->id) }}"
                                            alt="QR Code"
                                            class="h-10 w-10 object-contain"
                                        >

                                    </div>

                                </td>


                                {{-- Short Link --}}
                                <td class="px-6 py-4">

                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        /{{ $qrCode->shortUrl->custom_alias ?: $qrCode->shortUrl->short_code }}
                                    </p>

                                    <p class="mt-1 max-w-md truncate text-xs text-gray-500 dark:text-gray-400">
                                        {{ $qrCode->shortUrl->original_url }}
                                    </p>

                                </td>


                                {{-- Size --}}
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $qrCode->size }} × {{ $qrCode->size }}
                                </td>


                                {{-- Created --}}
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $qrCode->created_at?->format('M d, Y') }}
                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-1">

                                        {{-- Download PNG --}}
                                        <a
                                            href="{{ route('qr-codes.download.png', $qrCode->id) }}"
                                            title="Download PNG"
                                            class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        >

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"
                                                />
                                            </svg>

                                        </a>


                                        {{-- Download SVG --}}
                                        <a
                                            href="{{ route('qr-codes.download.svg', $qrCode->id) }}"
                                            title="Download SVG"
                                            class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        >

                                            <svg
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke="currentColor"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M12 3v12m0 0 4-4m-4 4-4-4M5 21h14"
                                                />
                                            </svg>

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            method="POST"
                                            action="{{ route('qr-codes.destroy', $qrCode->id) }}"
                                            onsubmit="return confirm('Delete this QR code?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Delete"
                                                class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                            >

                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M6 7h12M9 7V5h6v2m-7 0v12h8V7M10 11v5m4-5v5"
                                                    />
                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    @else

                        {{-- Empty History --}}
                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    No QR codes yet.
                                </div>

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if(isset($qrCodes) && method_exists($qrCodes, 'links'))

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">

                {{ $qrCodes->links() }}

            </div>

        @endif

    </div>

</div>

</div>

@endsection
