<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kompetara — Platform Latihan Programming</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,600,700,800&family=dm-sans:300,400,500&display=swap" rel="stylesheet" />
    <style>
        *, ::before, ::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:       #0b0f1a;
            --surface:  #131929;
            --border:   #1e2d4a;
            --accent:   #3b82f6;
            --accent2:  #06b6d4;
            --text:     #e2e8f0;
            --muted:    #64748b;
            --card-bg:  #111827;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- background glow --- */
        .bg-glow {
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
        }
        .bg-glow::before {
            content: '';
            position: absolute;
            top: -20%; left: 50%;
            transform: translateX(-50%);
            width: 800px; height: 500px;
            background: radial-gradient(ellipse, rgba(59,130,246,.13) 0%, transparent 70%);
            border-radius: 50%;
        }
        .bg-glow::after {
            content: '';
            position: absolute;
            top: 30%; right: -10%;
            width: 400px; height: 400px;
            background: radial-gradient(ellipse, rgba(6,182,212,.07) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* --- layout --- */
        .container {
            position: relative; z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* --- nav --- */
        nav {
            position: relative; z-index: 10;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--border);
        }
        .logo {
            display: flex; align-items: center; gap: .6rem;
            font-family: 'Syne', sans-serif;
            font-size: 1.35rem; font-weight: 800;
            color: #fff; text-decoration: none;
        }
        .logo-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-icon svg { width: 18px; height: 18px; }

        .nav-links { display: flex; align-items: center; gap: .5rem; }
        .nav-links a {
            padding: .45rem .9rem;
            border-radius: 8px;
            font-size: .9rem; font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: color .2s, background .2s;
        }
        .nav-links a:hover { color: var(--text); background: var(--surface); }
        .btn-primary {
            padding: .5rem 1.1rem;
            background: var(--accent);
            color: #fff !important;
            border-radius: 8px;
            font-weight: 600 !important;
            transition: opacity .2s !important;
            background-color: unset;
            background: linear-gradient(135deg, var(--accent), var(--accent2)) !important;
        }
        .btn-primary:hover { opacity: .85; background: unset; }

        /* --- hero --- */
        .hero {
            text-align: center;
            padding: 5rem 0 4rem;
        }
        .badge {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(59,130,246,.12);
            border: 1px solid rgba(59,130,246,.3);
            color: var(--accent);
            padding: .3rem .8rem;
            border-radius: 99px;
            font-size: .78rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase;
            margin-bottom: 1.8rem;
        }
        .badge-dot {
            width: 6px; height: 6px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .3; }
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.2rem, 5vw, 3.4rem);
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            margin-bottom: 1.2rem;
        }
        h1 span {
            background: linear-gradient(90deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-desc {
            max-width: 560px; margin: 0 auto 2.5rem;
            color: var(--muted);
            font-size: 1.05rem; line-height: 1.7;
        }
        .hero-cta { display: flex; align-items: center; justify-content: center; gap: .9rem; flex-wrap: wrap; }
        .cta-main {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .75rem 1.6rem;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            border-radius: 10px;
            font-weight: 600; font-size: .95rem;
            text-decoration: none;
            transition: opacity .2s, transform .2s;
            box-shadow: 0 0 30px rgba(59,130,246,.3);
        }
        .cta-main:hover { opacity: .88; transform: translateY(-1px); }
        .cta-sec {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .75rem 1.4rem;
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 10px;
            font-weight: 500; font-size: .95rem;
            text-decoration: none;
            transition: border-color .2s, background .2s;
        }
        .cta-sec:hover { border-color: var(--accent); background: rgba(59,130,246,.06); }

        /* --- langs strip --- */
        .langs {
            display: flex; align-items: center; justify-content: center;
            gap: .6rem; flex-wrap: wrap;
            padding: 2rem 0 3.5rem;
        }
        .langs-label { color: var(--muted); font-size: .8rem; margin-right: .4rem; }
        .lang-chip {
            padding: .28rem .75rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: .8rem; font-weight: 500;
            color: var(--muted);
            background: var(--surface);
        }

        /* --- features --- */
        .section-label {
            font-family: 'Syne', sans-serif;
            font-size: 1.55rem; font-weight: 700;
            color: #fff; text-align: center;
            margin-bottom: .6rem;
        }
        .section-sub {
            color: var(--muted); text-align: center;
            font-size: .95rem; margin-bottom: 2.5rem;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.2rem;
            margin-bottom: 5rem;
        }
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.6rem;
            transition: border-color .25s, transform .25s;
        }
        .card:hover { border-color: rgba(59,130,246,.4); transform: translateY(-2px); }
        .card-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        .icon-blue  { background: rgba(59,130,246,.15); }
        .icon-cyan  { background: rgba(6,182,212,.15); }
        .icon-green { background: rgba(34,197,94,.15); }
        .card h3 {
            font-family: 'Syne', sans-serif;
            font-size: 1rem; font-weight: 700;
            color: #fff; margin-bottom: .5rem;
        }
        .card p { color: var(--muted); font-size: .88rem; line-height: 1.65; }

        /* --- steps --- */
        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 5rem;
        }
        .step { text-align: center; }
        .step-num {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 2px solid var(--accent);
            color: var(--accent);
            font-family: 'Syne', sans-serif;
            font-weight: 800; font-size: .95rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
        }
        .step h4 {
            font-family: 'Syne', sans-serif;
            font-weight: 700; color: #fff;
            margin-bottom: .4rem; font-size: .95rem;
        }
        .step p { color: var(--muted); font-size: .84rem; line-height: 1.6; }

        /* --- cta banner --- */
        .cta-banner {
            background: linear-gradient(135deg, rgba(59,130,246,.12), rgba(6,182,212,.08));
            border: 1px solid rgba(59,130,246,.25);
            border-radius: 18px;
            padding: 3rem 2rem;
            text-align: center;
            margin-bottom: 4rem;
        }
        .cta-banner h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem; font-weight: 800;
            color: #fff; margin-bottom: .7rem;
        }
        .cta-banner p { color: var(--muted); margin-bottom: 1.8rem; font-size: .95rem; }

        /* --- footer --- */
        footer {
            border-top: 1px solid var(--border);
            padding: 1.5rem 0;
            text-align: center;
            color: var(--muted);
            font-size: .8rem;
        }

        /* --- fade-in animation --- */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp .6s ease forwards;
        }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-1 { animation-delay: .1s; }
        .delay-2 { animation-delay: .2s; }
        .delay-3 { animation-delay: .3s; }
        .delay-4 { animation-delay: .4s; }
    </style>
