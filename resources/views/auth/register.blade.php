<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Kompetara</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=syne:400,600,700,800&family=dm-sans:300,400,500&display=swap" rel="stylesheet" />
    <style>
        *, ::before, ::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:      #0b0f1a;
            --surface: #111827;
            --border:  #1e2d4a;
            --accent:  #3b82f6;
            --accent2: #06b6d4;
            --text:    #e2e8f0;
            --muted:   #64748b;
            --input-bg:#0f1624;
            --error:   #f87171;
        }
        html, body { height: 100%; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            display: flex; min-height: 100vh;
        }

        /* ---- right: image panel (flipped for register) ---- */
        .panel-image {
            flex: 1;
            display: none;
            position: relative;
            overflow: hidden;
            background: var(--surface);
            order: 2;
        }
        @media (min-width: 900px) { .panel-image { display: flex; } }

        .panel-image img {
            width: 100%; height: 100%;
            object-fit: cover;
            opacity: .85;
        }
        .panel-image::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(225deg,
                rgba(11,15,26,.7) 0%,
                rgba(59,130,246,.15) 50%,
                rgba(6,182,212,.1) 100%);
        }
        .panel-brand {
            position: absolute; bottom: 2.5rem; right: 2.5rem;
            z-index: 2; color: #fff; text-align: right;
        }
        .panel-brand .logo {
            display: flex; align-items: center; justify-content: flex-end; gap: .6rem;
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem; font-weight: 800;
            color: #fff; text-decoration: none;
            margin-bottom: .6rem;
        }
        .logo-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-icon svg { width: 18px; height: 18px; }
        .panel-brand p {
            color: rgba(255,255,255,.5);
            font-size: .85rem; line-height: 1.5;
            max-width: 260px; margin-left: auto;
        }

        /* ---- left: form panel ---- */
        .panel-form {
            width: 100%; max-width: 480px;
            display: flex; flex-direction: column;
            justify-content: center;
            padding: 3rem 2.5rem;
            margin: 0 auto;
            order: 1;
        }
        @media (min-width: 900px) {
            .panel-form { border-right: 1px solid var(--border); }
        }

        .mobile-logo {
            display: flex; align-items: center; gap: .6rem;
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem; font-weight: 800;
            color: #fff; text-decoration: none;
            margin-bottom: 2.5rem;
        }
        @media (min-width: 900px) { .mobile-logo { display: none; } }

        .form-header { margin-bottom: 2rem; }
        .form-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.7rem; font-weight: 800;
            color: #fff; margin-bottom: .4rem;
        }
        .form-header p { color: var(--muted); font-size: .9rem; }

        .form-group { margin-bottom: 1rem; }
        .form-group label {
            display: block;
            font-size: .82rem; font-weight: 600;
            color: var(--muted);
            letter-spacing: .03em; text-transform: uppercase;
            margin-bottom: .45rem;
        }
        .form-group input {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: .72rem 1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem; color: var(--text);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-group input::placeholder { color: var(--muted); }
        .form-group input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        }
        .error-msg {
            color: var(--error);
            font-size: .8rem;
            margin-top: .35rem;
        }

        /* two-col grid for password fields */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        @media (max-width: 500px) { .form-row { grid-template-columns: 1fr; } }

        .btn-submit {
            width: 100%;
            padding: .78rem;
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            color: #fff;
            border: none; border-radius: 10px;
            font-family: 'Syne', sans-serif;
            font-size: 1rem; font-weight: 700;
            cursor: pointer;
            transition: opacity .2s, transform .2s;
            box-shadow: 0 0 24px rgba(59,130,246,.25);
            margin-top: 1.4rem;
        }
        .btn-submit:hover { opacity: .88; transform: translateY(-1px); }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: .87rem; color: var(--muted);
        }
        .form-footer a {
            color: var(--accent);
            text-decoration: none; font-weight: 600;
        }
        .form-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    {{-- Left: Form Panel --}}
    <div class="panel-form">

        {{-- Mobile Logo --}}
        <a href="/" class="mobile-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" fill="none"><path d="M8 9L4 12L8 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 9L20 12L16 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 7L11 17" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            Kompetara
        </a>

        <div class="form-header">
            <h1>Buat Akun</h1>
            <p>Daftar dan mulai belajar programming hari ini.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       required autofocus autocomplete="name"
                       placeholder="Nama kamu">
                @if ($errors->get('name'))
                    @foreach ($errors->get('name') as $msg)
                        <div class="error-msg">{{ $msg }}</div>
                    @endforeach
                @endif
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autocomplete="username"
                       placeholder="nama@email.com">
                @if ($errors->get('email'))
                    @foreach ($errors->get('email') as $msg)
                        <div class="error-msg">{{ $msg }}</div>
                    @endforeach
                @endif
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password"
                           required autocomplete="new-password"
                           placeholder="••••••••">
                    @if ($errors->get('password'))
                        @foreach ($errors->get('password') as $msg)
                            <div class="error-msg">{{ $msg }}</div>
                        @endforeach
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi</label>
                    <input id="password_confirmation" type="password"
                           name="password_confirmation"
                           required autocomplete="new-password"
                           placeholder="••••••••">
                    @if ($errors->get('password_confirmation'))
                        @foreach ($errors->get('password_confirmation') as $msg)
                            <div class="error-msg">{{ $msg }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <button type="submit" class="btn-submit">Buat Akun</button>
        </form>

        <div class="form-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>

    {{-- Right: Image Panel --}}
    <div class="panel-image">
        {{-- Ganti src dengan path gambar logo produk kamu --}}
        <img src="{{ asset('images/logo_kompetara.png')}}" alt="Kompetara">
        <div class="panel-brand">
            <a href="/" class="logo" style="color : black">
                Kompetara
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M8 9L4 12L8 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 9L20 12L16 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 7L11 17" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
            </a>
            <p style="color : black">Platform latihan & penilaian programming untuk pemula.</p>
        </div>
    </div>

</body>
</html>