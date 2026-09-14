<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Short URL Not Active - URL Shortener</title>

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

        .inactive-page {
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

        .inactive-content {
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


        /* =========================================================
           CARD
           ========================================================= */

        .inactive-container {
            width: 100%;

            max-width: 520px;
        }

        .inactive-card {
            width: 100%;

            padding: 32px;

            text-align: center;

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

        .inactive-icon {
            width: 64px;

            height: 64px;

            margin: 0 auto;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background: #fff7ed;

            color: #f97316;
        }

        .inactive-icon svg {
            width: 30px;

            height: 30px;
        }


        /* =========================================================
           403
           ========================================================= */

        .inactive-code {
            margin-top: 20px;

            font-size: 58px;

            line-height: 1;

            font-weight: 850;

            letter-spacing: -0.04em;

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


        /* =========================================================
           HEADING
           ========================================================= */

        .inactive-heading {
            margin-top: 18px;

            font-size: 22px;

            line-height: 1.4;

            font-weight: 800;

            color: #111827;
        }

        .inactive-description {
            margin-top: 10px;

            font-size: 14px;

            line-height: 1.7;

            color: #6b7280;
        }


        /* =========================================================
           INFORMATION BOX
           ========================================================= */

        .inactive-info {
            margin-top: 24px;

            padding:
                15px 18px;

            border:
                1px solid #fed7aa;

            border-radius: 12px;

            background: #fff7ed;

            color: #9a3412;

            font-size: 13px;

            line-height: 1.6;
        }


        /* =========================================================
           HOME BUTTON
           ========================================================= */

        .home-button {
            margin-top: 24px;

            width: 100%;

            min-height: 48px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 8px;

            padding:
                12px 20px;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            color: white;

            text-decoration: none;

            font-size: 14px;

            font-weight: 700;

            box-shadow:
                0 10px 24px
                rgba(37, 99, 235, 0.20);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .home-button:hover {
            transform: translateY(-2px);

            box-shadow:
                0 14px 30px
                rgba(37, 99, 235, 0.25);
        }

        .home-button svg {
            width: 18px;

            height: 18px;
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

            .inactive-content {
                padding:
                    50px 18px;
            }

            .inactive-card {
                padding:
                    25px 20px;
            }

            .inactive-code {
                font-size: 52px;
            }

            .inactive-heading {
                font-size: 20px;
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
    class="inactive-page"
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

    <main class="inactive-content">

        <div class="inactive-container">

            <div class="inactive-card">


                {{-- =================================================
                     ICON
                     ================================================= --}}

                <div class="inactive-icon">

                    <svg
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v4m0 4h.01M10.29 3.86l-8.82 15a1.5 1.5 0 0 0 1.3 2.25h18.46a1.5 1.5 0 0 0 1.3-2.25l-8.82-15a1.5 1.5 0 0 0-2.59 0Z"
                        />

                    </svg>

                </div>


                {{-- =================================================
                     STATUS CODE
                     ================================================= --}}

                <div class="inactive-code">
                    403
                </div>


                {{-- =================================================
                     HEADING
                     ================================================= --}}

                <h1 class="inactive-heading">

                    This short URL is not active yet.

                </h1>


                <p class="inactive-description">

                    Please try again later.

                </p>


                {{-- =================================================
                     INFORMATION
                     ================================================= --}}

                <div class="inactive-info">

                    This short link has not been activated yet.
                    Please check again later or contact the link owner
                    if you believe this is unexpected.

                </div>


                {{-- =================================================
                     HOME BUTTON
                     ================================================= --}}

                <a
                    href="{{ route('home') }}"
                    class="home-button"
                >

                    <svg
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l9-9 9 9M5 10v10a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V10"
                        />

                    </svg>

                    Back to Home

                </a>

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