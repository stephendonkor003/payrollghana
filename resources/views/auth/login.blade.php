<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In &mdash; Ghana Payroll</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0d1b2a;
            --muted: #5a6a7a;
            --line: #e0eaf2;
            --brand: #0b5d51;
            --brand-dark: #073f3a;
            --brand-light: #e4f4ef;
            --gold: #f2b705;
            --gold-dark: #c99300;
            --soft: #f5f9fb;
            --gh-red: #ce1126;
            --gh-green: #006b3f;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', Arial, sans-serif; color: var(--ink); min-height: 100vh; background: var(--soft); }
        h1, h2, h3 { font-family: 'Poppins', Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }

        .flag-bar { height: 5px; background: linear-gradient(90deg, var(--gh-red) 33.3%, #fcd116 33.3% 66.6%, var(--gh-green) 66.6%); }

        .page { min-height: calc(100vh - 5px); display: grid; grid-template-columns: 1fr 460px; }

        /* LEFT PANEL — brand image */
        .image-side {
            position: relative; overflow: hidden;
            background: linear-gradient(160deg, rgba(7,63,58,.92) 0%, rgba(4,22,30,.78) 100%),
                        url('https://images.unsplash.com/photo-1554224154-22dec7ec8818?auto=format&fit=crop&w=1300&q=80') center / cover;
        }
        .image-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(4,18,28,.3) 0%, rgba(4,18,28,.7) 100%);
        }
        .image-content {
            position: absolute; inset: 0; padding: 44px 48px;
            display: flex; flex-direction: column; justify-content: space-between; z-index: 2;
        }
        .image-brand { display: flex; align-items: center; gap: 10px; }
        .image-logo {
            width: 40px; height: 40px; background: var(--gold); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Poppins', sans-serif; font-weight: 900; font-size: 15px; color: #0d1b2a;
        }
        .image-brand-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 20px; color: white; }
        .image-body { color: white; }
        .image-body h2 { font-size: 42px; font-weight: 900; line-height: 1.1; margin-bottom: 16px; }
        .image-body h2 .accent { color: var(--gold); }
        .image-body p { color: rgba(255,255,255,.78); font-size: 16px; line-height: 1.75; max-width: 480px; }
        .image-badges { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 22px; }
        .image-badge {
            display: flex; align-items: center; gap: 7px; padding: 7px 14px; border-radius: 999px;
            background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
            color: rgba(255,255,255,.85); font-size: 12px; font-weight: 600; backdrop-filter: blur(8px);
        }
        .image-footer { color: rgba(255,255,255,.45); font-size: 12px; }
        .image-footer a { color: rgba(255,255,255,.6); }
        .image-footer a:hover { color: var(--gold); }

        /* RIGHT PANEL — form */
        .form-side { background: white; display: flex; align-items: center; justify-content: center; padding: 52px 44px; }
        .form-wrap { width: 100%; max-width: 360px; }
        .form-logo-row { display: flex; align-items: center; gap: 9px; margin-bottom: 36px; }
        .form-logo {
            width: 36px; height: 36px; background: var(--gold); border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Poppins', sans-serif; font-weight: 900; font-size: 13px; color: #0d1b2a;
        }
        .form-logo-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 17px; color: var(--brand); }
        .form-title { font-size: 28px; font-weight: 800; margin-bottom: 6px; color: var(--ink); }
        .form-sub { color: var(--muted); font-size: 14px; margin-bottom: 28px; line-height: 1.6; }

        .errors {
            background: #fef3f2; border: 1px solid #fecdca; color: #7a271a;
            padding: 12px 14px; border-radius: 9px; margin-bottom: 20px;
            font-size: 14px; line-height: 1.55;
        }

        label { display: block; font-size: 13px; font-weight: 700; color: #344054; margin-bottom: 7px; }
        .input-wrap { position: relative; margin-bottom: 18px; }
        .input-wrap svg { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
        input[type="email"],
        input[type="password"] {
            width: 100%; border: 1.5px solid var(--line); border-radius: 9px;
            padding: 12px 14px 12px 40px; font: inherit; font-size: 14px;
            color: var(--ink); background: white;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(11,93,81,.12);
        }
        .remember-row {
            display: flex; align-items: center; gap: 9px; margin-bottom: 22px;
            color: var(--muted); font-size: 13px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px; accent-color: var(--brand); cursor: pointer;
        }
        .submit-btn {
            width: 100%; border: 0; border-radius: 10px; min-height: 48px;
            background: var(--brand); color: white; font-family: 'Poppins', sans-serif;
            font-weight: 700; font-size: 15px; cursor: pointer;
            box-shadow: 0 4px 18px rgba(11,93,81,.28);
            transition: background .2s, transform .15s;
        }
        .submit-btn:hover { background: var(--brand-dark); transform: translateY(-1px); }
        .submit-btn:active { transform: translateY(0); }

        .divider { border: 0; border-top: 1px solid var(--line); margin: 24px 0; }

        .back-link {
            display: inline-flex; align-items: center; gap: 7px;
            color: var(--brand); font-size: 13px; font-weight: 700;
            transition: gap .2s;
        }
        .back-link:hover { gap: 10px; }

        .credit {
            margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--line);
            color: var(--muted); font-size: 11px; line-height: 1.7;
        }
        .credit a { color: var(--brand); font-weight: 700; }
        .credit a:hover { color: var(--brand-dark); }

        @media (max-width: 900px) {
            .page { grid-template-columns: 1fr; }
            .image-side { min-height: 300px; }
            .image-content { padding: 28px 24px; }
            .image-body h2 { font-size: 30px; }
            .form-side { padding: 36px 24px; }
        }
        @media (max-width: 480px) {
            .form-side { padding: 28px 18px; }
            .form-wrap { max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="flag-bar"></div>
    <main class="page">

        <!-- LEFT: brand side -->
        <section class="image-side" aria-hidden="true">
            <div class="image-overlay"></div>
            <div class="image-content">
                <div class="image-brand">
                    <div class="image-logo">GP</div>
                    <span class="image-brand-name">Ghana Payroll</span>
                </div>
                <div class="image-body">
                    <h2>Payroll made<br><span class="accent">simple for Ghana.</span></h2>
                    <p>Manage PAYE, SSNIT contributions, bank payments, and QR-verified payslips — all in one secure platform built for Ghanaian businesses.</p>
                    <div class="image-badges">
                        <span class="image-badge">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            GRA PAYE Compliant
                        </span>
                        <span class="image-badge">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            SSNIT Tiers 1, 2 &amp; 3
                        </span>
                        <span class="image-badge">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            GH&#8373; QR e-Payslips
                        </span>
                    </div>
                </div>
                <div class="image-footer">
                    Amodon Technologies &mdash; Accra, Ghana &nbsp;&middot;&nbsp;
                    <a href="https://www.amodon.net" target="_blank" rel="noopener">www.amodon.net</a>
                </div>
            </div>
        </section>

        <!-- RIGHT: form -->
        <section class="form-side">
            <div class="form-wrap">
                <div class="form-logo-row">
                    <div class="form-logo">GP</div>
                    <span class="form-logo-name">Ghana Payroll</span>
                </div>

                <h2 class="form-title">Welcome back</h2>
                <p class="form-sub">Sign in with your assigned company account to access the payroll dashboard.</p>

                @if ($errors->any())
                    <div class="errors">{{ $errors->first() }}</div>
                @endif

                <form method="post" action="{{ route('login.store') }}">
                    @csrf

                    <label for="email">Email address</label>
                    <div class="input-wrap">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="you@company.com">
                    </div>

                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;">
                    </div>

                    <label class="remember-row">
                        <input type="checkbox" name="remember" value="1"> Remember this device
                    </label>

                    <button type="submit" class="submit-btn">Sign In to Dashboard</button>
                </form>

                <hr class="divider">

                <a class="back-link" href="{{ route('home') }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to website
                </a>

                <div class="credit">
                    Developed and managed by Amodon Technologies.<br>
                    <a href="https://www.amodon.net" target="_blank" rel="noopener">www.amodon.net</a>
                </div>
            </div>
        </section>

    </main>
</body>
</html>
