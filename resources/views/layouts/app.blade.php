<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Special Touch Car Care'))</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('assets/logo/logo.png') }}">
<link rel="shortcut icon" href="{{ asset('assets/logo/logo.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/logo/logo.png') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css'])

    <style>
        /* ===== CSS Variables ===== */
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
            --accent-gradient-light: linear-gradient(135deg, #1B3A63 0%, #142B4C 100%);

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

            --sidebar-width: 270px;
            --header-height: 72px;
        }

        /* ===== Reset & Base ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--surface);
            color: var(--text-primary);
            overflow-x: hidden;
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

        /* ===== Loading Spinner ===== */
        #app-loader {
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

        #app-loader.hidden {
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

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--accent-gradient);
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .sidebar-brand .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-brand .logo-icon {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.12);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .brand-text {
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .sidebar-brand .brand-sub {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
            font-weight: 400;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        /* Sidebar Navigation */
        .sidebar-nav {
            padding: 20px 16px;
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-nav .nav-label {
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 12px 12px 8px;
        }

        .sidebar-nav .nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            margin-bottom: 2px;
            position: relative;
        }

        .sidebar-nav .nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: #fff;
        }

        .sidebar-nav .nav-item.active {
            background: rgba(255,255,255,0.12);
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .sidebar-nav .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 24px;
            background: var(--primary-400);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-nav .nav-item i {
            width: 20px;
            font-size: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-nav .nav-item .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-size: 10px;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .sidebar-footer .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,0.04);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .sidebar-footer .user-card:hover {
            background: rgba(255,255,255,0.08);
        }

        .sidebar-footer .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            flex-shrink: 0;
        }

        .sidebar-footer .user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-footer .user-name {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-footer .user-role {
            color: rgba(255,255,255,0.4);
            font-size: 11px;
        }

        .sidebar-footer .logout-btn {
            color: rgba(255,255,255,0.4);
            transition: color 0.2s ease;
            padding: 6px;
        }

        .sidebar-footer .logout-btn:hover {
            color: #fff;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===== Top Header ===== */
        .top-header {
            position: sticky;
            top: 0;
            z-index: 1040;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0,0,0,0.04);
            padding: 0 32px;
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-header .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .top-header .header-left .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--text-primary);
            padding: 6px;
            cursor: pointer;
            border-radius: var(--radius-sm);
            transition: background 0.2s ease;
        }

        .top-header .header-left .menu-toggle:hover {
            background: var(--surface);
        }

        .top-header .header-left .page-title h1 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .top-header .header-left .page-title p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
            font-weight: 400;
        }

        .top-header .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .top-header .header-right .search-box {
            position: relative;
        }

        .top-header .header-right .search-box input {
            background: var(--surface);
            border: none;
            padding: 8px 16px 8px 40px;
            border-radius: 50px;
            font-size: 13px;
            width: 220px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .top-header .header-right .search-box input:focus {
            outline: none;
            width: 260px;
            box-shadow: 0 0 0 3px rgba(90, 167, 224, 0.15);
            background: #fff;
        }

        .top-header .header-right .search-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .top-header .header-right .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .top-header .header-right .icon-btn:hover {
            background: var(--surface);
            color: var(--text-primary);
        }

        .top-header .header-right .icon-btn .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid #fff;
        }

        /* ===== Page Content ===== */
        .page-content {
            padding: 28px 32px 32px;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* ===== Stats Grid ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 14px;
        }

        .stat-card .stat-icon.blue {
            background: var(--primary-50);
            color: var(--primary-500);
        }
        .stat-card .stat-icon.green {
            background: var(--success-light);
            color: var(--success);
        }
        .stat-card .stat-icon.yellow {
            background: var(--warning-light);
            color: var(--warning);
        }
        .stat-card .stat-icon.red {
            background: var(--danger-light);
            color: var(--danger);
        }
        .stat-card .stat-icon.purple {
            background: #EDE9FE;
            color: #7C3AED;
        }
        .stat-card .stat-icon.orange {
            background: #FEF3C7;
            color: #D97706;
        }
        .stat-card .stat-icon.teal {
            background: #CCFBF1;
            color: #0D9488;
        }
        .stat-card .stat-icon.pink {
            background: #FCE7F3;
            color: #DB2777;
        }

        .stat-card .stat-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .stat-card .stat-label {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 2px;
        }

        .stat-card .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
            padding: 2px 10px;
            border-radius: 20px;
        }

        .stat-card .stat-trend.up {
            color: var(--success);
            background: var(--success-light);
        }

        .stat-card .stat-trend.down {
            color: var(--danger);
            background: var(--danger-light);
        }

        /* ===== Charts Grid ===== */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .chart-card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .chart-card:hover {
            box-shadow: var(--shadow-md);
        }

        .chart-card .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .chart-card .chart-header h3 {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        .chart-card .chart-header .chart-actions {
            display: flex;
            gap: 6px;
        }

        .chart-card .chart-header .chart-actions button {
            background: none;
            border: none;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .chart-card .chart-header .chart-actions button:hover,
        .chart-card .chart-header .chart-actions button.active {
            background: var(--primary-50);
            color: var(--primary-500);
        }

        .chart-card .chart-wrapper {
            position: relative;
            height: 280px;
        }

        .chart-card .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
        }

        /* ===== Activity Grid ===== */
        .activity-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .activity-card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .activity-card:hover {
            box-shadow: var(--shadow-md);
        }

        .activity-card .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .activity-card .activity-header h3 {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        .activity-card .activity-header .view-all {
            font-size: 12px;
            color: var(--primary-400);
            font-weight: 600;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .activity-card .activity-header .view-all:hover {
            color: var(--primary-500);
        }

        /* Activity List */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.2s ease;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item .item-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .activity-item .item-icon.blue {
            background: var(--primary-50);
            color: var(--primary-500);
        }
        .activity-item .item-icon.green {
            background: var(--success-light);
            color: var(--success);
        }
        .activity-item .item-icon.yellow {
            background: var(--warning-light);
            color: var(--warning);
        }
        .activity-item .item-icon.red {
            background: var(--danger-light);
            color: var(--danger);
        }

        .activity-item .item-content {
            flex: 1;
            min-width: 0;
        }

        .activity-item .item-content .item-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
        }

        .activity-item .item-content .item-sub {
            font-size: 12px;
            color: var(--text-muted);
        }

        .activity-item .item-time {
            font-size: 11px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .activity-item .item-status {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 12px;
            border-radius: 20px;
        }

        .activity-item .item-status.completed {
            background: var(--success-light);
            color: var(--success);
        }
        .activity-item .item-status.pending {
            background: var(--warning-light);
            color: var(--warning);
        }
        .activity-item .item-status.in-progress {
            background: var(--primary-50);
            color: var(--primary-500);
        }

        /* ===== Responsive ===== */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            .charts-grid {
                grid-template-columns: 1fr;
            }
            .activity-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            :root {
                --sidebar-width: 0px;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .top-header .header-left .menu-toggle {
                display: flex;
            }

            .top-header {
                padding: 0 20px;
            }

            .page-content {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .stat-card {
                padding: 18px 20px;
            }

            .stat-card .stat-value {
                font-size: 20px;
            }

            .top-header .header-right .search-box input {
                width: 140px;
                font-size: 12px;
            }

            .top-header .header-right .search-box input:focus {
                width: 160px;
            }

            .top-header .header-left .page-title h1 {
                font-size: 16px;
            }

            .top-header .header-left .page-title p {
                font-size: 11px;
            }

            .page-content {
                padding: 16px;
            }

            .chart-card .chart-wrapper {
                height: 220px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .stat-card {
                padding: 14px 16px;
            }

            .stat-card .stat-icon {
                width: 36px;
                height: 36px;
                font-size: 16px;
                margin-bottom: 10px;
            }

            .stat-card .stat-value {
                font-size: 17px;
            }

            .stat-card .stat-label {
                font-size: 11px;
            }

            .top-header {
                padding: 0 14px;
                height: 60px;
            }

            .top-header .header-right .search-box input {
                width: 100px;
            }

            .top-header .header-right .search-box input:focus {
                width: 120px;
            }

            .top-header .header-right .icon-btn {
                width: 32px;
                height: 32px;
                font-size: 15px;
            }

            .chart-card {
                padding: 16px 18px;
            }

            .chart-card .chart-wrapper {
                height: 180px;
            }

            .activity-card {
                padding: 16px 18px;
            }

            .activity-item {
                padding: 8px 0;
            }

            .activity-item .item-content .item-title {
                font-size: 12px;
            }
        }

        /* ===== Overlay for mobile ===== */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 1045;
            backdrop-filter: blur(4px);
        }

        .sidebar-overlay.active {
            display: block;
        }

        /* ===== Animations ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        .animate-in:nth-child(1) { animation-delay: 0.05s; }
        .animate-in:nth-child(2) { animation-delay: 0.1s; }
        .animate-in:nth-child(3) { animation-delay: 0.15s; }
        .animate-in:nth-child(4) { animation-delay: 0.2s; }
        .animate-in:nth-child(5) { animation-delay: 0.25s; }
        .animate-in:nth-child(6) { animation-delay: 0.3s; }
        .animate-in:nth-child(7) { animation-delay: 0.35s; }
        .animate-in:nth-child(8) { animation-delay: 0.4s; }

    </style>

    @stack('styles')
</head>
<body>
    <!-- ===== Loading Spinner ===== -->
    <div id="app-loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- ===== Sidebar Overlay (Mobile) ===== -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ===== Sidebar ===== -->
    <nav class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="logo-wrapper">
                <div class="logo-icon">
                    <img src="{{ asset('assets/logo/logo.png') }}" alt="logo" />
                </div>
                <div>
                    <div class="brand-text">Special Touch</div>
                    <div class="brand-sub">CAR CARE</div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="sidebar-nav">
            <div class="nav-label">Main Menu</div>

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-tasks"></i>
                <span>Job Management</span>
                <span class="badge">12</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-users"></i>
                <span>Customers</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-car-side"></i>
                <span>Vehicles</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-wrench"></i>
                <span>Services</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Invoices</span>
                <span class="badge">5</span>
            </a>

            <div class="nav-label" style="margin-top:16px;">Management</div>

            <a href="#" class="nav-item">
                <i class="fas fa-calendar-check"></i>
                <span>Appointments</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-boxes"></i>
                <span>Inventory</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Reports</span>
            </a>

            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </div>

        <!-- Footer -->
        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">JD</div>
                <div class="user-info">
                    <div class="user-name">John Doe</div>
                    <div class="user-role">Administrator</div>
                </div>
                <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- ===== Main Content ===== -->
    <div class="main-content" id="mainContent">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="page-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-subtitle', 'Welcome back, John! Here\'s what\'s happening with your workshop today.')</p>
                </div>
            </div>
            <div class="header-right">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search..." aria-label="Search">
                </div>
                <button class="icon-btn" aria-label="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-dot"></span>
                </button>
                <button class="icon-btn" aria-label="Help">
                    <i class="fas fa-question-circle"></i>
                </button>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <!-- ===== Scripts ===== -->
    <script>
        // Hide loader when page is ready
        document.addEventListener('DOMContentLoaded', function() {
            const loader = document.getElementById('app-loader');
            if (loader) {
                setTimeout(function() {
                    loader.classList.add('hidden');
                }, 500);
            }
        });

        // Sidebar Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        // Close sidebar on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        });

        // Close sidebar on window resize (if open and screen becomes large)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992 && sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        });

        // Chart default configuration
        if (typeof Chart !== 'undefined') {
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#8A9BAE';
        }
    </script>

    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
