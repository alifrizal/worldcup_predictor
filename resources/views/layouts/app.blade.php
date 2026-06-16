<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#0a0f1e">
    <title>{{ config('app.name', 'Ndukun PD26') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy: #0a0f1e;
            --navy2: #111827;
            --navy3: #1a2235;
            --green: #00ff87;
            --gold: #ffd700;
            --white: #f0f4f8;
            --muted: #64748b;
            --border: #1e2d45;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--navy);
            color: var(--white);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding-bottom: 72px;
            /* space for bottom nav */
        }

        /* ── TOP HEADER (mobile) ─────────────── */
        .app-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(10, 15, 30, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-header-logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-size: 18px;
            color: var(--white);
            letter-spacing: 0.5px;
            text-decoration: none;
        }

        .app-header-logo span {
            color: var(--green);
        }

        .app-header-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--white);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .app-header-right {
            width: 80px;
            display: flex;
            justify-content: flex-end;
        }

        /* ── PAGE CONTENT ────────────────────── */
        .page-content {
            max-width: 680px;
            margin: 0 auto;
            padding: 20px 16px;
        }

        /* ── BOTTOM NAV ──────────────────────── */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(17, 24, 39, 0.97);
            backdrop-filter: blur(16px);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: stretch;
            height: 64px;
            padding-bottom: env(safe-area-inset-bottom);
        }

        .nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            text-decoration: none;
            color: var(--muted);
            transition: color 0.2s;
            position: relative;
        }

        .nav-item.active {
            color: var(--green);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20%;
            right: 20%;
            height: 2px;
            background: var(--green);
            border-radius: 0 0 4px 4px;
        }

        .nav-item svg {
            width: 22px;
            height: 22px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
    </style>
</head>

<body>

    {{-- TOP HEADER --}}
    <header class="app-header">
        <a href="{{ route('predictions.index') }}" class="app-header-logo">
            ⚽ <span>PD26</span>
        </a>
        @isset($header)
        <div class="app-header-title">{{ $header }}</div>
        @endisset
        <div class="app-header-right"></div>
    </header>

    {{-- CONTENT --}}
    <main class="page-content">
        {{ $slot }}
    </main>

    {{-- BOTTOM NAV --}}
    @auth
    <nav class="bottom-nav">
        <a href="{{ route('fixtures.index') }}"
            class="nav-item {{ request()->routeIs('fixtures.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="nav-label">Fixture</span>
        </a>

        <a href="{{ route('predictions.index') }}"
            class="nav-item {{ request()->routeIs('predictions.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="nav-label">Prediksi</span>
        </a>

        <a href="{{ route('rankings.global') }}"
            class="nav-item {{ request()->routeIs('rankings.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span class="nav-label">Ranking</span>
        </a>

        <a href="{{ route('history.index') }}"
            class="nav-item {{ request()->routeIs('history.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="nav-label">History</span>
        </a>

        @if (Auth::user()->is_admin)
            <a href="{{ route('admin.matches.index') }}"
            class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}"
            style="{{ request()->routeIs('admin.*') ? 'color:#ffd700' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="nav-label">Admin</span>
            </a>
        @else
            <a href="{{ route('profile.edit') }}"
                class="nav-item {{ request()->routeIs('profile.*') || request()->routeIs('statistics.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="nav-label">Profil</span>
            </a>
        @endif
    </nav>
    @endauth

</body>

</html>