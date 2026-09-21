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

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>
@endif


{{-- Page Header --}}
<div class="mb-6">


    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                Create QR Code
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Generate and customize a QR code for any user's short link.
            </p>

        </div>


        <a
            href="{{ route('admin.qr-codes.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
        >
            All QR Codes
        </a>

    </div>

</div>


{{-- QR Generator --}}
<div
    x-data="{
        size: {{ old('size', 300) }},
        foreground: '{{ old('foreground_color', '#111827') }}',
        background: '{{ old('background_color', '#ffffff') }}',
        includeLogo: false,
        selectedLink: '{{ old('short_url_id', '') }}',
        logoPreview: null,
        logoName: '',
        previewQr: null,

        shortUrls: @js(
            $shortUrls->map(function ($shortUrl) {
                return [
                    'id' => $shortUrl->id,
                    'url' => $shortUrl->short_url,
                    'label' => $shortUrl->custom_alias ?: $shortUrl->short_code,
                    'user' => $shortUrl->user->name ?? 'Unknown User',
                ];
            })->values()
        ),

        get selectedUrl() {
            const selected = this.shortUrls.find(
                item => String(item.id) === String(this.selectedLink)
            );

            return selected ? selected.url : '';
        },

        get selectedUser() {
            const selected = this.shortUrls.find(
                item => String(item.id) === String(this.selectedLink)
            );

            return selected ? selected.user : '';
        },

        async updatePreview() {

            if (!this.selectedUrl) {

                this.previewQr = null;

                return;
            }

            if (typeof QRCode === 'undefined') {

                this.previewQr = null;

                return;
            }

            try {

                const container = document.createElement('div');

                new QRCode(container, {
                    text: this.selectedUrl,
                    width: Number(this.size),
                    height: Number(this.size),
                    colorDark: this.foreground,
                    colorLight: this.background,
                    correctLevel: QRCode.CorrectLevel.H
                });

                await new Promise(resolve => {
                    setTimeout(resolve, 100);
                });

                const canvas = container.querySelector('canvas');

                if (!canvas) {

                    this.previewQr = null;

                    return;
                }

                const outputCanvas = document.createElement('canvas');

                outputCanvas.width = canvas.width;
                outputCanvas.height = canvas.height;

                const context = outputCanvas.getContext('2d');

                context.drawImage(
                    canvas,
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );


                if (this.includeLogo && this.logoPreview) {

                    await new Promise(resolve => {

                        const logo = new Image();

                        logo.onload = () => {

                            const logoSize = Math.round(
                                canvas.width * 0.18
                            );

                            const x = Math.round(
                                (canvas.width - logoSize) / 2
                            );

                            const y = Math.round(
                                (canvas.height - logoSize) / 2
                            );


                            context.fillStyle = this.background;

                            context.fillRect(
                                x - 8,
                                y - 8,
                                logoSize + 16,
                                logoSize + 16
                            );


                            context.drawImage(
                                logo,
                                x,
                                y,
                                logoSize,
                                logoSize
                            );


                            resolve();
                        };


                        logo.onerror = () => resolve();

                        logo.src = this.logoPreview;

                    });

                }


                this.previewQr = outputCanvas.toDataURL(
                    'image/png'
                );

            } catch (error) {

                console.error(
                    'QR preview error:',
                    error
                );

                this.previewQr = null;

            }
        },

        previewLogo(event) {

            const file = event.target.files[0];

            if (!file) {

                this.logoPreview = null;
                this.logoName = '';

                this.updatePreview();

                return;
            }


            this.logoName = file.name;


            const reader = new FileReader();


            reader.onload = (e) => {

                this.logoPreview = e.target.result;

                this.updatePreview();

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


            this.updatePreview();
        },


        init() {

            this.$nextTick(() => {
                this.updatePreview();
            });


            this.$watch(
                'selectedLink',
                () => this.updatePreview()
            );


            this.$watch(
                'size',
                () => this.updatePreview()
            );


            this.$watch(
                'foreground',
                () => this.updatePreview()
            );


            this.$watch(
                'background',
                () => this.updatePreview()
            );

        }
    }"
>


    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">


        {{-- LEFT: Generator Form --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Generate QR Code
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Select a user's short link and customize the QR code.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.qr-codes.generate') }}"
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
                                — {{ $shortUrl->user->name ?? 'Unknown User' }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Selected Link --}}
                <div
                    x-show="selectedLink"
                    x-cloak
                    class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-4 dark:border-gray-700 dark:bg-gray-900"
                >

                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                        Selected Short Link
                    </p>


                    <p
                        class="mt-1 break-all text-sm font-medium text-gray-800 dark:text-white/90"
                        x-text="selectedUrl"
                    ></p>


                    <p
                        x-show="selectedUser"
                        class="mt-1 text-xs text-gray-500 dark:text-gray-400"
                        x-text="'Owner: ' + selectedUser"
                    ></p>

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

                            <span x-text="size"></span>

                            px

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

                        <span>
                            150 px
                        </span>

                        <span>
                            800 px
                        </span>

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


                        <button
                            type="button"
                            @click="
                                includeLogo = !includeLogo;
                                updatePreview();
                            "
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


                        {{-- Selected Logo --}}
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


                {{-- Admin Notice --}}
                <div class="rounded-lg border border-warning-200 bg-warning-50 px-4 py-4 dark:border-warning-500/30 dark:bg-warning-500/10">

                    <div class="flex items-start gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-warning-600 dark:text-warning-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.52 20h14.96a2 2 0 001.73-3.14l-7.5-13a2 2 0 00-3.42 0z"
                            />
                        </svg>


                    </div>

                </div>


                {{-- Submit --}}
                <div class="flex flex-col gap-3 pt-2 sm:flex-row">

                    <a
                        href="{{ route('admin.qr-codes.index') }}"
                        class="inline-flex flex-1 items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="inline-flex flex-1 items-center justify-center rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                    >
                        Generate QR Code
                    </button>

                </div>

            </form>

        </div>


        {{-- RIGHT: QR Preview --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

            <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">

                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    QR Preview
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Preview your QR code before generating it.
                </p>

            </div>


            <div class="flex min-h-[550px] items-center justify-center p-6">

                {{-- Newly Generated QR --}}
                @if(request()->filled('qr'))

                    @php
                        $generatedQr = \App\Models\QrCode::with('shortUrl')
                            ->where('id', request('qr'))
                            ->first();
                    @endphp


                    @if($generatedQr)

                        <div class="w-full text-center">

                            <div class="mb-4">

                                <span class="inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                    QR Code Generated
                                </span>

                            </div>


                            {{-- Generated QR Image --}}
                            <div class="mb-6 flex justify-center">

                                @php

                                    $generatedBuilder = new \Endroid\QrCode\QrCode(
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


                                    $generatedWriter = new \Endroid\QrCode\Writer\PngWriter();


                                    $generatedLogo = null;


                                    if (
                                        $generatedQr->logo_path &&
                                        \Illuminate\Support\Facades\Storage::disk('public')->exists(
                                            $generatedQr->logo_path
                                        )
                                    ) {

                                        $generatedLogo = new \Endroid\QrCode\Logo\Logo(
                                            path: \Illuminate\Support\Facades\Storage::disk('public')->path(
                                                $generatedQr->logo_path
                                            ),
                                            resizeToWidth: (int) (
                                                $generatedQr->size * 0.18
                                            ),
                                            punchoutBackground: true
                                        );

                                    }


                                    $generatedResult = $generatedWriter->write(
                                        $generatedBuilder,
                                        $generatedLogo
                                    );


                                    $generatedQrImage =
                                        'data:image/png;base64,' .
                                        base64_encode(
                                            $generatedResult->getString()
                                        );

                                @endphp


                                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700">

                                    <img
                                        src="{{ $generatedQrImage }}"
                                        alt="Generated QR Code"
                                        class="max-h-[400px] max-w-full rounded-lg"
                                    >

                                </div>

                            </div>


                            {{-- Generated Link --}}
                            <div class="mx-auto max-w-md">

                                <p class="break-all text-sm font-medium text-gray-800 dark:text-white/90">
                                    {{ $generatedQr->shortUrl->short_url }}
                                </p>


                                @if($generatedQr->shortUrl->user)

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Owner:
                                        {{ $generatedQr->shortUrl->user->name }}
                                    </p>

                                @endif

                            </div>


                            {{-- QR Details --}}
                            <div class="mt-5 flex flex-wrap justify-center gap-2">

                                <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                    {{ $generatedQr->size }} px
                                </span>


                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                    <span
                                        class="h-3 w-3 rounded-full border border-gray-300"
                                        style="background-color: {{ $generatedQr->foreground_color }}"
                                    ></span>

                                    {{ $generatedQr->foreground_color }}

                                </span>


                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                    <span
                                        class="h-3 w-3 rounded-full border border-gray-300"
                                        style="background-color: {{ $generatedQr->background_color }}"
                                    ></span>

                                    {{ $generatedQr->background_color }}

                                </span>


                                @if($generatedQr->logo_path)

                                    <span class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                        Logo included
                                    </span>

                                @endif

                            </div>


                            {{-- DOWNLOAD OPTIONS --}}
                            <div class="mt-6 border-t border-gray-200 pt-6 dark:border-gray-800">

                                <p class="mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Download QR Code
                                </p>


                                <div class="flex flex-col justify-center gap-3 sm:flex-row">

                                    <a
                                        href="{{ route('admin.qr-codes.download.png', $generatedQr) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-500 px-5 py-3 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                                            />
                                        </svg>

                                        Download PNG

                                    </a>


                                    <a
                                        href="{{ route('admin.qr-codes.download.svg', $generatedQr) }}"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                                    >

                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                                            />
                                        </svg>

                                        Download SVG

                                    </a>

                                </div>


                                <a
                                    href="{{ route('admin.qr-codes.create') }}"
                                    class="mt-3 inline-flex items-center justify-center rounded-lg border border-brand-200 bg-brand-50 px-5 py-2.5 text-sm font-medium text-brand-600 transition hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400"
                                >
                                    Create Another QR
                                </a>

                            </div>

                        </div>

                    @else

                        {{-- QR Not Found --}}
                        <div class="text-center">

                            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-error-50 dark:bg-error-500/10">

                                <svg
                                    class="h-10 w-10 text-error-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>

                            </div>


                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                QR Code Not Found
                            </h3>


                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                The requested QR code could not be found.
                            </p>

                        </div>

                    @endif

                @else

                    {{-- Live Preview --}}
                    <div
                        x-show="selectedLink && previewQr"
                        x-cloak
                        class="w-full text-center"
                    >

                        <div class="mb-6 flex justify-center">

                            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700">

                                <img
                                    :src="previewQr"
                                    alt="QR Code Preview"
                                    class="mx-auto max-h-[400px] max-w-full rounded-lg"
                                >

                            </div>

                        </div>


                        <p
                            class="break-all text-sm font-medium text-gray-800 dark:text-white/90"
                            x-text="selectedUrl"
                        ></p>


                        <p
                            x-show="selectedUser"
                            class="mt-1 text-xs text-gray-500 dark:text-gray-400"
                            x-text="'Owner: ' + selectedUser"
                        ></p>


                        <div class="mt-5 flex flex-wrap justify-center gap-2">

                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                <span x-text="size"></span>

                                &nbsp;px

                            </span>


                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                <span
                                    class="h-3 w-3 rounded-full border border-gray-300"
                                    :style="'background-color: ' + foreground"
                                ></span>

                                <span x-text="foreground"></span>

                            </span>


                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">

                                <span
                                    class="h-3 w-3 rounded-full border border-gray-300"
                                    :style="'background-color: ' + background"
                                ></span>

                                <span x-text="background"></span>

                            </span>


                            <span
                                x-show="includeLogo && logoPreview"
                                class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400"
                            >
                                Logo included
                            </span>

                        </div>


                        <div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-xs text-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400">
                            This is a live preview. Click <strong>Generate QR Code</strong> to save it and enable downloads.
                        </div>

                    </div>


                    {{-- No Selection --}}
                    <div
                        x-show="!selectedLink"
                        x-cloak
                        class="text-center"
                    >

                        <div class="mx-auto mb-5 flex h-28 w-28 items-center justify-center rounded-2xl bg-gray-100 dark:bg-gray-800">

                            <svg
                                class="h-14 w-14 text-gray-400"
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
                            No QR Code Preview
                        </h3>


                        <p class="mx-auto mt-1 max-w-sm text-sm text-gray-500 dark:text-gray-400">
                            Select a short link from the form to preview your QR code.
                        </p>

                    </div>


                    {{-- QRCode.js Missing --}}
                    <div
                        x-show="selectedLink && !previewQr && typeof QRCode === 'undefined'"
                        x-cloak
                        class="text-center"
                    >

                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-warning-50 dark:bg-warning-500/10">

                            <svg
                                class="h-10 w-10 text-warning-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13a2 2 0 001.73 3.14h14.96a2 2 0 001.73-3.14l-7.5-13a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>


                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                            Preview Library Loading
                        </h3>


                        <p class="mx-auto mt-1 max-w-sm text-sm text-gray-500 dark:text-gray-400">
                            The QR preview library is not available yet. You can still generate the QR code normally.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

</div>

{{-- QRCode.js --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

@endsection
