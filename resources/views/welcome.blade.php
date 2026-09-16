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

    <title>
        URL Shortener
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        * {
            box-sizing: border-box;
        }

        [x-cloak] {
            display: none !important;
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

        button,
        input {
            font-family: inherit;
        }

        .landing-page {
            min-height: 100vh;

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

            backdrop-filter:
                blur(16px);

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

        .mobile-menu-button {
            display: none;

            border: 0;

            background: transparent;

            font-size: 25px;

            cursor: pointer;
        }


        /* =========================================================
           HERO
           ========================================================= */

        .hero-gradient {
            position: relative;

            overflow: hidden;

            background:

                radial-gradient(
                    circle at 10% 20%,
                    rgba(37, 99, 235, 0.10),
                    transparent 30%
                ),

                radial-gradient(
                    circle at 90% 10%,
                    rgba(124, 58, 237, 0.12),
                    transparent 30%
                ),

                linear-gradient(
                    180deg,
                    #f8fbff 0%,
                    #ffffff 100%
                );
        }

        .hero {
            max-width: 1200px;

            margin: 0 auto;

            padding:
                85px 24px 80px;

            text-align: center;
        }

        .hero-badge {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding:
                7px 13px;

            border-radius: 999px;

            background: #eff6ff;

            color: #2563eb;

            font-size: 13px;

            font-weight: 700;

            border:
                1px solid #dbeafe;
        }

        .hero-title {
            max-width: 850px;

            margin:
                22px auto 0;

            font-size:
                clamp(38px, 6vw, 68px);

            line-height: 1.05;

            letter-spacing:
                -0.045em;

            font-weight: 850;

            color: #111827;
        }

        .hero-title span {
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #7c3aed
                );

            -webkit-background-clip: text;

            background-clip: text;

            color: transparent;
        }

        .hero-description {
            max-width: 700px;

            margin:
                24px auto 0;

            font-size: 18px;

            line-height: 1.7;

            color: #6b7280;
        }


        /* =========================================================
           GENERATOR CARD
           ========================================================= */

        .generator-card {
            max-width: 900px;

            margin:
                42px auto 0;

            padding: 10px;

            border-radius: 20px;

            background: white;

            border:
                1px solid #e5e7eb;

            box-shadow:
                0 25px 70px
                rgba(15, 23, 42, 0.10);
        }

        .generator-inner {
            padding: 25px;

            border-radius: 14px;

            background:
                linear-gradient(
                    180deg,
                    #ffffff,
                    #f8fafc
                );
        }

        .url-input-wrapper {
            display: flex;

            align-items: center;

            gap: 12px;

            padding:
                7px 7px 7px 18px;

            border:
                1px solid #d1d5db;

            border-radius: 14px;

            background: white;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .url-input-wrapper:focus-within {
            border-color: #2563eb;

            box-shadow:
                0 0 0 4px
                rgba(37, 99, 235, 0.10);
        }

        .url-icon {
            color: #6b7280;

            font-size: 18px;
        }

        .url-input {
            flex: 1;

            min-width: 0;

            border: 0;

            outline: 0;

            background: transparent;

            font-size: 16px;

            color: #111827;
        }

        .url-input::placeholder {
            color: #9ca3af;
        }

        .generator-buttons {
            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 12px;

            margin-top: 14px;
        }

        .primary-generator-button,
        .qr-generator-button {
            min-height: 52px;

            border: 0;

            border-radius: 12px;

            font-size: 15px;

            font-weight: 750;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;
        }

        .primary-generator-button {
            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            color: white;

            box-shadow:
                0 10px 24px
                rgba(37, 99, 235, 0.22);
        }

        .qr-generator-button {
            background: #111827;

            color: white;

            box-shadow:
                0 10px 24px
                rgba(17, 24, 39, 0.16);
        }

        .primary-generator-button:hover,
        .qr-generator-button:hover {
            transform:
                translateY(-2px);
        }

        .primary-generator-button:disabled,
        .qr-generator-button:disabled {
            opacity: 0.65;

            cursor: not-allowed;

            transform: none;
        }

        .generator-note {
            margin-top: 15px;

            font-size: 12px;

            color: #9ca3af;

            text-align: center;
        }


        /* =========================================================
           ALERT
           ========================================================= */

        .landing-alert {
            max-width: 900px;

            margin:
                20px auto 0;

            padding:
                13px 16px;

            border-radius: 12px;

            background: #ecfdf5;

            border:
                1px solid #a7f3d0;

            color: #047857;

            font-size: 14px;

            text-align: left;
        }

        .landing-error {
            max-width: 900px;

            margin:
                20px auto 0;

            padding:
                13px 16px;

            border-radius: 12px;

            background: #fef2f2;

            border:
                1px solid #fecaca;

            color: #b91c1c;

            font-size: 14px;

            text-align: left;

            display: none;
        }


        /* =========================================================
           AJAX RESULT
           ========================================================= */

        #ajax-result {
            display: none;
        }

        .result-section {
            max-width: 900px;

            margin:
                35px auto 0;

            text-align: left;
        }

        .result-card {
            padding: 24px;

            border:
                1px solid #dbeafe;

            border-radius: 18px;

            background:
                linear-gradient(
                    135deg,
                    #f8fbff,
                    #ffffff
                );

            box-shadow:
                0 15px 40px
                rgba(37, 99, 235, 0.08);
        }

        .result-header {
            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 18px;
        }

        .success-icon {
            width: 42px;

            height: 42px;

            flex-shrink: 0;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background: #dcfce7;

            color: #16a34a;

            font-size: 20px;

            font-weight: 800;
        }

        .result-title {
            font-size: 17px;

            font-weight: 800;

            color: #111827;
        }

        .result-subtitle {
            margin-top: 3px;

            font-size: 13px;

            color: #6b7280;
        }

        .result-label {
            margin-bottom: 8px;

            font-size: 13px;

            font-weight: 700;

            color: #374151;
        }

        .short-url-box {
            display: flex;

            gap: 10px;

            padding: 7px;

            border:
                1px solid #d1d5db;

            border-radius: 12px;

            background: white;
        }

        .short-url-input {
            flex: 1;

            min-width: 0;

            border: 0;

            outline: 0;

            background: transparent;

            padding:
                9px 11px;

            color: #2563eb;

            font-size: 15px;

            font-weight: 650;
        }

        .copy-button {
            border: 0;

            border-radius: 9px;

            padding:
                0 17px;

            min-height: 42px;

            background: #2563eb;

            color: white;

            font-weight: 700;

            cursor: pointer;
        }

        .copy-button:hover {
            background: #1d4ed8;
        }

        .qr-result-box {
            margin-top: 18px;

            padding: 20px;

            border:
                1px solid #e5e7eb;

            border-radius: 14px;

            background: white;
        }

        .qr-result-title {
            font-size: 15px;

            font-weight: 800;

            color: #111827;
        }

        .qr-result-description {
            margin-top: 5px;

            color: #6b7280;

            font-size: 13px;

            line-height: 1.6;
        }

        .download-qr-button {
            display: inline-flex;

            margin-top: 14px;

            padding:
                10px 16px;

            border-radius: 9px;

            background: #111827;

            color: white;

            text-decoration: none;

            font-size: 13px;

            font-weight: 700;
        }

        .download-qr-button:hover {
            background: #1f2937;
        }

        .clear-result-button {
            margin-top: 18px;

            padding:
                9px 14px;

            border:
                1px solid #d1d5db;

            border-radius: 9px;

            background: white;

            color: #4b5563;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;
        }

        .clear-result-button:hover {
            background: #f9fafb;
        }


        /* =========================================================
           TRUST
           ========================================================= */

        .trust-section {
            max-width: 900px;

            margin:
                30px auto 0;

            display: flex;

            justify-content: center;

            gap: 30px;

            flex-wrap: wrap;

            color: #6b7280;

            font-size: 13px;
        }


        /* =========================================================
           FEATURES
           ========================================================= */

        .features-section {
            max-width: 1200px;

            margin: 0 auto;

            padding:
                95px 24px;
        }

        .section-heading {
            max-width: 700px;

            margin:
                0 auto 50px;

            text-align: center;
        }

        .section-label {
            color: #2563eb;

            font-size: 13px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing:
                0.08em;
        }

        .section-title {
            margin-top: 10px;

            font-size:
                clamp(28px, 4vw, 42px);

            font-weight: 850;

            letter-spacing:
                -0.03em;

            color: #111827;
        }

        .section-description {
            margin-top: 14px;

            color: #6b7280;

            line-height: 1.7;
        }

        .features-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }

        .feature-card {
            padding: 28px;

            border:
                1px solid #e5e7eb;

            border-radius: 18px;

            background: white;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .feature-card:hover {
            transform:
                translateY(-5px);

            box-shadow:
                0 20px 45px
                rgba(15, 23, 42, 0.08);
        }

        .feature-icon {
            width: 48px;

            height: 48px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 13px;

            background: #eff6ff;

            color: #2563eb;

            font-size: 21px;
        }

        .feature-title {
            margin-top: 18px;

            font-size: 17px;

            font-weight: 800;
        }

        .feature-description {
            margin-top: 8px;

            color: #6b7280;

            font-size: 14px;

            line-height: 1.7;
        }


        /* =========================================================
           ANALYTICS PREVIEW
           ========================================================= */

        .analytics-section {
            background: #f8fafc;

            padding:
                95px 24px;
        }

        .analytics-container {
            max-width: 1100px;

            margin: 0 auto;

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 60px;

            align-items: center;
        }

        .analytics-copy h2 {
            margin-top: 10px;

            font-size:
                clamp(30px, 4vw, 44px);

            line-height: 1.15;

            font-weight: 850;
        }

        .analytics-copy p {
            margin-top: 18px;

            color: #6b7280;

            line-height: 1.8;
        }

        .analytics-card {
            padding: 24px;

            border:
                1px solid #e5e7eb;

            border-radius: 18px;

            background: white;

            box-shadow:
                0 20px 50px
                rgba(15, 23, 42, 0.07);
        }

        .analytics-card-header {
            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .analytics-card-title {
            font-weight: 800;
        }

        .analytics-period {
            padding:
                6px 9px;

            border-radius: 8px;

            background: #f3f4f6;

            color: #6b7280;

            font-size: 11px;
        }

        .analytics-number {
            margin-top: 24px;

            font-size: 34px;

            font-weight: 850;
        }

        .analytics-growth {
            margin-top: 4px;

            color: #16a34a;

            font-size: 13px;

            font-weight: 700;
        }

        .analytics-bars {
            height: 150px;

            margin-top: 25px;

            display: flex;

            align-items: end;

            gap: 9px;
        }

        .analytics-bar {
            flex: 1;

            border-radius:
                7px 7px 0 0;

            background:
                linear-gradient(
                    180deg,
                    #60a5fa,
                    #2563eb
                );
        }


        /* =========================================================
           HOW IT WORKS
           ========================================================= */

        .steps-section {
            max-width: 1100px;

            margin: 0 auto;

            padding:
                95px 24px;
        }

        .steps-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;
        }

        .step-card {
            position: relative;

            padding: 30px;

            border:
                1px solid #e5e7eb;

            border-radius: 18px;

            background: white;
        }

        .step-number {
            width: 42px;

            height: 42px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #111827;

            color: white;

            font-weight: 800;
        }

        .step-title {
            margin-top: 18px;

            font-size: 17px;

            font-weight: 800;
        }

        .step-description {
            margin-top: 8px;

            color: #6b7280;

            font-size: 14px;

            line-height: 1.7;
        }


        /* =========================================================
           CTA
           ========================================================= */

        .cta-section {
            max-width: 1100px;

            margin:
                0 auto 90px;

            padding:
                55px 30px;

            border-radius: 24px;

            text-align: center;

            background:
                linear-gradient(
                    135deg,
                    #111827,
                    #1e3a8a
                );

            color: white;
        }

        .cta-title {
            font-size:
                clamp(28px, 4vw, 42px);

            font-weight: 850;
        }

        .cta-description {
            max-width: 600px;

            margin:
                14px auto 0;

            color: #dbeafe;

            line-height: 1.7;
        }

        .cta-button {
            display: inline-flex;

            margin-top: 25px;

            padding:
                12px 20px;

            border-radius: 10px;

            background: white;

            color: #111827;

            text-decoration: none;

            font-weight: 800;
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

        @media (max-width: 900px) {

            .features-grid {
                grid-template-columns:
                    1fr 1fr;
            }

            .analytics-container {
                grid-template-columns:
                    1fr;
            }

            .steps-grid {
                grid-template-columns:
                    1fr 1fr;
            }
        }


        @media (max-width: 700px) {

            .nav-links {
                display: none;
            }

            .mobile-menu-button {
                display: block;
            }

            .hero {
                padding:
                    65px 18px;
            }

            .hero-description {
                font-size: 16px;
            }

            .generator-inner {
                padding: 15px;
            }

            .url-input-wrapper {
                padding:
                    13px 14px;
            }

            .generator-buttons {
                grid-template-columns:
                    1fr;
            }

            .short-url-box {
                flex-direction: column;
            }

            .copy-button {
                min-height: 44px;
            }

            .features-grid {
                grid-template-columns:
                    1fr;
            }

            .steps-grid {
                grid-template-columns:
                    1fr;
            }

            .footer-inner {
                flex-direction: column;
            }
        }

    </style>

</head>


<body>

<div
    class="landing-page"
    x-data="{ mobileMenu: false }"
>


    {{-- =========================================================
         NAVBAR
         ========================================================= --}}

    <nav class="landing-nav">

        <div class="landing-nav-inner">

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


            <div class="nav-links">

                <a
                    href="#features"
                    class="nav-link"
                >
                    Features
                </a>

                <a
                    href="#how-it-works"
                    class="nav-link"
                >
                    How It Works
                </a>


                @auth

                    <a
                        href="{{ auth()->user()->isAdmin()
                            ? route('admin.dashboard')
                            : route('dashboard') }}"
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


            <button
                type="button"
                class="mobile-menu-button"
                @click="mobileMenu = !mobileMenu"
            >
                ☰
            </button>

        </div>


        {{-- Mobile Menu --}}

        <div
            x-show="mobileMenu"
            x-cloak
            class="px-6 pb-5"
        >

            <div class="flex flex-col gap-4">

                <a
                    href="#features"
                    class="nav-link"
                    @click="mobileMenu = false"
                >
                    Features
                </a>

                <a
                    href="#how-it-works"
                    class="nav-link"
                    @click="mobileMenu = false"
                >
                    How It Works
                </a>


                @auth

                    <a
                        href="{{ auth()->user()->isAdmin()
                            ? route('admin.dashboard')
                            : route('dashboard') }}"
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
         HERO
         ========================================================= --}}

    <section class="hero-gradient">

        <div class="hero">

            <div class="hero-badge">
                ⚡ Fast • Simple • Powerful
            </div>


            <h1 class="hero-title">

                Turn Long URLs Into

                <span>
                    Short Links
                </span>

            </h1>


            <p class="hero-description">

                Create short, shareable links and QR codes in seconds.
                Track performance and manage all your links from one
                powerful platform.

            </p>



            {{-- =====================================================
                 URL GENERATOR
                 ===================================================== --}}

            <div class="generator-card">

                <div class="generator-inner">


                    {{-- =================================================
                         SHORT URL FORM
                         ================================================= --}}

                    <form
                        id="short-url-form"
                        method="POST"
                        action="{{ route('links.store') }}"
                    >

                        @csrf


                        <div class="url-input-wrapper">

                            <span class="url-icon">
                                🔗
                            </span>


                            <input
                                type="url"
                                name="original_url"
                                id="landing-original-url"
                                required
                                value="{{ old('original_url') }}"
                                placeholder="Paste your long URL here..."
                                class="url-input"
                            >

                        </div>



                        <div class="generator-buttons">

                            <button
                                type="submit"
                                id="shorten-button"
                                class="primary-generator-button"
                            >
                                Shorten URL
                            </button>


                            <button
                                type="button"
                                id="qr-button"
                                class="qr-generator-button"
                            >
                                Generate QR Code
                            </button>

                        </div>

                    </form>



                    {{-- =================================================
                         SEPARATE QR FORM
                         ================================================= --}}

                    <form
                        id="guest-qr-form"
                        method="POST"
                        action="{{ route('qr-codes.guest.generate') }}"
                        style="display:none;"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="original_url"
                            id="guest-qr-url"
                        >

                    </form>



                    <p class="generator-note">

                        No registration required for basic URL shortening
                        and QR generation.

                    </p>

                </div>

            </div>



            {{-- =====================================================
                 SERVER-SIDE VALIDATION ERRORS
                 ===================================================== --}}

            @if($errors->any())

                <div class="landing-alert">

                    <ul class="m-0 list-disc pl-5">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif



            {{-- =====================================================
                 SERVER-SIDE SUCCESS
                 ===================================================== --}}

            @if(session('success'))

                <div class="landing-alert">

                    {{ session('success') }}

                </div>

            @endif



            {{-- =====================================================
                 AJAX ERROR
                 ===================================================== --}}

            <div
                id="ajax-error"
                class="landing-error"
            ></div>



            {{-- =====================================================
                 AJAX RESULT
                 ===================================================== --}}

            <div
                id="ajax-result"
            ></div>



            {{-- =====================================================
                 OLD SESSION RESULT
                 ===================================================== --}}

            @if(
                session('guest_short_url') ||
                session('short_url') ||
                session('guest_qr')
            )

                <div class="result-section">

                    <div class="result-card">

                        <div class="result-header">

                            <div class="success-icon">
                                ✓
                            </div>

                            <div>

                                <div class="result-title">
                                    Your result is ready
                                </div>

                                <div class="result-subtitle">
                                    Your generated content is ready to use.
                                </div>

                            </div>

                        </div>



                        {{-- SHORT URL RESULT --}}

                        @if(
                            session('guest_short_url') ||
                            session('short_url')
                        )

                            <div>

                                <div class="result-label">
                                    Your Short URL
                                </div>


                                <div class="short-url-box">

                                    <input
                                        id="generated-session-short-url"
                                        type="text"
                                        readonly
                                        value="{{ session('guest_short_url') ?? session('short_url') }}"
                                        class="short-url-input"
                                    >


                                    <button
                                        type="button"
                                        class="copy-button"
                                        onclick="
                                            copyText(
                                                document.getElementById(
                                                    'generated-session-short-url'
                                                ).value,
                                                this
                                            )
                                        "
                                    >
                                        Copy
                                    </button>

                                </div>

                            </div>

                        @endif



                        {{-- QR RESULT --}}

                        @if(session('guest_qr'))

                            <div class="qr-result-box">

                                <div class="qr-result-title">
                                    QR Code Ready
                                </div>

                                <div class="qr-result-description">
                                    Your QR code contains the original URL.
                                </div>


                                <a
                                    href="{{ route('qr-codes.guest.download') }}"
                                    class="download-qr-button"
                                >
                                    Download QR Code
                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            @endif



            {{-- =====================================================
                 TRUST
                 ===================================================== --}}

            <div class="trust-section">

                <span>
                    ✓ No registration required
                </span>

                <span>
                    ✓ Fast URL generation
                </span>

                <span>
                    ✓ QR code support
                </span>

                <span>
                    ✓ Secure platform
                </span>

            </div>

        </div>

    </section>



    {{-- =========================================================
         FEATURES
         ========================================================= --}}

    <section
        id="features"
        class="features-section"
    >

        <div class="section-heading">

            <div class="section-label">
                Powerful Features
            </div>

            <h2 class="section-title">
                Everything you need to manage links
            </h2>

            <p class="section-description">

                Create, organize, analyze and share your links
                from a single platform.

            </p>

        </div>



        <div class="features-grid">


            <div class="feature-card">

                <div class="feature-icon">
                    🔗
                </div>

                <div class="feature-title">
                    Short URLs
                </div>

                <div class="feature-description">

                    Transform long URLs into clean,
                    memorable and shareable links.

                </div>

            </div>



            <div class="feature-card">

                <div class="feature-icon">
                    ▦
                </div>

                <div class="feature-title">
                    QR Codes
                </div>

                <div class="feature-description">

                    Generate downloadable QR codes
                    for your links and campaigns.

                </div>

            </div>



            <div class="feature-card">

                <div class="feature-icon">
                    ◔
                </div>

                <div class="feature-title">
                    Analytics
                </div>

                <div class="feature-description">

                    Understand clicks, devices,
                    browsers and traffic sources.

                </div>

            </div>



            <div class="feature-card">

                <div class="feature-icon">
                    ★
                </div>

                <div class="feature-title">
                    Favorites
                </div>

                <div class="feature-description">

                    Keep your most important links
                    organized and easy to access.

                </div>

            </div>



            <div class="feature-card">

                <div class="feature-icon">
                    🔒
                </div>

                <div class="feature-title">
                    Password Protection
                </div>

                <div class="feature-description">

                    Protect sensitive links with
                    password-based access.

                </div>

            </div>



            <div class="feature-card">

                <div class="feature-icon">
                    ⏱
                </div>

                <div class="feature-title">
                    Expiration
                </div>

                <div class="feature-description">

                    Automatically deactivate links
                    after a selected date.

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         ANALYTICS
         ========================================================= --}}

    <section class="analytics-section">

        <div class="analytics-container">


            <div class="analytics-copy">

                <div class="section-label">
                    Link Analytics
                </div>

                <h2>
                    Know how your links perform.
                </h2>

                <p>

                    Registered users can monitor link performance
                    with detailed analytics and reports.

                </p>

            </div>



            <div class="analytics-card">

                <div class="analytics-card-header">

                    <div class="analytics-card-title">
                        Total Clicks
                    </div>

                    <div class="analytics-period">
                        Last 7 days
                    </div>

                </div>


                <div class="analytics-number">
                    12,480
                </div>


                <div class="analytics-growth">
                    ↑ 18.6% compared with previous period
                </div>


                <div class="analytics-bars">

                    <div
                        class="analytics-bar"
                        style="height: 42%;"
                    ></div>

                    <div
                        class="analytics-bar"
                        style="height: 58%;"
                    ></div>

                    <div
                        class="analytics-bar"
                        style="height: 50%;"
                    ></div>

                    <div
                        class="analytics-bar"
                        style="height: 70%;"
                    ></div>

                    <div
                        class="analytics-bar"
                        style="height: 62%;"
                    ></div>

                    <div
                        class="analytics-bar"
                        style="height: 84%;"
                    ></div>

                    <div
                        class="analytics-bar"
                        style="height: 96%;"
                    ></div>

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         HOW IT WORKS
         ========================================================= --}}

    <section
        id="how-it-works"
        class="steps-section"
    >

        <div class="section-heading">

            <div class="section-label">
                How It Works
            </div>

            <h2 class="section-title">
                Create a short link in three steps
            </h2>

        </div>



        <div class="steps-grid">


            <div class="step-card">

                <div class="step-number">
                    1
                </div>

                <div class="step-title">
                    Paste your URL
                </div>

                <div class="step-description">

                    Enter any valid long URL into
                    the generator above.

                </div>

            </div>



            <div class="step-card">

                <div class="step-number">
                    2
                </div>

                <div class="step-title">
                    Generate
                </div>

                <div class="step-description">

                    Click Shorten URL or Generate QR Code
                    depending on what you need.

                </div>

            </div>



            <div class="step-card">

                <div class="step-number">
                    3
                </div>

                <div class="step-title">
                    Share
                </div>

                <div class="step-description">

                    Copy your short URL or download
                    your QR code and share it anywhere.

                </div>

            </div>

        </div>

    </section>



    {{-- =========================================================
         CTA
         ========================================================= --}}

    <section class="cta-section">

        <div class="cta-title">
            Ready to manage your links shorter?
        </div>

        <div class="cta-description">

            Create an account to unlock analytics,
            custom aliases, link management,
            reports and more.

        </div>


        @auth

            <a
                href="{{ auth()->user()->isAdmin()
                    ? route('admin.dashboard')
                    : route('dashboard') }}"
                class="cta-button"
            >
                Go to Dashboard
            </a>

        @else

            <a
                href="{{ route('register') }}"
                class="cta-button"
            >
                Create Free Account
            </a>

        @endauth

    </section>



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



