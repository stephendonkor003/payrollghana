<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - Payroll Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#14213d; --muted:#667085; --line:#d9e2ec; --brand:#0f766e; --brand-dark:#115e59; --gold:#f2b705; --soft:#f3f7fa; --red:#b42318; --shadow:0 24px 60px rgba(20,33,61,.14); }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { min-height:100vh; font-family:'Inter', Arial, sans-serif; color:var(--ink); background:var(--soft); }
        h1,h2 { font-family:'Poppins', Arial, sans-serif; letter-spacing:0; }
        a { color:inherit; text-decoration:none; }
        .flag-bar { height:5px; background:linear-gradient(90deg, #ce1126 33.3%, #fcd116 33.3% 66.6%, #006b3f 66.6%); }
        .page { min-height:calc(100vh - 5px); display:grid; place-items:center; padding:34px 18px; }
        .login-shell { width:100%; max-width:1040px; display:grid; grid-template-columns:1fr 430px; background:white; border:1px solid var(--line); border-radius:10px; overflow:hidden; box-shadow:var(--shadow); }
        .brand-panel { min-height:620px; position:relative; padding:38px; color:white; background:linear-gradient(160deg, rgba(8,47,54,.92), rgba(15,118,110,.78)), url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=1400&q=80') center / cover; display:flex; flex-direction:column; justify-content:space-between; }
        .brand { display:flex; align-items:center; gap:12px; }
        .logo { width:44px; height:44px; border-radius:8px; background:var(--gold); color:#14213d; display:grid; place-items:center; font-family:'Poppins',sans-serif; font-weight:800; }
        .brand strong { display:block; font-family:'Poppins',sans-serif; font-size:20px; }
        .brand span { color:rgba(255,255,255,.68); font-size:12px; }
        .headline h1 { font-size:43px; line-height:1.08; max-width:520px; margin-bottom:16px; }
        .headline p { color:rgba(255,255,255,.78); line-height:1.8; max-width:520px; font-size:15px; }
        .stats { display:grid; grid-template-columns:repeat(3, 1fr); gap:10px; margin-top:24px; max-width:520px; }
        .stat { border:1px solid rgba(255,255,255,.18); background:rgba(255,255,255,.09); border-radius:8px; padding:12px; }
        .stat strong { display:block; color:var(--gold); font-size:15px; margin-bottom:3px; }
        .stat span { color:rgba(255,255,255,.72); font-size:12px; }
        .form-panel { padding:46px 42px; display:flex; flex-direction:column; justify-content:center; }
        .form-panel h2 { font-size:30px; margin-bottom:6px; }
        .sub { color:var(--muted); line-height:1.6; font-size:14px; margin-bottom:26px; }
        .errors { background:#fef3f2; border:1px solid #fecdca; color:#7a271a; padding:12px 14px; border-radius:8px; margin-bottom:18px; font-size:14px; line-height:1.6; }
        label { display:block; font-size:13px; font-weight:800; color:#344054; margin-bottom:7px; }
        .field { margin-bottom:17px; }
        input[type="email"], input[type="password"] { width:100%; border:1px solid var(--line); border-radius:8px; padding:12px 13px; font:inherit; outline:none; transition:border-color .2s, box-shadow .2s; }
        input:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(15,118,110,.12); }
        .remember-row { display:flex; align-items:center; gap:9px; color:var(--muted); font-size:13px; margin:2px 0 22px; }
        .remember-row input { width:16px; height:16px; accent-color:var(--brand); }
        .submit-btn { width:100%; min-height:48px; border:0; border-radius:8px; background:var(--brand); color:white; font-family:'Poppins',sans-serif; font-weight:700; cursor:pointer; box-shadow:0 10px 22px rgba(15,118,110,.22); transition:background .2s, transform .15s; }
        .submit-btn:hover { background:var(--brand-dark); transform:translateY(-1px); }
        .meta-links { display:flex; justify-content:space-between; gap:12px; align-items:center; border-top:1px solid var(--line); margin-top:24px; padding-top:18px; font-size:13px; }
        .meta-links a { color:var(--brand); font-weight:800; }
        .credit { margin-top:24px; color:var(--muted); font-size:12px; line-height:1.7; }
        .credit a { color:var(--brand); font-weight:800; }
        @media (max-width:900px) { .login-shell { grid-template-columns:1fr; } .brand-panel { min-height:380px; } .headline h1 { font-size:34px; } .form-panel { padding:34px 24px; } }
        @media (max-width:560px) { .stats { grid-template-columns:1fr; } .brand-panel { padding:26px; } .meta-links { flex-direction:column; align-items:flex-start; } }
    </style>
</head>
<body>
    <div class="flag-bar"></div>
    <main class="page">
        <section class="login-shell">
            <div class="brand-panel">
                <div class="brand">
                    <div class="logo">PH</div>
                    <div>
                        <strong>Payroll Hub</strong>
                        <span>Ghana payroll suite</span>
                    </div>
                </div>

                <div class="headline">
                    <h1>Secure payroll work starts here.</h1>
                    <p>Process monthly payroll, manage PAYE and SSNIT records, track payment status, and issue QR verified payslips from one focused dashboard.</p>
                    <div class="stats">
                        <div class="stat"><strong>PAYE</strong><span>GRA monthly bands</span></div>
                        <div class="stat"><strong>SSNIT</strong><span>Tier contribution support</span></div>
                        <div class="stat"><strong>PDF</strong><span>Verified e-payslips</span></div>
                    </div>
                </div>

                <div class="credit">
                    Developed and managed by Amodon Technologies
                </div>
            </div>

            <div class="form-panel">
                <h2>Welcome back</h2>
                <p class="sub">Sign in with your assigned company account to continue.</p>

                @if ($errors->any())
                    <div class="errors">{{ $errors->first() }}</div>
                @endif

                <form method="post" action="{{ route('login.store') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="you@company.com">
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="Enter password">
                    </div>

                    <label class="remember-row">
                        <input type="checkbox" name="remember" value="1"> Remember this device
                    </label>

                    <button type="submit" class="submit-btn">Sign In</button>
                </form>

                <div class="meta-links">
                    <a href="{{ route('home') }}">Back to website</a>
                    <a href="https://www.amodon.net" target="_blank" rel="noopener">www.amodon.net</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
