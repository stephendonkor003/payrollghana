<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll Hub — Built for Ghanaian Businesses</title>
    <meta name="description" content="Complete payroll management for Ghanaian businesses. Automatic PAYE, SSNIT, QR-verified payslips, and a full audit trail — all in one place.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0d1b2a;
            --muted: #5a6a7a;
            --brand: #0b5d51;
            --brand-dark: #073f3a;
            --brand-light: #e4f4ef;
            --gold: #f2b705;
            --gold-dark: #c99300;
            --gold-pale: #fef9e7;
            --gh-red: #ce1126;
            --gh-green: #006b3f;
            --line: #e0eaf2;
            --paper: #ffffff;
            --soft: #f5f9fb;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', Arial, sans-serif; color: var(--ink); background: var(--soft); }
        h1, h2, h3, h4 { font-family: 'Poppins', Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }

        .flag-bar { height: 5px; background: linear-gradient(90deg, var(--gh-red) 33.3%, #fcd116 33.3% 66.6%, var(--gh-green) 66.6%); }

        /* NAV */
        .site-nav {
            position: fixed; top: 5px; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px; min-height: 72px; padding: 0 6vw; color: white;
            transition: background .3s, box-shadow .3s;
        }
        .site-nav.scrolled { background: rgba(7,63,58,.97); box-shadow: 0 4px 28px rgba(0,0,0,.22); }
        .site-nav::before {
            content: ""; position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(5,20,28,.78), transparent);
            z-index: -1; transition: opacity .3s;
        }
        .site-nav.scrolled::before { opacity: 0; }
        .brand { display: flex; align-items: center; gap: 10px; }
        .brand-mark {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--gold); color: #0d1b2a;
            font-family: 'Poppins', sans-serif; font-weight: 900; font-size: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 12px rgba(242,183,5,.38); flex-shrink: 0;
        }
        .brand-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 19px; }
        .nav-links { display: flex; align-items: center; gap: 22px; font-size: 14px; font-weight: 600; }
        .nav-links a:not(.btn) { color: rgba(255,255,255,.88); transition: color .2s; }
        .nav-links a:not(.btn):hover { color: var(--gold); }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            min-height: 44px; padding: 0 20px; border-radius: 10px; border: 1.5px solid transparent;
            font-family: 'Inter', sans-serif; font-weight: 700; font-size: 14px;
            cursor: pointer; transition: all .2s;
        }
        .btn.primary { background: var(--gold); border-color: var(--gold); color: #0d1b2a; box-shadow: 0 4px 18px rgba(242,183,5,.32); }
        .btn.primary:hover { background: var(--gold-dark); border-color: var(--gold-dark); transform: translateY(-1px); }
        .btn.dark { background: var(--brand); border-color: var(--brand); color: white; }
        .btn.dark:hover { background: var(--brand-dark); transform: translateY(-1px); }
        .btn.ghost { background: rgba(255,255,255,.1); color: white; border-color: rgba(255,255,255,.28); backdrop-filter: blur(10px); }
        .btn.ghost:hover { background: rgba(255,255,255,.2); border-color: rgba(255,255,255,.45); }
        .btn.outline { background: transparent; border-color: white; color: white; }
        .btn.outline:hover { background: white; color: var(--brand); }

        /* HERO */
        .hero { position: relative; min-height: 96svh; padding: 126px 6vw 84px; color: white; display: grid; align-items: end; overflow: hidden; }
        .slide { position: absolute; inset: 0; opacity: 0; transition: opacity 1s ease; background-size: cover; background-position: center; }
        .slide.active { opacity: 1; }
        .slide::after {
            content: ""; position: absolute; inset: 0;
            background: linear-gradient(108deg, rgba(4,18,28,.94) 0%, rgba(4,18,28,.72) 45%, rgba(4,18,28,.32) 100%),
                        linear-gradient(0deg, rgba(4,18,28,.82) 0%, transparent 55%);
        }
        .hero-inner {
            position: relative; z-index: 2; max-width: 1200px;
            display: grid; grid-template-columns: 1fr 390px; gap: 42px; align-items: end;
        }

        /* Hero text transitions */
        .hero-copy { transition: opacity .45s ease, transform .45s ease; }
        .hero-copy.fading { opacity: 0; transform: translateY(14px); }

        .eyebrow {
            display: inline-flex; align-items: center; gap: 9px; min-height: 34px;
            padding: 0 14px; border-radius: 999px;
            background: rgba(242,183,5,.14); border: 1px solid rgba(242,183,5,.38);
            color: #ffd866; font-weight: 700; font-size: 13px; margin-bottom: 22px;
        }
        .eyebrow-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
        h1 { font-size: 64px; line-height: 1.06; letter-spacing: -1.5px; font-weight: 900; }
        h1 .accent { color: var(--gold); }
        .hero-copy > p { max-width: 600px; margin-top: 22px; color: rgba(255,255,255,.84); font-size: 18px; line-height: 1.78; }
        .actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-top: 30px; }
        .trust-badges { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; margin-top: 26px; }
        .badge { display: flex; align-items: center; gap: 7px; font-size: 12px; font-weight: 600; color: rgba(255,255,255,.72); }

        /* HERO PANEL */
        .hero-panel {
            border: 1px solid rgba(255,255,255,.16); border-radius: 14px;
            background: rgba(6,32,42,.8); backdrop-filter: blur(20px);
            padding: 22px; box-shadow: 0 28px 80px rgba(0,0,0,.3);
        }
        .panel-title {
            font-size: 11px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 1px; color: var(--gold); margin-bottom: 18px;
        }
        .metric { display: flex; justify-content: space-between; align-items: center; gap: 10px; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,.09); }
        .metric:last-child { border-bottom: 0; padding-bottom: 0; }
        .metric-label { color: rgba(255,255,255,.65); font-size: 13px; }
        .metric-pill {
            font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px;
            background: rgba(242,183,5,.16); color: #ffd866; border: 1px solid rgba(242,183,5,.28);
            white-space: nowrap;
        }
        .metric-pill.green { background: rgba(34,197,94,.14); color: #4ade80; border-color: rgba(34,197,94,.22); }

        .dots { position: absolute; z-index: 4; right: 6vw; bottom: 30px; display: flex; gap: 8px; }
        .dot { width: 8px; height: 8px; border-radius: 99px; border: 0; background: rgba(255,255,255,.4); cursor: pointer; transition: width .22s, background .22s; padding: 0; }
        .dot.active { width: 28px; background: var(--gold); }

        /* STATS BAR */
        .stats-bar { background: var(--brand-dark); padding: 26px 6vw; }
        .stats-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .stat { text-align: center; padding: 0 12px; }
        .stat + .stat { border-left: 1px solid rgba(255,255,255,.12); }
        .stat-num { font-family: 'Poppins', sans-serif; font-size: 30px; font-weight: 900; color: var(--gold); line-height: 1; }
        .stat-label { font-size: 11px; font-weight: 600; color: rgba(255,255,255,.6); margin-top: 5px; text-transform: uppercase; letter-spacing: .6px; }

        /* SECTIONS */
        .section { padding: 80px 6vw; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-tag { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.2px; color: var(--brand); margin-bottom: 12px; }
        .section-head { margin-bottom: 50px; }
        .section-head h2 { font-size: 38px; font-weight: 800; letter-spacing: -0.5px; line-height: 1.15; margin-bottom: 14px; }
        .section-head p { color: var(--muted); line-height: 1.78; font-size: 17px; max-width: 560px; }

        /* FEATURES */
        .features { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
        .feature {
            background: var(--paper); border: 1px solid var(--line); border-radius: 14px;
            padding: 26px; box-shadow: 0 2px 16px rgba(18,32,42,.05);
            transition: transform .2s, box-shadow .2s;
        }
        .feature:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(18,32,42,.12); }
        .feat-icon {
            width: 46px; height: 46px; border-radius: 12px; background: var(--brand-light);
            color: var(--brand); display: flex; align-items: center; justify-content: center; margin-bottom: 18px;
        }
        .feature h3 { font-size: 17px; font-weight: 700; margin-bottom: 10px; }
        .feature p { color: var(--muted); line-height: 1.65; font-size: 14px; }
        .feat-tag {
            display: inline-block; margin-top: 16px; font-size: 11px; font-weight: 700;
            padding: 3px 10px; border-radius: 999px; background: var(--brand-light);
            color: var(--brand); text-transform: uppercase; letter-spacing: .5px;
        }

        /* GHANA SECTION */
        .ghana-section { background: var(--brand-dark); color: white; padding: 90px 6vw; }
        .ghana-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
        .ghana-content .section-tag { color: var(--gold); }
        .ghana-content h2 { font-size: 38px; font-weight: 800; color: white; margin-bottom: 16px; line-height: 1.15; }
        .ghana-content > p { color: rgba(255,255,255,.76); line-height: 1.78; font-size: 16px; margin-bottom: 28px; }
        .compliance-list { list-style: none; display: flex; flex-direction: column; gap: 15px; }
        .compliance-list li { display: flex; align-items: flex-start; gap: 12px; font-size: 15px; color: rgba(255,255,255,.86); line-height: 1.55; }
        .check-circle {
            width: 22px; height: 22px; border-radius: 50%;
            background: rgba(242,183,5,.18); border: 1.5px solid rgba(242,183,5,.45);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;
        }
        .ghana-cards { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .ghana-card {
            background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.11);
            border-radius: 14px; padding: 22px; transition: background .2s;
        }
        .ghana-card:hover { background: rgba(255,255,255,.1); }
        .ghana-card-num { font-family: 'Poppins', sans-serif; font-size: 28px; font-weight: 900; color: var(--gold); line-height: 1; }
        .ghana-card-label { font-size: 13px; color: rgba(255,255,255,.6); margin-top: 6px; line-height: 1.45; }

        /* WORKFLOW */
        .workflow-section { background: white; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
        .steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; position: relative; }
        .step {
            background: var(--soft); border: 1px solid var(--line); border-radius: 14px;
            padding: 28px; position: relative;
        }
        .step-num {
            width: 34px; height: 34px; border-radius: 50%; background: var(--brand-light);
            color: var(--brand); font-family: 'Poppins', sans-serif; font-weight: 900; font-size: 15px;
            display: flex; align-items: center; justify-content: center; margin-bottom: 18px;
        }
        .step-label { font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .8px; color: var(--brand); margin-bottom: 8px; }
        .step h3 { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
        .step p { color: var(--muted); line-height: 1.65; font-size: 14px; }
        .arrow {
            position: absolute; right: -14px; top: 44px; z-index: 1;
            width: 28px; height: 28px; border-radius: 50%; background: white;
            border: 1px solid var(--line); display: flex; align-items: center; justify-content: center; color: var(--muted);
        }
        .step:last-child .arrow { display: none; }

        /* CTA */
        .cta-section { padding: 80px 6vw; }
        .cta-inner { max-width: 1200px; margin: 0 auto; }
        .cta-band {
            border-radius: 18px;
            background: linear-gradient(130deg, #052c24 0%, var(--brand-dark) 50%, #0b5d51 100%);
            color: white; padding: 58px 56px; overflow: hidden; position: relative;
            display: flex; justify-content: space-between; align-items: center; gap: 36px;
        }
        .cta-band::before {
            content: "★"; position: absolute; right: 360px; top: -30px;
            font-size: 220px; color: rgba(242,183,5,.04); line-height: 1; pointer-events: none;
        }
        .cta-band::after {
            content: ""; position: absolute; right: -50px; bottom: -70px;
            width: 300px; height: 300px; border: 1.5px solid rgba(242,183,5,.2); border-radius: 50%;
            pointer-events: none;
        }
        .cta-text h2 { font-size: 32px; font-weight: 800; margin-bottom: 12px; }
        .cta-text p { color: rgba(255,255,255,.76); line-height: 1.72; font-size: 16px; max-width: 500px; }
        .cta-btns { display: flex; gap: 12px; flex-wrap: wrap; position: relative; z-index: 2; flex-shrink: 0; }

        /* FOOTER */
        .footer { background: #071b22; color: white; padding: 40px 6vw; }
        .footer-inner { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; gap: 24px; flex-wrap: wrap; }
        .footer-brand { display: flex; align-items: center; gap: 10px; }
        .footer-logo { width: 34px; height: 34px; background: var(--gold); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; color: #0d1b2a; font-size: 13px; flex-shrink: 0; }
        .footer-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 16px; }
        .footer-sub { font-size: 12px; color: rgba(255,255,255,.48); margin-top: 2px; }
        .footer-links { display: flex; gap: 20px; align-items: center; }
        .footer-links a { color: rgba(255,255,255,.6); font-size: 13px; transition: color .2s; }
        .footer-links a:hover { color: var(--gold); }
        .footer-copy { color: rgba(255,255,255,.38); font-size: 12px; text-align: right; line-height: 1.7; }
        .footer-copy a { color: rgba(255,255,255,.6); transition: color .2s; }
        .footer-copy a:hover { color: var(--gold); }

        /* RESPONSIVE */
        @media (max-width: 1080px) {
            .hero-inner { grid-template-columns: 1fr; }
            .hero-panel { max-width: 480px; }
            h1 { font-size: 50px; }
            .features { grid-template-columns: repeat(2, 1fr); }
            .ghana-inner { grid-template-columns: 1fr; gap: 40px; }
            .ghana-cards { grid-template-columns: repeat(4, 1fr); }
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
            .cta-band { flex-direction: column; align-items: flex-start; }
        }
        @media (max-width: 768px) {
            .site-nav { min-height: 64px; padding: 0 18px; }
            .brand-name { font-size: 17px; }
            .brand-mark { width: 32px; height: 32px; }
            .nav-links a:not(.btn) { display: none; }
            .btn { min-height: 42px; padding: 0 16px; }
            .hero { min-height: 90svh; padding: 100px 18px 72px; }
            h1 { font-size: 38px; letter-spacing: -0.5px; }
            .hero-copy > p { font-size: 16px; }
            .dots { left: 18px; right: auto; bottom: 24px; }
            .section { padding: 52px 18px; }
            .section-head h2 { font-size: 28px; }
            .stats-bar { padding: 20px 18px; }
            .stats-inner { grid-template-columns: repeat(2, 1fr); gap: 8px; }
            .stat + .stat { border-left: none; }
            .features { grid-template-columns: 1fr; }
            .ghana-section { padding: 52px 18px; }
            .ghana-cards { grid-template-columns: repeat(2, 1fr); }
            .steps { grid-template-columns: 1fr; }
            .arrow { display: none; }
            .cta-section { padding: 20px 18px 52px; }
            .cta-band { padding: 30px 24px; }
            .cta-band::after { display: none; }
            .footer { padding: 30px 18px; }
            .footer-inner { flex-direction: column; align-items: flex-start; gap: 22px; }
            .footer-copy { text-align: left; }
            .footer-links { flex-wrap: wrap; gap: 14px; }
        }
        @media (max-width: 420px) {
            h1 { font-size: 32px; }
            .actions .btn { flex: 1; min-width: 0; }
            .ghana-cards { grid-template-columns: 1fr 1fr; }
            .cta-btns .btn { flex: 1; }
        }
    </style>
</head>
<body>
    <div class="flag-bar"></div>

    <header class="site-nav" id="site-nav">
        <a class="brand" href="{{ route('home') }}" aria-label="Payroll Hub home">
            <span class="brand-mark">PH</span>
            <span class="brand-name">Payroll Hub</span>
        </a>
        <nav class="nav-links" aria-label="Main navigation">
            <a href="#features">Features</a>
            <a href="#workflow">How It Works</a>
            <a href="#ghana">Compliance</a>
            <a href="{{ route('login') }}" class="btn primary">Sign In</a>
        </nav>
    </header>

    <main>
        <!-- HERO -->
        <section class="hero">
            <div class="slide active" style="background-image:url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1800&q=82')"></div>
            <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=1800&q=82')"></div>
            <div class="slide" style="background-image:url('https://images.unsplash.com/photo-1554224154-26032fced8bd?auto=format&fit=crop&w=1800&q=82')"></div>

            <div class="hero-inner">
                <div class="hero-copy" id="hero-copy">
                    <div class="eyebrow" id="hero-eyebrow">
                        <span class="eyebrow-dot"></span>
                        <span id="hero-eyebrow-text">Built for Ghanaian Businesses &nbsp;&middot;&nbsp; SSNIT &amp; PAYE Compliant</span>
                    </div>
                    <h1 id="hero-headline">Payroll made<br><span class="accent">simple for Ghana</span></h1>
                    <p id="hero-body">Run compliant monthly payroll for your team with automatic PAYE, SSNIT calculations, bank payment tracking, and QR-verified payslips &mdash; in one clean system.</p>
                    <div class="actions">
                        <a class="btn primary" href="{{ route('login') }}">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Login to Dashboard
                        </a>
                        <a class="btn ghost" href="#features">Explore Features</a>
                    </div>
                    <div class="trust-badges">
                        <span class="badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            GRA PAYE Compliant
                        </span>
                        <span class="badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            SSNIT Tiers 1, 2 &amp; 3
                        </span>
                        <span class="badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            GH&#8373; Payslips &amp; QR Verify
                        </span>
                    </div>
                </div>

                <aside class="hero-panel" aria-label="System highlights">
                    <div class="panel-title">Payroll Control Centre</div>
                    <div class="metric">
                        <span class="metric-label">PAYE (GRA bands)</span>
                        <span class="metric-pill">Auto-calculated</span>
                    </div>
                    <div class="metric">
                        <span class="metric-label">SSNIT Tiers 1, 2 &amp; 3</span>
                        <span class="metric-pill green">Built-in</span>
                    </div>
                    <div class="metric">
                        <span class="metric-label">PDF Payslips</span>
                        <span class="metric-pill">QR Verified</span>
                    </div>
                    <div class="metric">
                        <span class="metric-label">Bank Payment Status</span>
                        <span class="metric-pill green">Tracked</span>
                    </div>
                    <div class="metric">
                        <span class="metric-label">Audit Trail</span>
                        <span class="metric-pill">Full history</span>
                    </div>
                    <div class="metric">
                        <span class="metric-label">Access Roles</span>
                        <span class="metric-label" style="color:white;font-weight:600;">Admin / HR / Viewer</span>
                    </div>
                </aside>
            </div>

            <div class="dots" aria-label="Slide navigation">
                <button class="dot active" aria-label="Slide 1"></button>
                <button class="dot" aria-label="Slide 2"></button>
                <button class="dot" aria-label="Slide 3"></button>
            </div>
        </section>

        <!-- STATS BAR -->
        <div class="stats-bar">
            <div class="stats-inner">
                <div class="stat">
                    <div class="stat-num">GH&#8373;</div>
                    <div class="stat-label">Ghana Cedi Native</div>
                </div>
                <div class="stat">
                    <div class="stat-num">100%</div>
                    <div class="stat-label">GRA PAYE Compliant</div>
                </div>
                <div class="stat">
                    <div class="stat-num">QR</div>
                    <div class="stat-label">Verified e-Payslips</div>
                </div>
                <div class="stat">
                    <div class="stat-num">3</div>
                    <div class="stat-label">SSNIT Tiers Covered</div>
                </div>
            </div>
        </div>

        <!-- FEATURES -->
        <section class="section" id="features">
            <div class="section-inner">
                <div class="section-head">
                    <div class="section-tag">Core Features</div>
                    <h2>Everything your HR team needs</h2>
                    <p>A focused payroll platform built for Ghana's statutory requirements. Accurate, auditable, and straightforward for small and medium-sized Ghanaian businesses.</p>
                </div>
                <div class="features">
                    <div class="feature">
                        <div class="feat-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3>Employee Records</h3>
                        <p>Maintain job title, monthly salary, TIN, SSNIT number, bank account name, branch, and account number for every staff member.</p>
                        <span class="feat-tag">HR Management</span>
                    </div>
                    <div class="feature">
                        <div class="feat-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <h3>Ghana Deductions</h3>
                        <p>Automatic PAYE per GRA tax bands, SSNIT employee (5.5%) and employer (13%) contributions, plus Tier 2 &amp; 3 pension deductions.</p>
                        <span class="feat-tag">PAYE &amp; SSNIT</span>
                    </div>
                    <div class="feature">
                        <div class="feat-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <h3>QR-Verified Payslips</h3>
                        <p>Generate branded PDF payslips with live QR codes showing payment status — pending, paid, partial, or returned — scannable on any device.</p>
                        <span class="feat-tag">e-Payslips</span>
                    </div>
                    <div class="feature">
                        <div class="feat-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h3>Full Audit Trail</h3>
                        <p>Track every login, user change, role assignment, payslip update, and payment status change with timestamps and user attribution.</p>
                        <span class="feat-tag">Compliance Log</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- GHANA COMPLIANCE -->
        <section class="ghana-section" id="ghana">
            <div class="ghana-inner">
                <div class="ghana-content">
                    <div class="section-tag">Ghana Compliance</div>
                    <h2>Designed for Ghana's<br>statutory requirements</h2>
                    <p>Built to handle the specific tax and pension obligations Ghanaian employers must meet every month — from GRA's PAYE brackets to SSNIT's three-tier contribution structure.</p>
                    <ul class="compliance-list">
                        <li>
                            <span class="check-circle">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            <span><strong>PAYE</strong> &mdash; Ghana Revenue Authority personal income tax bands applied automatically per employee each month</span>
                        </li>
                        <li>
                            <span class="check-circle">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            <span><strong>SSNIT Tier 1</strong> &mdash; 5.5% employee and 13% employer contributions tracked and reported per pay run</span>
                        </li>
                        <li>
                            <span class="check-circle">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            <span><strong>Provident Fund (Tier 2 &amp; 3)</strong> &mdash; pension contributions structured for employer cost separation and reporting</span>
                        </li>
                        <li>
                            <span class="check-circle">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                            </span>
                            <span><strong>Bank payment records</strong> &mdash; track GH&#8373; disbursements to GCB, Ecobank, Absa, Fidelity, Stanbic, and all local banks</span>
                        </li>
                    </ul>
                </div>
                <div class="ghana-cards">
                    <div class="ghana-card">
                        <div class="ghana-card-num">GRA</div>
                        <div class="ghana-card-label">Ghana Revenue Authority PAYE tax bands</div>
                    </div>
                    <div class="ghana-card">
                        <div class="ghana-card-num">SSNIT</div>
                        <div class="ghana-card-label">All 3-tier pension contributions</div>
                    </div>
                    <div class="ghana-card">
                        <div class="ghana-card-num">GH&#8373;</div>
                        <div class="ghana-card-label">Ghana Cedi payroll processing</div>
                    </div>
                    <div class="ghana-card">
                        <div class="ghana-card-num">QR</div>
                        <div class="ghana-card-label">Verified digital payslips</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- WORKFLOW -->
        <section class="section workflow-section" id="workflow">
            <div class="section-inner">
                <div class="section-head">
                    <div class="section-tag">How It Works</div>
                    <h2>Simple monthly payroll flow</h2>
                    <p>From onboarding staff to issuing payslips — the entire process is clean, audited, and compliant with Ghanaian statutory requirements.</p>
                </div>
                <div class="steps">
                    <div class="step">
                        <div class="step-num">1</div>
                        <div class="step-label">Step One</div>
                        <h3>Set Up Employee Records</h3>
                        <p>Add staff with job titles, TIN, SSNIT number, monthly salary, allowances, and bank account details for payment disbursement.</p>
                        <span class="arrow">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    </div>
                    <div class="step">
                        <div class="step-num">2</div>
                        <div class="step-label">Step Two</div>
                        <h3>Run Monthly Payroll</h3>
                        <p>Create a payroll run for the month. The system calculates gross pay, PAYE, SSNIT deductions, net pay, and employer cost &mdash; automatically.</p>
                        <span class="arrow">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    </div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div class="step-label">Step Three</div>
                        <h3>Issue &amp; Verify Payslips</h3>
                        <p>Download branded PDF payslips and mark bank payments. Employees scan QR codes to confirm their payment status in real time &mdash; no calls needed.</p>
                        <span class="arrow"></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section">
            <div class="cta-inner">
                <div class="cta-band">
                    <div class="cta-text">
                        <h2>Ready to manage payroll the right way?</h2>
                        <p>Login to access employee records, run payroll, issue QR-verified payslips, manage user roles, and view the full audit trail &mdash; all built for Ghana.</p>
                    </div>
                    <div class="cta-btns">
                        <a class="btn primary" href="{{ route('login') }}">Open Dashboard</a>
                        <a class="btn outline" href="#features">Learn More</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-logo">PH</div>
                <div>
                    <div class="footer-name">Payroll Hub</div>
                    <div class="footer-sub">Developed by Amodon Technologies &mdash; Accra, Ghana</div>
                </div>
            </div>
            <div class="footer-links">
                <a href="#features">Features</a>
                <a href="#ghana">Compliance</a>
                <a href="#workflow">How It Works</a>
                <a href="{{ route('login') }}">Sign In</a>
            </div>
            <div class="footer-copy">
                <a href="https://www.amodon.net" target="_blank" rel="noopener">www.amodon.net</a><br>
                &copy; {{ date('Y') }} Amodon Technologies. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // Per-slide hero content: eyebrow text, headline HTML, body text
        const slides = [...document.querySelectorAll('.slide')];
        const dots   = [...document.querySelectorAll('.dot')];
        const copy   = document.getElementById('hero-copy');
        const eyebrowText = document.getElementById('hero-eyebrow-text');
        const headline    = document.getElementById('hero-headline');
        const body        = document.getElementById('hero-body');

        const content = [
            {
                eyebrow: 'Built for Ghanaian Businesses &nbsp;&middot;&nbsp; SSNIT &amp; PAYE Compliant',
                headline: 'Payroll made<br><span class="accent">simple for Ghana</span>',
                body: 'Run compliant monthly payroll for your team with automatic PAYE, SSNIT calculations, bank payment tracking, and QR-verified payslips &mdash; in one clean system.'
            },
            {
                eyebrow: 'GRA PAYE &nbsp;&middot;&nbsp; SSNIT Tiers 1, 2 &amp; 3 &nbsp;&middot;&nbsp; Bank-Ready',
                headline: 'Deductions done right,<br><span class="accent">every pay run.</span>',
                body: 'Automatic PAYE tax bands and SSNIT contributions calculated accurately every month &mdash; so your team gets paid correctly and your business stays fully compliant.'
            },
            {
                eyebrow: 'QR Payslips &nbsp;&middot;&nbsp; PDF Downloads &nbsp;&middot;&nbsp; Live Payment Status',
                headline: 'Payslips your team<br><span class="accent">can always trust.</span>',
                body: 'Generate branded PDF payslips with QR codes that show live payment status. Pending, paid, partial, or returned &mdash; clear and transparent for every employee, every month.'
            }
        ];

        let idx = 0;
        let timer;

        function showSlide(n) {
            idx = n;

            // Swap background slides
            slides.forEach((s, i) => s.classList.toggle('active', i === idx));
            dots.forEach((d, i) => d.classList.toggle('active', i === idx));

            // Fade out copy, swap text, fade back in
            copy.classList.add('fading');
            setTimeout(() => {
                const c = content[idx];
                eyebrowText.innerHTML = c.eyebrow;
                headline.innerHTML = c.headline;
                body.innerHTML = c.body;
                copy.classList.remove('fading');
            }, 450);
        }

        function next() { showSlide((idx + 1) % slides.length); }

        function startTimer() { timer = setInterval(next, 5500); }
        function resetTimer() { clearInterval(timer); startTimer(); }

        dots.forEach((d, i) => d.addEventListener('click', () => { showSlide(i); resetTimer(); }));
        startTimer();

        // Nav scroll effect
        const nav = document.getElementById('site-nav');
        window.addEventListener('scroll', () => nav.classList.toggle('scrolled', scrollY > 80), { passive: true });
    </script>
</body>
</html>
