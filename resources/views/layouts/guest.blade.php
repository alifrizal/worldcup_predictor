<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        body {
            background: var(--navy);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* Grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(0, 255, 135, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 135, 0.03) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
            z-index: 0;
        }

        .auth-wrap {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .auth-logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-size: 28px;
            color: var(--white);
            letter-spacing: 1px;
            margin-bottom: 28px;
            text-decoration: none;
            display: inline-block;
        }

        .auth-logo span {
            color: var(--green);
        }

        .auth-card {
            background: var(--navy2);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 32px 28px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body>
    <div class="auth-wrap">
        <a href="/" class="auth-logo">⚽ Ndukun <span>PD26</span></a>
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>
</body>

</html>