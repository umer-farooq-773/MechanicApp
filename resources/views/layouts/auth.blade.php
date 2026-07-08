<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Special Touch Car Care'))</title>
    <link rel="icon" href="{{ asset('assets/logo/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/logo/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo/logo.png') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css'])

    <style>
        /* ===== Auth Base ===== */
        :root {
            --primary-900: #0E2038;
            --primary-800: #142B4C;
            --primary-700: #1B3A63;
            --primary-600: #234C7C;
            --primary-500: #2D5F96;
            --primary-400: #5AA7E0;
            --primary-300: #7DBCEA;
            --primary-200: #A8D4F2;
            --primary-100: #D3E9F8;
            --primary-50: #E8F3FC;

            --accent-gradient: linear-gradient(135deg, #142B4C 0%, #0E2038 100%);

            --surface: #F0F4F9;
            --card-bg: #FFFFFF;
            --border-color: #E8EDF4;

            --text-primary: #0E2038;
            --text-secondary: #4A5B6E;
            --text-muted: #8A9BAE;

            --success: #10B981;
            --success-light: #D1FAE5;
            --warning: #F59E0B;
            --warning-light: #FEF3C7;
            --danger: #EF4444;
            --danger-light: #FEE2E2;
            --info: #3B82F6;
            --info-light: #DBEAFE;

            --shadow-sm: 0 1px 3px rgba(14, 32, 56, 0.06);
            --shadow-md: 0 4px 16px rgba(14, 32, 56, 0.08);
            --shadow-lg: 0 12px 40px rgba(14, 32, 56, 0.12);
            --shadow-xl: 0 20px 60px rgba(14, 32, 56, 0.16);

            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--surface);
            color: var(--text-primary);
            min-height: 100vh;
            opacity: 0;
            animation: fadeIn 0.3s ease forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text-primary);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ===== Scrollbar ===== */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: var(--surface);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary-400);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-500);
        }

        /* ===== Animations ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* ===== Loading Spinner ===== */
        #auth-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        #auth-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid var(--primary-50);
            border-top: 4px solid var(--primary-500);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- ===== Loading Spinner ===== -->
    <div id="auth-loader">
        <div class="loader-spinner"></div>
    </div>

    @yield('content')

    <script>
        // Hide loader when page is ready
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('auth-loader');
            if (loader) {
                setTimeout(function() {
                    loader.classList.add('hidden');
                }, 500);
            }
        });
    </script>

    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
