@extends('layouts.app')

@section('content')

<div class="mx-auto max-w-xl">

    {{-- Page Header --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">
            Password Protected Link
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Enter the password to continue to this link.
        </p>

    </div>


    {{-- Card --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-white/[0.03]">

        {{-- Icon --}}
        <div class="mb-5 flex justify-center">

            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">

                <svg
                    class="h-7 w-7 text-gray-600 dark:text-gray-300"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z"
                    />

                </svg>

            </div>

        </div>


        {{-- Description --}}
        <div class="mb-6 text-center">

            <h2 class="text-lg font-semibold text-gray-800 dark:text-white">

                This link is password protected

            </h2>

            <p class="mt-2 break-all text-sm text-gray-500 dark:text-gray-400">

                {{ $shortUrl->short_url }}

            </p>

        </div>


        {{-- Password Form --}}
        <form
            method="POST"
            action="{{ route('short.password.verify', [
                'shortCode' => $shortUrl->custom_alias ?: $shortUrl->short_code
            ]) }}"
        >

            @csrf


            {{-- Password --}}
            <div class="mb-5">

                <label
                    for="password"
                    class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Password
                </label>


                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autofocus
                    autocomplete="current-password"
                    placeholder="Enter password"
                    class="h-11 w-full rounded-lg border border-gray-300 bg-white px-4 text-sm text-gray-800 outline-none transition focus:border-gray-500 focus:ring-1 focus:ring-gray-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-gray-400"
                >


                @error('password')

                    <p class="mt-2 text-sm text-red-500">

                        {{ $message }}

                    </p>

                @enderror

            </div>


            {{-- Submit --}}
            <button
                type="submit"
                class="h-11 w-full rounded-lg bg-gray-800 px-5 text-sm font-medium text-white transition hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-900"
            >
                Continue
            </button>

        </form>

    </div>

</div>

@endsection