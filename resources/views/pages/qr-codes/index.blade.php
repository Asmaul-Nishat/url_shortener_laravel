@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                QR Codes
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Generate, customize and manage QR codes for your short links.
            </p>
        </div>
    </div>


    {{-- Main Generator Layout --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Generator Form --}}
        <div class="xl:col-span-2">
            <div
                class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
                x-data="{
                    size: 300,
                    foreground: '#111827',
                    background: '#ffffff',
                    includeLogo: false,
                    selectedLink: '',
                    generated: false
                }"
            >

                {{-- Card Header --}}
                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-100 dark:bg-white/[0.06]"
                        >
                            <svg
                                class="h-6 w-6 text-gray-700 dark:text-gray-300"
                                viewBox="0 0 24 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M3 3H10V10H3V3Z"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linejoin="round"
                                />
                                <path
                                    d="M14 3H21V10H14V3Z"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linejoin="round"
                                />
                                <path
                                    d="M3 14H10V21H3V14Z"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linejoin="round"
                                />
                                <path
                                    d="M14 14H17V17H14V14Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M18 14H21V17H18V14Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M18 18H21V21H18V18Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M14 18H17V21H14V18Z"
                                    fill="currentColor"
                                />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                                QR Code Generator
                            </h2>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Create a custom QR code for your short link.
                            </p>
                        </div>
                    </div>
                </div>


                {{-- Form Body --}}
                <div class="space-y-6 p-6">

                    {{-- Select Short Link --}}
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Select Short Link
                        </label>

                        <select
                            x-model="selectedLink"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:focus:border-gray-500"
                        >
                            <option value="">
                                Select a short link
                            </option>

                            <option value="https://short.example/abc123">
                                /abc123 — example.com/long-url
                            </option>

                            <option value="https://short.example/google1">
                                /google1 — google.com
                            </option>

                            <option value="https://short.example/github1">
                                /github1 — github.com
                            </option>
                        </select>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Choose the short URL that you want to convert into a QR code.
                        </p>
                    </div>


                    {{-- Selected URL Preview --}}
                    <div
                        x-show="selectedLink"
                        x-cloak
                        class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-800 dark:bg-white/[0.02]"
                    >
                        <p class="mb-1 text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">
                            Selected URL
                        </p>

                        <p
                            class="break-all text-sm font-medium text-gray-800 dark:text-white/90"
                            x-text="selectedLink"
                        ></p>
                    </div>


                    {{-- Size --}}
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                QR Code Size
                            </label>

                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                x-text="size + ' × ' + size + ' px'"
                            ></span>
                        </div>

                        <input
                            type="range"
                            min="150"
                            max="800"
                            step="50"
                            x-model="size"
                            class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200 dark:bg-gray-700"
                        />

                        <div class="mt-2 flex justify-between text-xs text-gray-400">
                            <span>150 px</span>
                            <span>800 px</span>
                        </div>
                    </div>


                    {{-- Colors --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                        {{-- Foreground --}}
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Foreground Color
                            </label>

                            <div class="flex items-center gap-3">
                                <input
                                    type="color"
                                    x-model="foreground"
                                    class="h-11 w-14 cursor-pointer rounded-lg border border-gray-300 bg-white p-1 dark:border-gray-700 dark:bg-gray-900"
                                />

                                <input
                                    type="text"
                                    x-model="foreground"
                                    class="h-11 flex-1 rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 uppercase outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                />
                            </div>
                        </div>


                        {{-- Background --}}
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Background Color
                            </label>

                            <div class="flex items-center gap-3">
                                <input
                                    type="color"
                                    x-model="background"
                                    class="h-11 w-14 cursor-pointer rounded-lg border border-gray-300 bg-white p-1 dark:border-gray-700 dark:bg-gray-900"
                                />

                                <input
                                    type="text"
                                    x-model="background"
                                    class="h-11 flex-1 rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 uppercase outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                                />
                            </div>
                        </div>

                    </div>


                    {{-- Logo Option --}}
                    <div
                        class="rounded-xl border border-gray-200 p-4 dark:border-gray-800"
                    >
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex gap-3">
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 dark:bg-white/[0.06]"
                                >
                                    <svg
                                        class="h-5 w-5 text-gray-600 dark:text-gray-300"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-7h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                        Add Logo
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Add your brand logo to the center of the QR code.
                                    </p>
                                </div>
                            </div>

                            {{-- Toggle --}}
                            <button
                                type="button"
                                @click="includeLogo = !includeLogo"
                                :class="includeLogo
                                    ? 'bg-gray-800 dark:bg-white'
                                    : 'bg-gray-200 dark:bg-gray-700'"
                                class="relative h-6 w-11 shrink-0 rounded-full transition"
                                :aria-pressed="includeLogo"
                            >
                                <span
                                    :class="includeLogo
                                        ? 'translate-x-5 bg-white dark:bg-gray-800'
                                        : 'translate-x-0.5 bg-white'"
                                    class="absolute top-0.5 h-5 w-5 rounded-full shadow-sm transition"
                                ></span>
                            </button>

                        </div>


                        {{-- Logo Upload Area --}}
                        <div
                            x-show="includeLogo"
                            x-transition
                            class="mt-4"
                        >
                            <label
                                class="flex cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed border-gray-300 px-6 py-8 text-center hover:border-gray-500 dark:border-gray-700 dark:hover:border-gray-500"
                            >
                                <svg
                                    class="mb-3 h-8 w-8 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M12 4v12m0-12l-4 4m4-4l4 4M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2"
                                    />
                                </svg>

                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Upload logo
                                </span>

                                <span class="mt-1 text-xs text-gray-400">
                                    PNG, JPG or SVG
                                </span>

                                <input
                                    type="file"
                                    class="hidden"
                                    accept=".png,.jpg,.jpeg,.svg"
                                />
                            </label>
                        </div>

                    </div>


                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:justify-end dark:border-gray-800">

                        <button
                            type="button"
                            @click="generated = true"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-gray-800 px-5 text-sm font-medium text-white transition hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-200"
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
            </div>
        </div>


        {{-- QR Preview --}}
        <div>
            <div
                class="h-full rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
            >

                <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        QR Preview
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Preview your customized QR code.
                    </p>
                </div>


                <div class="flex min-h-[500px] flex-col items-center justify-center p-6">

                    {{-- Fake QR Preview --}}
                    <div
                        class="flex items-center justify-center rounded-xl border border-gray-200 bg-gray-50 p-8 dark:border-gray-800 dark:bg-white/[0.02]"
                    >
                        <div
                            class="relative flex h-64 w-64 items-center justify-center bg-white shadow-sm"
                            style="
                                background-image:
                                    linear-gradient(45deg, #111827 25%, transparent 25%),
                                    linear-gradient(-45deg, #111827 25%, transparent 25%),
                                    linear-gradient(45deg, transparent 75%, #111827 75%),
                                    linear-gradient(-45deg, transparent 75%, #111827 75%);
                                background-size: 32px 32px;
                                background-position: 0 0, 0 16px, 16px -16px, -16px 0px;
                            "
                        >

                            {{-- White Center --}}
                            <div
                                class="flex h-20 w-20 items-center justify-center rounded-xl border-4 border-white bg-white shadow-md"
                            >
                                <span class="text-xs font-bold text-gray-700">
                                    LOGO
                                </span>
                            </div>

                        </div>
                    </div>


                    {{-- Preview Information --}}
                    <div class="mt-6 w-full text-center">

                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                            QR Code Preview
                        </p>

                        <p class="mt-1 break-all text-xs text-gray-500 dark:text-gray-400">
                            Your QR code will contain the selected short URL.
                        </p>

                    </div>


                    {{-- Download Buttons --}}
                    <div class="mt-6 grid w-full grid-cols-1 gap-3 sm:grid-cols-2">

                        <button
                            type="button"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:bg-white/[0.04]"
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
                                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14"
                                />
                            </svg>

                            Download PNG
                        </button>


                        <button
                            type="button"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:bg-white/[0.04]"
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
                                    d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14"
                                />
                            </svg>

                            Download SVG
                        </button>

                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- Generated QR History --}}
    <div class="mt-6">
        <div
            class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
        >

            {{-- History Header --}}
            <div
                class="flex flex-col gap-4 border-b border-gray-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800"
            >

                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Generated QR History
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        View and manage your previously generated QR codes.
                    </p>
                </div>

                <button
                    type="button"
                    class="inline-flex h-10 items-center justify-center rounded-lg border border-gray-300 px-4 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/[0.04]"
                >
                    View All
                </button>

            </div>


            {{-- Search --}}
            <div class="border-b border-gray-200 p-6 dark:border-gray-800">

                <div class="relative max-w-md">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2">
                        <svg
                            class="h-5 w-5 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="m21 21-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0Z"
                            />
                        </svg>
                    </span>

                    <input
                        type="text"
                        placeholder="Search QR codes..."
                        class="h-11 w-full rounded-lg border border-gray-300 bg-white pl-10 pr-4 text-sm text-gray-800 outline-none focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                    />
                </div>

            </div>


            {{-- History Table --}}
            <div class="overflow-x-auto">

                <table class="w-full min-w-[900px]">

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

                        {{-- Demo Row 1 --}}
                        <tr class="border-b border-gray-100 dark:border-gray-800">

                            <td class="px-6 py-4">
                                <div class="flex h-12 w-12 items-center justify-center border border-gray-200 bg-white dark:border-gray-700">
                                    <div
                                        class="h-9 w-9"
                                        style="
                                            background-image:
                                                linear-gradient(45deg, #111827 25%, transparent 25%),
                                                linear-gradient(-45deg, #111827 25%, transparent 25%),
                                                linear-gradient(45deg, transparent 75%, #111827 75%),
                                                linear-gradient(-45deg, transparent 75%, #111827 75%);
                                            background-size: 10px 10px;
                                            background-position: 0 0, 0 5px, 5px -5px, -5px 0px;
                                        "
                                    ></div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    /abc123
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    example.com/long-url
                                </p>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                300 × 300
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                Sep 10, 2026
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">

                                    <button
                                        type="button"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        title="Download"
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
                                                d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        title="Delete"
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
                                                d="M6 7h12M9 7V5h6v2m-7 0v12h8V7M10 11v5m4-5v5"
                                            />
                                        </svg>
                                    </button>

                                </div>
                            </td>

                        </tr>


                        {{-- Demo Row 2 --}}
                        <tr class="border-b border-gray-100 dark:border-gray-800">

                            <td class="px-6 py-4">
                                <div class="flex h-12 w-12 items-center justify-center border border-gray-200 bg-white dark:border-gray-700">
                                    <div
                                        class="h-9 w-9"
                                        style="
                                            background-image:
                                                linear-gradient(45deg, #111827 25%, transparent 25%),
                                                linear-gradient(-45deg, #111827 25%, transparent 25%),
                                                linear-gradient(45deg, transparent 75%, #111827 75%),
                                                linear-gradient(-45deg, transparent 75%, #111827 75%);
                                            background-size: 10px 10px;
                                            background-position: 0 0, 0 5px, 5px -5px, -5px 0px;
                                        "
                                    ></div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    /google1
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    google.com
                                </p>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                500 × 500
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                Sep 09, 2026
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">

                                    <button
                                        type="button"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        title="Download"
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
                                                d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        title="Delete"
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
                                                d="M6 7h12M9 7V5h6v2m-7 0v12h8V7M10 11v5m4-5v5"
                                            />
                                        </svg>
                                    </button>

                                </div>
                            </td>

                        </tr>


                        {{-- Demo Row 3 --}}
                        <tr>

                            <td class="px-6 py-4">
                                <div class="flex h-12 w-12 items-center justify-center border border-gray-200 bg-white dark:border-gray-700">
                                    <div
                                        class="h-9 w-9"
                                        style="
                                            background-image:
                                                linear-gradient(45deg, #111827 25%, transparent 25%),
                                                linear-gradient(-45deg, #111827 25%, transparent 25%),
                                                linear-gradient(45deg, transparent 75%, #111827 75%),
                                                linear-gradient(-45deg, transparent 75%, #111827 75%);
                                            background-size: 10px 10px;
                                            background-position: 0 0, 0 5px, 5px -5px, -5px 0px;
                                        "
                                    ></div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                    /github1
                                </p>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    github.com
                                </p>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                400 × 400
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                Sep 08, 2026
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">

                                    <button
                                        type="button"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        title="Download"
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
                                                d="M12 3v12m0 0l4-4m-4 4l-4-4M5 21h14"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.05] dark:hover:text-white"
                                        title="Delete"
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
                                                d="M6 7h12M9 7V5h6v2m-7 0v12h8V7M10 11v5m4-5v5"
                                            />
                                        </svg>
                                    </button>

                                </div>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- Empty / Pagination Footer --}}
            <div
                class="flex flex-col gap-3 border-t border-gray-200 px-6 py-4 text-sm sm:flex-row sm:items-center sm:justify-between dark:border-gray-800"
            >
                <p class="text-gray-500 dark:text-gray-400">
                    Showing 3 generated QR codes
                </p>

                <div class="flex items-center gap-2">

                    <button
                        type="button"
                        disabled
                        class="rounded-lg border border-gray-200 px-3 py-2 text-gray-400 dark:border-gray-800"
                    >
                        Previous
                    </button>

                    <button
                        type="button"
                        disabled
                        class="rounded-lg border border-gray-200 px-3 py-2 text-gray-400 dark:border-gray-800"
                    >
                        Next
                    </button>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection