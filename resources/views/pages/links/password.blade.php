<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Password Protected Link - URL Shortener</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        * {
            box-sizing: border-box;
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

            color: #111827;

            background: #ffffff;
        }


        /* =========================================================
           PAGE
           ========================================================= */

        .password-page {
            min-height: 100vh;

            display: flex;

            flex-direction: column;

            background: #ffffff;
        }


        /* =========================================================
           NAVBAR
           ========================================================= */

        .landing-nav {
            position: sticky;

            top: 0;

            z-index: 50;

            background:
                rgba(255, 255, 255, 0.94);

            backdrop-filter: blur(16px);

            border-bottom:
                1px solid #e5e7eb;
        }

        .landing-nav-inner {
            max-width: 1200px;

            margin: 0 auto;

            padding:
                18px 24px;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        /* =========================================================
           BRAND
           ========================================================= */

        .brand {
            display: flex;

            align-items: center;

            gap: 12px;

            text-decoration: none;

            color: #111827;
        }

        .brand-logo {
            width: 42px;

            height: 42px;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #7c3aed
                );

            color: white;

            font-weight: 800;

            font-size: 20px;

            box-shadow:
                0 8px 20px
                rgba(37, 99, 235, 0.22);
        }

        .brand-title {
            font-size: 18px;

            font-weight: 800;
        }

        .brand-subtitle {
            margin-top: 2px;

            font-size: 12px;

            color: #6b7280;
        }


        /* =========================================================
           NAVIGATION
           ========================================================= */

        .nav-links {
            display: flex;

            align-items: center;

            gap: 28px;
        }

        .nav-link {
            color: #4b5563;

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            transition:
                color 0.2s ease;
        }

        .nav-link:hover {
            color: #2563eb;
        }

        .nav-login {
            color: #374151;
        }

        .nav-register {
            padding:
                10px 17px;

            border-radius: 10px;

            background: #111827;

            color: white;
        }

        .nav-register:hover {
            color: white;

            background: #1f2937;
        }


        /* =========================================================
           MOBILE MENU
           ========================================================= */

        .mobile-menu-button {
            display: none;

            border: 0;

            background: transparent;

            font-size: 25px;

            cursor: pointer;

            color: #111827;
        }


        /* =========================================================
           MAIN CONTENT
           ========================================================= */

        .password-content {
            flex: 1;

            display: flex;

            align-items: center;

            justify-content: center;

            padding:
                70px 24px;

            background:
                radial-gradient(
                    circle at 10% 20%,
                    rgba(37, 99, 235, 0.06),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 90% 10%,
                    rgba(124, 58, 237, 0.07),
                    transparent 30%
                ),
                linear-gradient(
                    180deg,
                    #f8fbff 0%,
                    #ffffff 100%
                );
        }

        .password-container {
            width: 100%;

            max-width: 520px;
        }


        /* =========================================================
           PAGE HEADER
           ========================================================= */

        .password-page-header {
            margin-bottom: 24px;

            text-align: center;
        }

        .password-page-title {
            font-size: 26px;

            line-height: 1.3;

            font-weight: 800;

            letter-spacing: -0.025em;

            color: #111827;
        }

        .password-page-description {
            margin-top: 8px;

            font-size: 14px;

            line-height: 1.7;

            color: #6b7280;
        }


        /* =========================================================
           CARD
           ========================================================= */

        .password-card {
            width: 100%;

            padding: 32px;

            border:
                1px solid #e5e7eb;

            border-radius: 20px;

            background: #ffffff;

            box-shadow:
                0 25px 70px
                rgba(15, 23, 42, 0.10);
        }


        /* =========================================================
           ICON
           ========================================================= */

        .password-icon-wrapper {
            display: flex;

            justify-content: center;

            margin-bottom: 20px;
        }

        .password-icon {
            width: 64px;

            height: 64px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #eff6ff;

            color: #2563eb;
        }

        .password-icon svg {
            width: 30px;

            height: 30px;
        }


        /* =========================================================
           DESCRIPTION
           ========================================================= */

        .password-description {
            margin-bottom: 24px;

            text-align: center;
        }

        .password-description-title {
            font-size: 18px;

            line-height: 1.4;

            font-weight: 800;

            color: #111827;
        }

        .password-url {
            margin-top: 8px;

            word-break: break-all;

            font-size: 13px;

            line-height: 1.6;

            color: #6b7280;
        }


        /* =========================================================
           FORM
           ========================================================= */

        .password-field {
            margin-bottom: 20px;
        }

        .password-label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            font-weight: 600;

            color: #374151;
        }

        .password-input {
            width: 100%;

            height: 48px;

            padding:
                0 15px;

            border:
                1px solid #d1d5db;

            border-radius: 10px;

            outline: none;

            background: #ffffff;

            color: #111827;

            font-size: 14px;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .password-input::placeholder {
            color: #9ca3af;
        }

        .password-input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 4px
                rgba(37, 99, 235, 0.10);
        }


        /* =========================================================
           ERROR
           ========================================================= */

        .password-error {
            margin-top: 8px;

            font-size: 13px;

            line-height: 1.5;

            color: #ef4444;
        }


        /* =========================================================
           SUBMIT BUTTON
           ========================================================= */

        .password-submit {
            width: 100%;

            min-height: 48px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding:
                12px 20px;

            border: 0;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            color: white;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 10px 24px
                rgba(37, 99, 235, 0.20);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .password-submit:hover {
            transform: translateY(-2px);

            box-shadow:
                0 14px 30px
                rgba(37, 99, 235, 0.25);
        }

        .password-submit svg {
            width: 18px;

            height: 18px;
        }


        /* =========================================================
           SECURITY NOTE
           ========================================================= */

        .security-note {
            margin-top: 18px;

            text-align: center;

            font-size: 12px;

            line-height: 1.6;

            color: #9ca3af;
        }


        /* =========================================================
           FOOTER
           ========================================================= */

        .landing-footer {
            border-top:
                1px solid #e5e7eb;

            padding:
                30px 24px;

            color: #6b7280;

            font-size: 13px;

            background: #ffffff;
        }

        .footer-inner {
            max-width: 1200px;

            margin: 0 auto;

            display: flex;

            justify-content: space-between;

            gap: 20px;
        }


        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 700px) {

            .nav-links {
                display: none;
            }

            .mobile-menu-button {
                display: block;
            }

            .landing-nav-inner {
                padding:
                    15px 18px;
            }

            .brand-logo {
                width: 38px;

                height: 38px;
            }

            .brand-title {
                font-size: 16px;
            }

            .brand-subtitle {
                font-size: 11px;
            }

            .password-content {
                padding:
                    50px 18px;
            }

            .password-page-title {
                font-size: 23px;
            }

            .password-card {
                padding:
                    25px 20px;
            }

            .footer-inner {
                flex-direction: column;

                text-align: center;

                align-items: center;
            }
        }

    </style>

</head>


<body>

<div
    class="password-page"
    x-data="{ mobileMenu: false }"
>


    {{-- =========================================================
         NAVBAR
         ========================================================= --}}

    <nav class="landing-nav">

        <div class="landing-nav-inner">


            {{-- Brand --}}

            <a
                href="{{ route('home') }}"
                class="brand"
            >

                <div class="brand-logo">
                    Q
                </div>

                <div>

                    <div class="brand-title">
                        URL Shortener
                    </div>

                    <div class="brand-subtitle">
                        Short Link Management
                    </div>

                </div>

            </a>


            {{-- Desktop Navigation --}}

            <div class="nav-links">

                <a
                    href="{{ route('home') }}#features"
                    class="nav-link"
                >
                    Features
                </a>

                <a
                    href="{{ route('home') }}#how-it-works"
                    class="nav-link"
                >
                    How It Works
                </a>


                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="nav-link"
                    >
                        Dashboard
                    </a>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="nav-link nav-login"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="nav-link nav-register"
                    >
                        Get Started
                    </a>

                @endauth

            </div>


            {{-- Mobile Menu Button --}}

            <button
                type="button"
                class="mobile-menu-button"
                @click="mobileMenu = !mobileMenu"
                aria-label="Toggle navigation menu"
            >
                ☰
            </button>

        </div>


        {{-- =====================================================
             MOBILE MENU
             ===================================================== --}}

        <div
            x-show="mobileMenu"
            x-cloak
            class="px-6 pb-5"
        >

            <div class="flex flex-col gap-4">

                <a
                    href="{{ route('home') }}#features"
                    class="nav-link"
                    @click="mobileMenu = false"
                >
                    Features
                </a>

                <a
                    href="{{ route('home') }}#how-it-works"
                    class="nav-link"
                    @click="mobileMenu = false"
                >
                    How It Works
                </a>


                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="nav-link"
                    >
                        Dashboard
                    </a>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="nav-link"
                    >
                        Login
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="nav-link"
                    >
                        Get Started
                    </a>

                @endauth

            </div>

        </div>

    </nav>


    {{-- =========================================================
         MAIN CONTENT
         ========================================================= --}}

    <main class="password-content">

        <div class="password-container">


            {{-- =================================================
                 PAGE HEADER
                 ================================================= --}}

            <div class="password-page-header">

                <h1 class="password-page-title">
                    Password Protected Link
                </h1>

                <p class="password-page-description">
                    Enter the password to continue to this link.
                </p>

            </div>


            {{-- =================================================
                 CARD
                 ================================================= --}}

            <div class="password-card">


                {{-- =================================================
                     ICON
                     ================================================= --}}

                <div class="password-icon-wrapper">

                    <div class="password-icon">

                        <svg
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
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


                {{-- =================================================
                     LINK INFORMATION
                     ================================================= --}}

                <div class="password-description">

                    <h2 class="password-description-title">
                        This link is password protected
                    </h2>

                    <p class="password-url">
                        {{ $shortUrl->short_url }}
                    </p>

                </div>


                {{-- =================================================
                     PASSWORD FORM
                     ================================================= --}}

                <form
                    method="POST"
                    action="{{ route('short.password.verify', [
                        'shortCode' => $shortUrl->custom_alias ?: $shortUrl->short_code
                    ]) }}"
                >

                    @csrf


                    {{-- Password --}}

                    <div class="password-field">

                        <label
                            for="password"
                            class="password-label"
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
                            class="password-input"
                        >


                        @error('password')

                            <p class="password-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Submit --}}

                    <button
                        type="submit"
                        class="password-submit"
                    >

                        <svg
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 002-2H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"
                            />

                        </svg>

                        Continue

                    </button>

                </form>


                {{-- =================================================
                     SECURITY NOTE
                     ================================================= --}}

                <p class="security-note">

                    This link requires the correct password before
                    the destination can be accessed.

                </p>

            </div>

        </div>

    </main>


    {{-- =========================================================
         FOOTER
         ========================================================= --}}

    <footer class="landing-footer">

        <div class="footer-inner">

            <div>
                © 2026 URL Shortener. All rights reserved.
            </div>

            <div>
                Short Link Management Platform
            </div>

        </div>

    </footer>


</div>

</body>

</html>