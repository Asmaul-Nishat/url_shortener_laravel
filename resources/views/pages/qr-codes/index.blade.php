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

@if($errors->any())
    <div class="mb-6 rounded-lg border border-error-200 bg-error-50 px-4 py-4 dark:border-error-500/30 dark:bg-error-500/10">

        <p class="text-sm font-medium text-error-700 dark:text-error-400">
            Please correct the following errors:
        </p>

        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-error-700 dark:text-error-400">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
@endif


{{-- Page Header --}}
<div class="mb-6">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
        QR Codes
    </h1>

    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        Generate and manage QR codes for your short links.
    </p>

</div>


{{-- Generator --}}
<div
    x-data="{
        size: {{ old('size', 300) }},
        foreground: '{{ old('foreground_color', '#111827') }}',
        background: '{{ old('background_color', '#ffffff') }}',
        includeLogo: false,
        selectedLink: '{{ old('short_url_id', '') }}',
        logoPreview: null,
        logoName: '',

        previewLogo(event) {
            const file = event.target.files[0];

            if (!file) {
                this.logoPreview = null;
                this.logoName = '';
                return;
            }

            this.logoName = file.name;

            const reader = new FileReader();

            reader.onload = (e) => {
                this.logoPreview = e.target.result;
            };

            reader.readAsDataURL(file);
        },

        removeLogo() {
            this.logoPreview = null;
            this.logoName = '';

            const input = document.getElementById('logo');

            if (input) {
                input.value = '';
            }
        }
    }"
