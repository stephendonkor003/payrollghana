<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payslip Verification &mdash; Ghana Payroll</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0d1b2a;
            --muted: #5a6a7a;
            --line: #e0eaf2;
            --brand: #0b5d51;
            --brand-dark: #073f3a;
            --brand-light: #e4f4ef;
            --gold: #f2b705;
            --soft: #f5f9fb;
            --gh-red: #ce1126;
            --gh-green: #006b3f;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', Arial, sans-serif; color: var(--ink); background: var(--soft); min-height: 100vh; }
        h1, h2, h3 { font-family: 'Poppins', Arial, sans-serif; }
        a { color: inherit; text-decoration: none; }

        .flag-bar { height: 5px; background: linear-gradient(90deg, var(--gh-red) 33.3%, #fcd116 33.3% 66.6%, var(--gh-green) 66.6%); }

        .topbar {
            background: var(--brand-dark); color: white;
            padding: 0 6vw; display: flex; align-items: center; justify-content: space-between;
            min-height: 62px; gap: 16px;
        }
        .topbar-brand { display: flex; align-items: center; gap: 9px; }
        .topbar-logo {
            width: 32px; height: 32px; background: var(--gold); border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Poppins', sans-serif; font-weight: 900; font-size: 12px; color: #0d1b2a;
        }
        .topbar-name { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 16px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }

        .btn {
            display: inline-flex; align-items: center; gap: 6px; min-height: 38px;
            padding: 0 16px; border-radius: 8px; border: 1.5px solid transparent;
            font-family: 'Inter', sans-serif; font-weight: 700; font-size: 13px; cursor: pointer;
            transition: all .2s;
        }
        .btn-outline { background: transparent; border-color: rgba(255,255,255,.3); color: white; }
        .btn-outline:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.5); }
        .btn-primary { background: var(--gold); border-color: var(--gold); color: #0d1b2a; }
        .btn-primary:hover { background: #c99300; }

        .wrap { max-width: 1060px; margin: 0 auto; padding: 36px 6vw 60px; }

        .page-header { margin-bottom: 24px; }
        .page-header h1 { font-size: 26px; font-weight: 800; margin-bottom: 4px; }
        .page-header p { color: var(--muted); font-size: 14px; }

        .notice {
            display: flex; align-items: flex-start; gap: 12px;
            background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px;
            padding: 14px 16px; margin-bottom: 20px; font-size: 14px; color: #78350f;
            line-height: 1.6;
        }
        .notice svg { flex-shrink: 0; margin-top: 1px; color: #d97706; }

        .alert {
            padding: 12px 16px; border-radius: 9px; margin-bottom: 16px;
            font-size: 14px; line-height: 1.55;
        }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-error { background: #fef3f2; border: 1px solid #fecdca; color: #7a271a; }

        .panel {
            background: white; border: 1px solid var(--line); border-radius: 14px;
            box-shadow: 0 2px 16px rgba(18,32,42,.06); overflow: hidden;
        }
        .panel-header {
            padding: 16px 22px; border-bottom: 1px solid var(--line);
            display: flex; align-items: center; gap: 10px;
            background: linear-gradient(135deg, var(--brand-dark), #0a4f44);
            color: white;
        }
        .panel-header h2 { font-size: 15px; font-weight: 700; }
        .panel-badge {
            font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 999px;
            background: rgba(242,183,5,.2); border: 1px solid rgba(242,183,5,.35); color: var(--gold);
        }
        .panel-body { padding: 22px; }

        .status-form-wrap {
            margin-top: 18px; background: white; border: 1px solid var(--line);
            border-radius: 14px; box-shadow: 0 2px 16px rgba(18,32,42,.06); overflow: hidden;
        }
        .status-form-header {
            padding: 14px 22px; border-bottom: 1px solid var(--line);
            font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 15px;
            background: var(--soft);
        }
        .status-form-body { padding: 22px; }

        label { display: block; font-size: 13px; font-weight: 700; color: #344054; margin-bottom: 6px; }
        input, textarea, select {
            width: 100%; border: 1.5px solid var(--line); border-radius: 8px;
            padding: 10px 12px; font: inherit; font-size: 14px; background: white; color: var(--ink);
            transition: border-color .2s, box-shadow .2s; outline: none;
        }
        input:focus, textarea:focus, select:focus {
            border-color: var(--brand); box-shadow: 0 0 0 3px rgba(11,93,81,.1);
        }
        textarea { min-height: 90px; resize: vertical; }
        .form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .full { grid-column: 1 / -1; }

        .footer-bar {
            background: #071b22; color: rgba(255,255,255,.45); font-size: 11px;
            padding: 16px 6vw; text-align: center; margin-top: 60px;
        }
        .footer-bar a { color: rgba(255,255,255,.6); }
        .footer-bar a:hover { color: var(--gold); }

        @media (max-width: 768px) {
            .topbar { padding: 0 18px; }
            .wrap { padding: 24px 18px 40px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="flag-bar"></div>

    <div class="topbar">
        <div class="topbar-brand">
            <div class="topbar-logo">GP</div>
            <span class="topbar-name">Ghana Payroll</span>
        </div>
        <div class="topbar-right">
            @auth
                <a class="btn btn-outline" href="{{ route('dashboard') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
            @else
                <a class="btn btn-primary" href="{{ route('login') }}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Payroll Login
                </a>
            @endauth
        </div>
    </div>

    <main class="wrap">
        <div class="page-header">
            <h1>Payslip Verification</h1>
            <p>Live payment status for {{ $payslip->employee_name }}</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="notice">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>This page is opened by scanning the QR code on the payslip. It confirms the current payment status and bank payment destination for this employee.</span>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2>Payslip Document</h2>
                <span class="panel-badge">Live Status</span>
            </div>
            <div class="panel-body">
                @include('payslips.partials.document')
            </div>
        </div>

        @auth
            @can('manage payroll')
                <div class="status-form-wrap">
                    <div class="status-form-header">Update Payment Status</div>
                    <div class="status-form-body">
                        @include('payslips.partials.payment-status-form')
                    </div>
                </div>
            @endcan
        @endauth
    </main>

    <footer class="footer-bar">
        Ghana Payroll &mdash; Developed by Amodon Technologies &nbsp;&middot;&nbsp;
        <a href="https://www.amodon.net" target="_blank" rel="noopener">www.amodon.net</a>
    </footer>
</body>
</html>
