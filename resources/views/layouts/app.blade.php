<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Ghana Payroll' }}</title>
    <style>
        :root { --ink:#172033; --muted:#667085; --line:#d9e0ea; --brand:#0b5d51; --brand2:#f2b705; --soft:#f6f8fb; --danger:#b42318; }
        * { box-sizing:border-box; }
        body { margin:0; font-family:Arial, Helvetica, sans-serif; color:var(--ink); background:#eef3f7; }
        a { color:inherit; text-decoration:none; }
        .shell { display:grid; grid-template-columns:240px 1fr; min-height:100vh; }
        .side { background:#0d2f3b; color:white; padding:24px 18px; }
        .brand { font-size:20px; font-weight:800; margin-bottom:26px; }
        .nav { display:grid; gap:8px; }
        .nav a { padding:11px 12px; border-radius:7px; color:#d6e6eb; }
        .nav a:hover, .nav a.active { background:#154756; color:white; }
        .main { padding:28px; }
        .topbar { display:flex; justify-content:space-between; gap:16px; align-items:center; margin-bottom:22px; }
        .account { border-top:1px solid rgba(255,255,255,.18); margin-top:22px; padding-top:18px; color:#d6e6eb; font-size:13px; }
        .logout { width:100%; text-align:left; margin-top:10px; background:transparent; color:white; border:1px solid rgba(255,255,255,.28); }
        h1 { margin:0; font-size:28px; }
        .muted { color:var(--muted); }
        .grid { display:grid; gap:16px; }
        .cols-4 { grid-template-columns:repeat(4, minmax(0, 1fr)); }
        .cols-2 { grid-template-columns:repeat(2, minmax(0, 1fr)); }
        .panel, .card { background:white; border:1px solid var(--line); border-radius:8px; padding:18px; }
        .stat { font-size:30px; font-weight:800; margin-top:8px; }
        .actions { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .btn { display:inline-flex; align-items:center; justify-content:center; min-height:40px; padding:0 14px; border:1px solid var(--line); border-radius:7px; background:white; color:var(--ink); font-weight:700; cursor:pointer; }
        .btn.primary { background:var(--brand); border-color:var(--brand); color:white; }
        .btn.warn { background:var(--danger); border-color:var(--danger); color:white; }
        table { width:100%; border-collapse:collapse; background:white; border:1px solid var(--line); border-radius:8px; overflow:hidden; }
        th, td { padding:12px; border-bottom:1px solid var(--line); text-align:left; font-size:14px; }
        th { background:#f3f6f9; color:#344054; }
        tr:last-child td { border-bottom:0; }
        label { display:block; font-size:13px; color:#344054; font-weight:700; margin-bottom:6px; }
        input, textarea, select { width:100%; border:1px solid #cbd5e1; border-radius:7px; padding:10px 11px; font:inherit; background:white; }
        textarea { min-height:96px; resize:vertical; }
        .form-grid { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:16px; }
        .full { grid-column:1 / -1; }
        .notice { background:#fff8dd; border:1px solid #f7d56f; padding:12px 14px; border-radius:7px; margin-bottom:16px; }
        .success { background:#ecfdf3; border:1px solid #abefc6; padding:12px 14px; border-radius:7px; margin-bottom:16px; }
        .errors { background:#fef3f2; border:1px solid #fecdca; color:#7a271a; padding:12px 14px; border-radius:7px; margin-bottom:16px; }
        .badge { display:inline-block; padding:4px 8px; border-radius:999px; background:#e6f4ef; color:#075a49; font-size:12px; font-weight:700; }
        .status-pill { display:inline-block; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:800; background:#eef2ff; color:#3538cd; }
        .status-paid { background:#dcfae6; color:#067647; }
        .status-partially-paid { background:#fff8db; color:#8a5a00; }
        .status-pending, .status-processing { background:#eef4ff; color:#175cd3; }
        .status-returned-to-bank, .status-cancelled { background:#fef3f2; color:#b42318; }
        .logo-preview { max-width:130px; max-height:74px; border:1px solid var(--line); border-radius:7px; padding:8px; background:white; }
        .check-option { display:block; border:1px solid var(--line); border-radius:7px; padding:12px; margin:0; background:#f8fafc; }
        .qr-img { width:118px; height:118px; border:1px solid var(--line); border-radius:7px; padding:8px; background:white; }
        .app-credit { margin-top:28px; padding-top:18px; border-top:1px solid var(--line); color:var(--muted); font-size:12px; }
        .app-credit a { color:var(--brand); font-weight:800; }
        @media (max-width:900px) { .shell { grid-template-columns:1fr; } .side { position:static; } .cols-4, .cols-2, .form-grid { grid-template-columns:1fr; } .topbar { align-items:flex-start; flex-direction:column; } }
    </style>
</head>
<body>
    <div class="shell">
        <aside class="side">
            <div class="brand">Ghana Payroll</div>
            <nav class="nav">
                <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Dashboard</a>
                @can('manage employees')
                    <a href="{{ route('employees.index') }}" @class(['active' => request()->routeIs('employees.*')])>Employees</a>
                @endcan
                @can('manage payroll')
                    <a href="{{ route('payroll-runs.index') }}" @class(['active' => request()->routeIs('payroll-runs.*')])>Payroll Runs</a>
                @endcan
                @can('view own payslips')
                    <a href="{{ route('my-payslips.index') }}" @class(['active' => request()->routeIs('my-payslips.*')])>My Payslips</a>
                @endcan
                @can('manage company settings')
                    <a href="{{ route('settings.edit') }}" @class(['active' => request()->routeIs('settings.*')])>Company Setup</a>
                @endcan
                @can('manage users')
                    <a href="{{ route('users.index') }}" @class(['active' => request()->routeIs('users.*')])>Users</a>
                @endcan
                @can('manage roles')
                    <a href="{{ route('roles.index') }}" @class(['active' => request()->routeIs('roles.*')])>Roles</a>
                @endcan
                @can('view audit logs')
                    <a href="{{ route('audit-logs.index') }}" @class(['active' => request()->routeIs('audit-logs.*')])>Audit Trail</a>
                @endcan
            </nav>
            @auth
                <div class="account">
                    <strong>{{ auth()->user()->name }}</strong><br>
                    {{ auth()->user()->roles->pluck('name')->join(', ') ?: 'No role assigned' }}
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn logout">Logout</button>
                    </form>
                </div>
            @endauth
        </aside>
        <main class="main">
            @if (session('status'))
                <div class="success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="errors">{{ $errors->first() }}</div>
            @endif
            @yield('content')
            <footer class="app-credit">
                Developed and managed by Amodon Technologies -
                <a href="https://www.amodon.net" target="_blank" rel="noopener">www.amodon.net</a>
            </footer>
        </main>
    </div>
</body>
</html>
