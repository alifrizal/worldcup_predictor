<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ndukun Piala Dunia 2026</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700;900&family=Inter:wght@400;500;600&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--navy);
            color: var(--white);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── NAVBAR ─────────────────────────────────────── */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            background: rgba(10, 15, 30, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .nav-logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-size: 20px;
            letter-spacing: 1px;
            color: var(--white);
        }

        .nav-logo span {
            color: var(--green);
        }

        .nav-links {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-ghost {
            padding: 8px 18px;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--white);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: border-color 0.2s, background 0.2s;
        }

        .btn-ghost:hover {
            border-color: var(--green);
            background: rgba(0, 255, 135, 0.06);
        }

        .btn-primary {
            padding: 8px 20px;
            background: var(--green);
            border: 1px solid var(--green);
            border-radius: 8px;
            color: var(--navy);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: opacity 0.2s, transform 0.2s;
        }

        .btn-primary:hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }

        /* ── HERO ────────────────────────────────────────── */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 100px 24px 60px;
            position: relative;
            overflow: hidden;
        }

        /* Grid background */
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0, 255, 135, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 135, 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 80% 70% at 50% 50%, black 40%, transparent 100%);
        }

        /* Glow */
        .hero::after {
            content: '';
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(0, 255, 135, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 255, 135, 0.08);
            border: 1px solid rgba(0, 255, 135, 0.2);
            border-radius: 20px;
            padding: 6px 16px;
            font-size: 12px;
            font-weight: 600;
            color: var(--green);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 28px;
            position: relative;
            z-index: 1;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            background: var(--green);
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.4;
                transform: scale(0.7);
            }
        }

        .hero-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-size: clamp(52px, 10vw, 100px);
            line-height: 0.95;
            letter-spacing: -1px;
            text-transform: uppercase;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .hero-title .line-green {
            color: var(--green);
        }

        .hero-title .line-gold {
            color: var(--gold);
        }

        .hero-sub {
            font-size: 16px;
            color: var(--muted);
            max-width: 440px;
            line-height: 1.7;
            margin-bottom: 48px;
            position: relative;
            z-index: 1;
        }

        /* ── COUNTDOWN ───────────────────────────────────── */
        .countdown-wrap {
            position: relative;
            z-index: 1;
            margin-bottom: 48px;
        }

        .countdown-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .countdown {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cd-block {
            background: var(--navy2);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            min-width: 76px;
            text-align: center;
        }

        .cd-num {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-size: 42px;
            line-height: 1;
            color: var(--white);
            display: block;
            font-variant-numeric: tabular-nums;
        }

        .cd-num.ending {
            color: var(--green);
        }

        .cd-unit {
            font-size: 10px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 4px;
            display: block;
        }

        .cd-sep {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 32px;
            font-weight: 900;
            color: var(--border);
            padding-bottom: 16px;
        }

        .hero-cta {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn-hero-primary {
            padding: 14px 32px;
            background: var(--green);
            border-radius: 10px;
            color: var(--navy);
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            transition: transform 0.2s, opacity 0.2s;
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-hero-ghost {
            padding: 14px 32px;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--white);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: border-color 0.2s, background 0.2s;
        }

        .btn-hero-ghost:hover {
            border-color: var(--green);
            background: rgba(0, 255, 135, 0.05);
        }

        /* ── STATS BAR ───────────────────────────────────── */
        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            background: var(--navy2);
            overflow-x: auto;
        }

        .stat-item {
            flex: 1;
            min-width: 120px;
            padding: 24px 20px;
            text-align: center;
            border-right: 1px solid var(--border);
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 36px;
            font-weight: 900;
            color: var(--green);
            display: block;
            line-height: 1;
        }

        .stat-label {
            font-size: 11px;
            color: var(--muted);
            font-weight: 500;
            letter-spacing: 0.5px;
            margin-top: 4px;
            display: block;
        }

        /* ── FEATURES ────────────────────────────────────── */
        .features {
            padding: 80px 24px;
            max-width: 960px;
            margin: 0 auto;
        }

        .section-eyebrow {
            font-size: 11px;
            font-weight: 700;
            color: var(--green);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .section-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 900;
            text-transform: uppercase;
            line-height: 1.05;
            margin-bottom: 48px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
        }

        .feature-card {
            background: var(--navy2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            transition: border-color 0.2s, transform 0.2s;
        }

        .feature-card:hover {
            border-color: rgba(0, 255, 135, 0.3);
            transform: translateY(-2px);
        }

        .feature-icon {
            font-size: 28px;
            margin-bottom: 14px;
            display: block;
        }

        .feature-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ── SCORING ─────────────────────────────────────── */
        .scoring {
            padding: 0 24px 80px;
            max-width: 960px;
            margin: 0 auto;
        }

        .scoring-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .score-card {
            border-radius: 14px;
            padding: 24px 16px;
            text-align: center;
            border: 1px solid;
        }

        .score-pts {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 52px;
            font-weight: 900;
            line-height: 1;
            display: block;
            margin-bottom: 4px;
        }

        .score-type {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 10px;
        }

        .score-desc {
            font-size: 12px;
            line-height: 1.5;
            opacity: 0.7;
        }

        /* ── CTA SECTION ─────────────────────────────────── */
        .cta-section {
            margin: 0 24px 80px;
            max-width: 960px;
            margin-left: auto;
            margin-right: auto;
            background: linear-gradient(135deg, rgba(0, 255, 135, 0.08), rgba(255, 215, 0, 0.05));
            border: 1px solid rgba(0, 255, 135, 0.2);
            border-radius: 20px;
            padding: 64px 24px;
            text-align: center;
        }

        .cta-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(36px, 6vw, 60px);
            font-weight: 900;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 16px;
        }

        .cta-sub {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 32px;
        }

        /* ── FOOTER ──────────────────────────────────────── */
        footer {
            border-top: 1px solid var(--border);
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: var(--muted);
        }

        footer span {
            color: var(--green);
        }

        /* ── RESPONSIVE ──────────────────────────────────── */
        @media (max-width: 600px) {
            .scoring-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cd-block {
                min-width: 60px;
                padding: 12px 14px;
            }

            .cd-num {
                font-size: 32px;
            }

            .nav-links .btn-ghost {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav>
        <div class="nav-logo">⚽ Ndukun <span>PD26</span></div>
        <div class="nav-links">
            @auth
            <a href="{{ route('predictions.index') }}" class="btn-primary">Buka Aplikasi</a>
            @else
            <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
            <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
            @endauth
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-eyebrow">
            <span class="live-dot"></span>
            USA · Canada · Mexico 2026
        </div>

        <h1 class="hero-title">
            <span class="line-green">Tebak</span><br>
            Skor<br>
            <span class="line-gold">Piala Dunia</span>
        </h1>

        <p class="hero-sub">
            Prediksi skor setiap pertandingan, kumpulkan poin, dan buktikan siapa yang paling jago menebak.
        </p>

        <!-- COUNTDOWN -->
        <div class="countdown-wrap">
            <div class="countdown-label">Kick-off pertama</div>
            <div class="countdown" id="countdown">
                <div class="cd-block">
                    <span class="cd-num" id="cd-days">00</span>
                    <span class="cd-unit">Hari</span>
                </div>
                <div class="cd-sep">:</div>
                <div class="cd-block">
                    <span class="cd-num" id="cd-hours">00</span>
                    <span class="cd-unit">Jam</span>
                </div>
                <div class="cd-sep">:</div>
                <div class="cd-block">
                    <span class="cd-num" id="cd-mins">00</span>
                    <span class="cd-unit">Menit</span>
                </div>
                <div class="cd-sep">:</div>
                <div class="cd-block">
                    <span class="cd-num ending" id="cd-secs">00</span>
                    <span class="cd-unit">Detik</span>
                </div>
            </div>
        </div>

        <div class="hero-cta">
            @auth
            <a href="{{ route('predictions.index') }}" class="btn-hero-primary">Mulai Tebak Sekarang →</a>
            <a href="{{ route('fixtures.index') }}" class="btn-hero-ghost">Lihat Jadwal</a>
            @else
            <a href="{{ route('register') }}" class="btn-hero-primary">Daftar Sekarang →</a>
            <a href="{{ route('login') }}" class="btn-hero-ghost">Sudah punya akun?</a>
            @endauth
        </div>
    </section>

    <!-- STATS BAR -->
    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-num">48</span>
            <span class="stat-label">Tim Peserta</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">104</span>
            <span class="stat-label">Total Pertandingan</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">12</span>
            <span class="stat-label">Grup</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">3</span>
            <span class="stat-label">Pts untuk Exact</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">39</span>
            <span class="stat-label">Hari Tournament</span>
        </div>
    </div>

    <!-- FEATURES -->
    <section class="features">
        <div class="section-eyebrow">Fitur Aplikasi</div>
        <h2 class="section-title">Semua yang kamu<br>butuhkan</h2>

        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-icon">🎯</span>
                <div class="feature-title">Tebak Skor</div>
                <p class="feature-desc">Prediksi skor setiap pertandingan sebelum kick-off. Tebakan terkunci otomatis saat pertandingan dimulai.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">📅</span>
                <div class="feature-title">Fixture Lengkap</div>
                <p class="feature-desc">Jadwal lengkap dari fase grup hingga final. Filter per grup, per stage, dan per tanggal.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🏆</span>
                <div class="feature-title">Ranking</div>
                <p class="feature-desc">Bersaing di ranking global, ranking per kota, dan ranking antar supporter tim yang sama.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">📊</span>
                <div class="feature-title">Statistik</div>
                <p class="feature-desc">Lihat breakdown tebakan kamu — berapa exact, close, result, dan wrong sepanjang turnamen.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">📜</span>
                <div class="feature-title">Riwayat</div>
                <p class="feature-desc">Semua riwayat tebakan tersimpan lengkap. Filter berdasarkan hasil atau stage pertandingan.</p>
            </div>
            <div class="feature-card">
                <span class="feature-icon">🌍</span>
                <div class="feature-title">Komunitas</div>
                <p class="feature-desc">Bergabung dengan predictor dari seluruh Indonesia dan dunia. Buktikan keahlian analisismu.</p>
            </div>
        </div>
    </section>

    <!-- SCORING SYSTEM -->
    <section class="scoring">
        <div class="section-eyebrow">Sistem Poin</div>
        <h2 class="section-title">Seberapa tepat<br>tebakanmu?</h2>

        <div class="scoring-grid">
            <div class="score-card" style="background:rgba(0,255,135,0.06); border-color:rgba(0,255,135,0.3)">
                <span class="score-pts" style="color:#00ff87">3</span>
                <span class="score-type" style="color:#00ff87">Exact</span>
                <p class="score-desc">Skor tepat sama persis. Momen kebanggaan tertinggi.</p>
            </div>
            <div class="score-card" style="background:rgba(59,130,246,0.06); border-color:rgba(59,130,246,0.3)">
                <span class="score-pts" style="color:#60a5fa">1.5</span>
                <span class="score-type" style="color:#60a5fa">Close</span>
                <p class="score-desc">Hasil benar dan skor mendekati. Hampir sempurna.</p>
            </div>
            <div class="score-card" style="background:rgba(255,215,0,0.06); border-color:rgba(255,215,0,0.3)">
                <span class="score-pts" style="color:#ffd700">1</span>
                <span class="score-type" style="color:#ffd700">Result</span>
                <p class="score-desc">Menang/seri/kalah benar tapi skor tidak close.</p>
            </div>
            <div class="score-card" style="background:rgba(239,68,68,0.06); border-color:rgba(239,68,68,0.3)">
                <span class="score-pts" style="color:#f87171">0</span>
                <span class="score-type" style="color:#f87171">Wrong</span>
                <p class="score-desc">Hasil pertandingan tidak sesuai prediksi.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section style="padding: 0 24px 80px; max-width: 960px; margin: 0 auto;">
        <div class="cta-section">
            <h2 class="cta-title">Siap bersaing?<br><span style="color:var(--green)">Daftar sekarang.</span></h2>
            <p class="cta-sub">Buktikan Skillmu !</p>
            @auth
            <a href="{{ route('predictions.index') }}" class="btn-hero-primary">Buka Aplikasi →</a>
            @else
            <a href="{{ route('register') }}" class="btn-hero-primary">Mulai Sekarang →</a>
            @endauth
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>⚽ Ndukun Piala Dunia 2026 &nbsp;·&nbsp; <span>©</span> 2026 @sotobuaya</p>
    </footer>

    <!-- COUNTDOWN SCRIPT -->
    <script>
        // Target: 12 Juni 2026, 02:00 WIB (UTC+7) = 19:00 UTC, 11 Juni 2026
        const target = new Date('2026-06-11T19:00:00Z');

        function pad(n) {
            return String(n).padStart(2, '0');
        }

        function tick() {
            const now = new Date();
            const diff = target - now;

            if (diff <= 0) {
                document.getElementById('cd-days').textContent = '00';
                document.getElementById('cd-hours').textContent = '00';
                document.getElementById('cd-mins').textContent = '00';
                document.getElementById('cd-secs').textContent = '00';
                return;
            }

            const days = Math.floor(diff / 86400000);
            const hours = Math.floor((diff % 86400000) / 3600000);
            const mins = Math.floor((diff % 3600000) / 60000);
            const secs = Math.floor((diff % 60000) / 1000);

            document.getElementById('cd-days').textContent = pad(days);
            document.getElementById('cd-hours').textContent = pad(hours);
            document.getElementById('cd-mins').textContent = pad(mins);
            document.getElementById('cd-secs').textContent = pad(secs);
        }

        tick();
        setInterval(tick, 1000);
    </script>

</body>

</html>