<script>

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const csrfToken =
        document
            .querySelector(
                'meta[name="csrf-token"]'
            )
            .getAttribute('content');


    const shortUrlForm =
        document.getElementById(
            'short-url-form'
        );


    const originalUrlInput =
        document.getElementById(
            'landing-original-url'
        );


    const shortenButton =
        document.getElementById(
            'shorten-button'
        );


    const qrButton =
        document.getElementById(
            'qr-button'
        );


    const qrForm =
        document.getElementById(
            'guest-qr-form'
        );


    const qrUrlInput =
        document.getElementById(
            'guest-qr-url'
        );


    const ajaxResult =
        document.getElementById(
            'ajax-result'
        );


    const ajaxError =
        document.getElementById(
            'ajax-error'
        );


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        const div =
            document.createElement(
                'div'
            );

        div.textContent =
            value;

        return div.innerHTML;
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW ERROR
    |--------------------------------------------------------------------------
    */

    function showAjaxError(message) {

        ajaxError.textContent =
            message;

        ajaxError.style.display =
            'block';

        ajaxError.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }


    /*
    |--------------------------------------------------------------------------
    | HIDE ERROR
    |--------------------------------------------------------------------------
    */

    function hideAjaxError() {

        ajaxError.textContent =
            '';

        ajaxError.style.display =
            'none';
    }


    /*
    |--------------------------------------------------------------------------
    | CLEAR RESULT
    |--------------------------------------------------------------------------
    */

    function clearAjaxResult() {

        ajaxResult.innerHTML =
            '';

        ajaxResult.style.display =
            'none';
    }


    /*
    |--------------------------------------------------------------------------
    | COPY TEXT
    |--------------------------------------------------------------------------
    */

    async function copyText(
        text,
        button
    ) {

        try {

            await navigator
                .clipboard
                .writeText(text);

            const oldText =
                button.textContent;

            button.textContent =
                'Copied!';

            setTimeout(
                function () {

                    button.textContent =
                        oldText;

                },
                2000
            );

        } catch (error) {

            const temporaryInput =
                document.createElement(
                    'textarea'
                );

            temporaryInput.value =
                text;

            document.body.appendChild(
                temporaryInput
            );

            temporaryInput.select();

            document.execCommand(
                'copy'
            );

            temporaryInput.remove();

            button.textContent =
                'Copied!';

            setTimeout(
                function () {

                    button.textContent =
                        'Copy';

                },
                2000
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW SHORT URL RESULT
    |--------------------------------------------------------------------------
    */

    function showShortUrlResult(
        shortUrl
    ) {

        ajaxResult.innerHTML = `

            <div class="result-section">

                <div class="result-card">

                    <div class="result-header">

                        <div class="success-icon">
                            ✓
                        </div>

                        <div>

                            <div class="result-title">
                                Your result is ready
                            </div>

                            <div class="result-subtitle">
                                Your short URL was created successfully.
                            </div>

                        </div>

                    </div>


                    <div>

                        <div class="result-label">
                            Your Short URL
                        </div>


                        <div class="short-url-box">

                            <input
                                id="ajax-generated-short-url"
                                type="text"
                                readonly
                                value="${escapeHtml(shortUrl)}"
                                class="short-url-input"
                            >


                            <button
                                type="button"
                                class="copy-button"
                                id="ajax-copy-button"
                            >
                                Copy
                            </button>

                        </div>

                    </div>


                    <button
                        type="button"
                        class="clear-result-button"
                        id="ajax-clear-button"
                    >
                        Clear result
                    </button>

                </div>

            </div>

        `;


        ajaxResult.style.display =
            'block';


        /*
        |--------------------------------------------------------------------------
        | COPY BUTTON
        |--------------------------------------------------------------------------
        */

        const copyButton =
            document.getElementById(
                'ajax-copy-button'
            );


        copyButton.addEventListener(
            'click',
            function () {

                copyText(
                    shortUrl,
                    copyButton
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | CLEAR BUTTON
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'ajax-clear-button'
            )
            .addEventListener(
                'click',
                clearAjaxResult
            );


        /*
        |--------------------------------------------------------------------------
        | SCROLL TO RESULT
        |--------------------------------------------------------------------------
        */

        ajaxResult.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });

    }


    /*
    |--------------------------------------------------------------------------
    | SHOW QR RESULT
    |--------------------------------------------------------------------------
    */

    function showQrResult(
        downloadUrl
    ) {

        ajaxResult.innerHTML = `

            <div class="result-section">

                <div class="result-card">

                    <div class="result-header">

                        <div class="success-icon">
                            ✓
                        </div>

                        <div>

                            <div class="result-title">
                                QR Code is ready
                            </div>

                            <div class="result-subtitle">
                                Your QR code was generated successfully.
                            </div>

                        </div>

                    </div>


                    <div class="qr-result-box">

                        <div class="qr-result-title">
                            QR Code Ready
                        </div>

                        <div class="qr-result-description">

                            Your QR code contains the original URL.
                            Click the button below to download it.

                        </div>


                        <a
                            href="${escapeHtml(downloadUrl)}"
                            class="download-qr-button"
                        >
                            Download QR Code
                        </a>

                    </div>


                    <button
                        type="button"
                        class="clear-result-button"
                        id="ajax-clear-qr-button"
                    >
                        Clear result
                    </button>

                </div>

            </div>

        `;


        ajaxResult.style.display =
            'block';


        /*
        |--------------------------------------------------------------------------
        | CLEAR QR RESULT
        |--------------------------------------------------------------------------
        */

        document
            .getElementById(
                'ajax-clear-qr-button'
            )
            .addEventListener(
                'click',
                clearAjaxResult
            );


        /*
        |--------------------------------------------------------------------------
        | SCROLL TO RESULT
        |--------------------------------------------------------------------------
        */

        ajaxResult.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });

    }


    /*
    |--------------------------------------------------------------------------
    | SHORTEN URL - AJAX
    |--------------------------------------------------------------------------
    */

    if (shortUrlForm) {

        shortUrlForm.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();

                hideAjaxError();


                const originalUrl =
                    originalUrlInput
                        .value
                        .trim();


                if (!originalUrl) {

                    showAjaxError(
                        'Please enter a URL.'
                    );

                    originalUrlInput.focus();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Loading
                |--------------------------------------------------------------------------
                */

                shortenButton.disabled =
                    true;

                shortenButton.textContent =
                    'Creating...';


                try {

                    const response =
                        await fetch(
                            shortUrlForm.action,
                            {
                                method: 'POST',

                                headers: {

                                    'Content-Type':
                                        'application/json',

                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrfToken,

                                    'X-Requested-With':
                                        'XMLHttpRequest'

                                },

                                body:
                                    JSON.stringify({
                                        original_url:
                                            originalUrl
                                    })
                            }
                        );


                    const data =
                        await response.json();


                    /*
                    |--------------------------------------------------------------------------
                    | ERROR
                    |--------------------------------------------------------------------------
                    */

                    if (!response.ok) {

                        if (
                            data.errors
                            &&
                            data.errors.original_url
                        ) {

                            showAjaxError(
                                data.errors.original_url[0]
                            );

                        } else {

                            showAjaxError(
                                data.message
                                ||
                                'Unable to create the short URL.'
                            );
                        }

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS
                    |--------------------------------------------------------------------------
                    */

                    if (
                        data.success
                        &&
                        data.short_url
                    ) {

                        showShortUrlResult(
                            data.short_url
                        );

                    } else {

                        showAjaxError(
                            'Unable to create the short URL.'
                        );
                    }

                } catch (error) {

                    console.error(
                        'Short URL AJAX error:',
                        error
                    );

                    showAjaxError(
                        'Something went wrong. Please try again.'
                    );

                } finally {

                    shortenButton.disabled =
                        false;

                    shortenButton.textContent =
                        'Shorten URL';

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | QR CODE - AJAX
    |--------------------------------------------------------------------------
    */

    if (qrButton) {

        qrButton.addEventListener(
            'click',
            async function () {

                hideAjaxError();


                const originalUrl =
                    originalUrlInput
                        .value
                        .trim();


                if (!originalUrl) {

                    showAjaxError(
                        'Please enter a URL.'
                    );

                    originalUrlInput.focus();

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Keep Hidden QR Input Updated
                |--------------------------------------------------------------------------
                */

                qrUrlInput.value =
                    originalUrl;


                /*
                |--------------------------------------------------------------------------
                | Loading
                |--------------------------------------------------------------------------
                */

                qrButton.disabled =
                    true;

                qrButton.textContent =
                    'Creating QR...';


                try {

                    const response =
                        await fetch(
                            qrForm.action,
                            {
                                method: 'POST',

                                headers: {

                                    'Content-Type':
                                        'application/x-www-form-urlencoded',

                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrfToken,

                                    'X-Requested-With':
                                        'XMLHttpRequest'

                                },

                                body:
                                    new URLSearchParams({
                                        _token:
                                            csrfToken,

                                        original_url:
                                            originalUrl
                                    })
                            }
                        );


                    const data =
                        await response.json();


                    /*
                    |--------------------------------------------------------------------------
                    | ERROR
                    |--------------------------------------------------------------------------
                    */

                    if (!response.ok) {

                        if (
                            data.errors
                            &&
                            data.errors.original_url
                        ) {

                            showAjaxError(
                                data.errors.original_url[0]
                            );

                        } else {

                            showAjaxError(
                                data.message
                                ||
                                'Unable to generate the QR code.'
                            );
                        }

                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | SUCCESS
                    |--------------------------------------------------------------------------
                    */

                    if (
                        data.success
                        &&
                        data.download_url
                    ) {

                        showQrResult(
                            data.download_url
                        );

                    } else {

                        showAjaxError(
                            'Unable to generate the QR code.'
                        );
                    }

                } catch (error) {

                    console.error(
                        'QR AJAX error:',
                        error
                    );

                    showAjaxError(
                        'Something went wrong while generating the QR code.'
                    );

                } finally {

                    qrButton.disabled =
                        false;

                    qrButton.textContent =
                        'Generate QR Code';

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | KEEP QR URL SYNCHRONIZED
    |--------------------------------------------------------------------------
    */

    if (
        originalUrlInput
        &&
        qrUrlInput
    ) {

        originalUrlInput.addEventListener(
            'input',
            function () {

                qrUrlInput.value =
                    originalUrlInput.value;

            }
        );


        qrUrlInput.value =
            originalUrlInput.value;
    }

</script>


</body>

</html>