>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">


        {{-- Left: Generator Form --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Generate QR Code
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Customize your QR code and generate it instantly.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('qr-codes.generate') }}"
                enctype="multipart/form-data"
                class="space-y-6 p-6"
            >

                @csrf


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
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    >

                        <option value="">
                            Select a short link
                        </option>

                        @foreach($shortUrls as $shortUrl)

                            <option
                                value="{{ $shortUrl->id }}"
                                @selected(old('short_url_id') == $shortUrl->id)
                            >
                                {{ $shortUrl->custom_alias ?: $shortUrl->short_code }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Selected URL --}}
                <div
                    x-show="selectedLink"
                    x-cloak
                    class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 dark:border-gray-700 dark:bg-gray-900"
                >

                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        Selected URL
                    </p>

                    <p class="mt-1 break-all text-sm text-gray-700 dark:text-gray-300">

                        @foreach($shortUrls as $shortUrl)

                            <span
                                x-show="selectedLink == '{{ $shortUrl->id }}'"
                                x-cloak
                            >
                                {{ $shortUrl->short_url }}
                            </span>

                        @endforeach

                    </p>

                </div>


                {{-- Size --}}
                <div>

                    <div class="mb-2 flex items-center justify-between">

                        <label
                            for="size"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            QR Code Size
                        </label>

                        <span class="text-sm font-medium text-brand-600 dark:text-brand-400">
                            <span x-text="size"></span> px
                        </span>

                    </div>

                    <input
                        id="size"
                        name="size"
                        type="range"
                        min="150"
                        max="800"
                        step="50"
                        x-model="size"
                        class="w-full cursor-pointer accent-brand-500"
                    >

                    <div class="mt-2 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span>150 px</span>
                        <span>800 px</span>
                    </div>

                </div>


                {{-- Colors --}}
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    {{-- Foreground --}}
                    <div>

                        <label
                            for="foreground_color"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Foreground Color
                        </label>

                        <div class="flex items-center gap-3">

                            <input
                                id="foreground_color"
                                name="foreground_color"
                                type="color"
                                x-model="foreground"
                                class="h-11 w-16 cursor-pointer rounded-lg border border-gray-300 bg-white p-1 dark:border-gray-700 dark:bg-gray-900"
                            >

                            <input
                                type="text"
                                x-model="foreground"
                                class="h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"
                            >

                        </div>

                    </div>


                    {{-- Background --}}
                    <div>

                        <label
                            for="background_color"
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Background Color
                        </label>

                        <div class="flex items-center gap-3">

                            <input
                                id="background_color"
                                name="background_color"
                                type="color"
                                x-model="background"
                                class="h-11 w-16 cursor-pointer rounded-lg border border-gray-300 bg-white p-1 dark:border-gray-700 dark:bg-gray-900"
                            >

                            <input
                                type="text"
                                x-model="background"
                                class="h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 outline-none focus:border-brand-500 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90"
                            >

                        </div>

                    </div>

                </div>


                {{-- Logo --}}
                <div>

                    <div class="mb-3 flex items-center justify-between">

                        <div>

                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Add Logo
                            </label>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                Add a logo to the center of your QR code.
                            </p>

                        </div>


                        {{-- ON/OFF --}}
                        <button
                            type="button"
                            @click="includeLogo = !includeLogo"
                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full transition"
                            :class="includeLogo ? 'bg-brand-500' : 'bg-gray-300 dark:bg-gray-700'"
                        >

                            <span
                                class="pointer-events-none inline-block h-5 w-5 translate-y-0.5 rounded-full bg-white shadow transition"
                                :class="includeLogo ? 'translate-x-5' : 'translate-x-0.5'"
                            ></span>

                        </button>

                    </div>


                    {{-- Logo Upload --}}
                    <div
                        x-show="includeLogo"
                        x-cloak
                        class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900"
                    >

                        <label
                            for="logo"
                            class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 px-6 py-6 text-center hover:border-brand-500 dark:border-gray-700"
                        >

                            <svg
                                class="mb-3 h-8 w-8 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5.002 5.002 0 0116.9 6H17a4 4 0 010 8h-1m-5-4v8m0 0l-3-3m3 3l3-3"
                                />
                            </svg>

                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Click to upload logo
                            </span>

                            <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG or JPEG
                            </span>

                            <input
                                id="logo"
                                type="file"
                                name="logo"
                                class="hidden"
                                accept="image/png,image/jpeg,image/jpg"
                                @change="previewLogo($event)"
                            >

                        </label>


                        {{-- Small Selected Logo Preview --}}
                        <div
                            x-show="logoPreview"
                            x-cloak
                            class="mt-4 flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-800"
                        >

                            <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-white p-1 dark:border-gray-700">

                                <img
                                    :src="logoPreview"
                                    alt="Selected logo preview"
                                    class="h-full w-full object-contain"
                                >

                            </div>


                            <div class="min-w-0 flex-1">

                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    Selected Logo
                                </p>

                                <p
                                    class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400"
                                    x-text="logoName"
                                ></p>

                            </div>


                            <button
                                type="button"
                                @click="removeLogo()"
                                class="shrink-0 text-sm font-medium text-error-600 hover:text-error-700 dark:text-error-400"
                            >
                                Remove
                            </button>

                        </div>

                    </div>

                </div>


                {{-- Submit --}}
                <div class="pt-2">

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                    >
                        Generate QR Code
                    </button>

                </div>

            </form>

        </div>


        {{-- Right: Preview --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    QR Preview
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Your generated QR code will appear here.
                </p>

            </div>


            <div class="flex min-h-[450px] items-center justify-center p-6">

                @if(request()->filled('qr'))

                    @php
                        $generatedQr = \App\Models\QrCode::with('shortUrl')
                            ->where('id', request('qr'))
                            ->where('user_id', auth()->id())
                            ->first();
                    @endphp

                    @if($generatedQr)

                        <div class="text-center">

                            <div class="mb-6 flex justify-center">

                                @php
                                    $qrBuilder = new \Endroid\QrCode\QrCode(
                                        data: $generatedQr->shortUrl->short_url,
                                        encoding: new \Endroid\QrCode\Encoding\Encoding('UTF-8'),
                                        errorCorrectionLevel: \Endroid\QrCode\ErrorCorrectionLevel::High,
                                        size: $generatedQr->size,
                                        margin: 10,
                                        roundBlockSizeMode: \Endroid\QrCode\RoundBlockSizeMode::Margin,
                                        foregroundColor: new \Endroid\QrCode\Color\Color(
                                            hexdec(substr(ltrim($generatedQr->foreground_color, '#'), 0, 2)),
                                            hexdec(substr(ltrim($generatedQr->foreground_color, '#'), 2, 2)),
                                            hexdec(substr(ltrim($generatedQr->foreground_color, '#'), 4, 2))
                                        ),
                                        backgroundColor: new \Endroid\QrCode\Color\Color(
                                            hexdec(substr(ltrim($generatedQr->background_color, '#'), 0, 2)),
                                            hexdec(substr(ltrim($generatedQr->background_color, '#'), 2, 2)),
                                            hexdec(substr(ltrim($generatedQr->background_color, '#'), 4, 2))
                                        )
                                    );

                                    $pngWriter = new \Endroid\QrCode\Writer\PngWriter();

                                    $logoObject = null;

                                    if (
                                        $generatedQr->logo_path &&
                                        \Illuminate\Support\Facades\Storage::disk('public')->exists($generatedQr->logo_path)
                                    ) {
                                        $logoObject = new \Endroid\QrCode\Logo\Logo(
                                            path: \Illuminate\Support\Facades\Storage::disk('public')->path($generatedQr->logo_path),
                                            resizeToWidth: (int) ($generatedQr->size * 0.18),
                                            punchoutBackground: true
                                        );
                                    }

                                    $generatedResult = $pngWriter->write(
                                        $qrBuilder,
                                        $logoObject
                                    );

                                    $generatedQrImage = 'data:image/png;base64,' . base64_encode($generatedResult->getString());
                                @endphp

                                <img
                                    src="{{ $generatedQrImage }}"
                                    alt="Generated QR Code"
                                    class="max-h-[350px] max-w-full rounded-lg border border-gray-200 bg-white p-3 shadow-sm dark:border-gray-700"
                                >

                            </div>


                            <div class="mb-4">

                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $generatedQr->shortUrl->short_url }}
                                </p>

                            </div>


                            <div class="flex flex-wrap justify-center gap-3">

                                <a
                                    href="{{ route('qr-codes.download.png', $generatedQr) }}"
                                    class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                                >
                                    Download PNG
                                </a>

                                <a
                                    href="{{ route('qr-codes.download.svg', $generatedQr) }}"
                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                                >
                                    Download SVG
                                </a>

                            </div>

                        </div>

                    @else

                        <div class="text-center">

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                QR code not found.
                            </p>

                        </div>

                    @endif

                @else

                    <div class="text-center">

                        <div class="mx-auto mb-4 flex h-24 w-24 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">

                            <svg
                                class="h-12 w-12 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 0h7v7h-7v-7z"
                                />
                            </svg>

                        </div>

                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                            No QR Code Yet
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Select a short link and click Generate QR Code.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- QR History --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                QR Code History
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Previously generated QR codes.
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">

                    <tr>

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
                            Created
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">

                    @forelse($qrCodes as $qrCode)

                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02]">

                            {{-- QR Image --}}
                            <td class="px-6 py-4">

                                <div class="flex h-16 w-16 items-center justify-center rounded-lg border border-gray-200 bg-white p-1 dark:border-gray-700">

                                    @php
                                        $historyBuilder = new \Endroid\QrCode\QrCode(
                                            data: $qrCode->shortUrl->short_url,
                                            encoding: new \Endroid\QrCode\Encoding\Encoding('UTF-8'),
                                            errorCorrectionLevel: \Endroid\QrCode\ErrorCorrectionLevel::High,
                                            size: $qrCode->size,
                                            margin: 10,
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

                                        $historyWriter = new \Endroid\QrCode\Writer\PngWriter();

                                        $historyLogo = null;

                                        if (
                                            $qrCode->logo_path &&
                                            \Illuminate\Support\Facades\Storage::disk('public')->exists($qrCode->logo_path)
                                        ) {
                                            $historyLogo = new \Endroid\QrCode\Logo\Logo(
                                                path: \Illuminate\Support\Facades\Storage::disk('public')->path($qrCode->logo_path),
                                                resizeToWidth: (int) ($qrCode->size * 0.18),
                                                punchoutBackground: true
                                            );
                                        }

                                        $historyResult = $historyWriter->write(
                                            $historyBuilder,
                                            $historyLogo
                                        );

                                        $historyQrImage = 'data:image/png;base64,' . base64_encode($historyResult->getString());
                                    @endphp

                                    <img
                                        src="{{ $historyQrImage }}"
                                        alt="QR Code"
                                        class="h-full w-full object-contain"
                                    >

                                </div>

                            </td>


                            {{-- Short Link --}}
                            <td class="px-6 py-4">

                                <div class="max-w-xs">

                                    <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $qrCode->shortUrl->custom_alias ?: $qrCode->shortUrl->short_code }}
                                    </p>

                                    <p class="mt-1 truncate text-xs text-gray-500 dark:text-gray-400">
                                        {{ $qrCode->shortUrl->short_url }}
                                    </p>

                                </div>

                            </td>


                            {{-- Size --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $qrCode->size }} px
                            </td>


                            {{-- Created --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ $qrCode->created_at->format('M d, Y h:i A') }}
                            </td>


                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('qr-codes.download.png', $qrCode) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                                    >
                                        PNG
                                    </a>

                                    <a
                                        href="{{ route('qr-codes.download.svg', $qrCode) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                                    >
                                        SVG
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('qr-codes.destroy', $qrCode) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this QR code?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center rounded-lg border border-error-200 bg-error-50 px-3 py-2 text-xs font-medium text-error-600 hover:bg-error-100 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400"
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
                                colspan="5"
                                class="px-6 py-12 text-center"
                            >

                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    No QR codes generated yet.
                                </p>

                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Generate your first QR code using the form above.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($qrCodes->hasPages())

            <div class="border-t border-gray-200 px-6 py-4 dark:border-gray-800">
                {{ $qrCodes->links() }}
            </div>

        @endif

    </div>

</div>

</div>

@endsection