</head>
<body>

<div class="bg-glow"></div>

<div class="container">

    {{-- Nav --}}
    <nav>
        <a href="/" class="logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 9L4 12L8 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16 9L20 12L16 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13 7L11 17" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            Kompetara
        </a>

        @if (Route::has('login'))
            <div class="nav-links">
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Mulai Gratis</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>

    {{-- Hero --}}
    <section class="hero">
        <div class="badge fade-up">
            <span class="badge-dot"></span>
            Platform Belajar Programming
        </div>
        <h1 class="fade-up delay-1">
            Ukur & Tingkatkan<br>
            <span>Kemampuan Programming</span><br>
            Kamu
        </h1>
        <p class="hero-desc fade-up delay-2">
            Kompetara hadir sebagai platform latihan dan penilaian programming untuk pemula. Mulai dari konsep dasar hingga penulisan kode nyata — belajar dengan cara yang terstruktur dan menyenangkan.
        </p>
        <div class="hero-cta fade-up delay-3">
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="cta-main">
                    Mulai Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            @endif
            <a href="#fitur" class="cta-sec">Lihat Fitur</a>
        </div>
    </section>

    {{-- Language Strip --}}
    <div class="langs fade-up delay-4">
        <span class="langs-label">Tersedia untuk:</span>
        <span class="lang-chip">Python</span>
        <span class="lang-chip">JavaScript</span>
        <span class="lang-chip">Java</span>
        <span class="lang-chip">C++</span>
        <span class="lang-chip">PHP</span>
    </div>

    {{-- Features --}}
    <div id="fitur">
        <p class="section-label">Semua yang Kamu Butuhkan</p>
        <p class="section-sub">Dirancang agar belajar programming terasa mudah dan terarah.</p>

        <div class="cards">
            <div class="card">
                <div class="card-icon icon-blue">📋</div>
                <h3>Soal Bertahap</h3>
                <p>Latihan soal yang disusun dari konsep dasar, penulisan sintaks, hingga pembuatan kode sederhana — sesuai level kamu.</p>
            </div>
            <div class="card">
                <div class="card-icon icon-cyan">📖</div>
                <h3>Materi & Contoh Kode</h3>
                <p>Pelajari materi dasar pemrograman lengkap dengan contoh kode nyata yang bisa langsung dicoba tanpa penilaian.</p>
            </div>
            <div class="card">
                <div class="card-icon icon-green">✅</div>
                <h3>Skor & Umpan Balik</h3>
                <p>Setelah mengerjakan soal, kamu akan mendapatkan skor dan feedback untuk mengetahui bagian yang masih perlu dilatih.</p>
            </div>
        </div>
    </div>

    {{-- How it works --}}
    <p class="section-label">Cara Kerja</p>
    <p class="section-sub">Tiga langkah sederhana untuk mulai belajar.</p>

    <div class="steps">
        <div class="step">
            <div class="step-num">1</div>
            <h4>Daftar & Pilih Bahasa</h4>
            <p>Buat akun gratis dan pilih bahasa pemrograman yang ingin kamu pelajari.</p>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <h4>Pelajari Materi</h4>
            <p>Baca materi, lihat contoh kode, dan coba latihan bebas tanpa tekanan penilaian.</p>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <h4>Kerjakan & Pantau</h4>
            <p>Kerjakan soal penilaian, lihat skor kamu, dan terus tingkatkan kemampuanmu.</p>
        </div>
    </div>

    {{-- CTA Banner --}}
    <div class="cta-banner">
        <h2>Siap Mulai Belajar Coding?</h2>
        <p>Bergabung dengan Kompetara dan mulai perjalanan programming kamu hari ini — gratis.</p>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="cta-main" style="display:inline-flex;">
                Daftar Sekarang — Gratis
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        @endif
    </div>

</div>

<footer>
    <div class="container">
        &copy; {{ date('Y') }} Kompetara &mdash; Platform Belajar Programming untuk Pemula
    </div>
</footer>

</body>
</html>