<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Payroll Hub' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/2.0.3/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.min.css">
    <style>
        :root { --ink:#14213d; --muted:#667085; --line:#d9e2ec; --brand:#0f766e; --brand-dark:#115e59; --brand-soft:#e6fffb; --gold:#f2b705; --red:#b42318; --red-soft:#fef3f2; --green:#067647; --blue:#175cd3; --surface:#ffffff; --soft:#f3f7fa; --side:#0b1f27; --side-2:#0f2f39; --shadow:0 18px 45px rgba(20,33,61,.08); }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'Inter', Arial, sans-serif; color:var(--ink); background:var(--soft); min-height:100vh; }
        h1,h2,h3,h4 { font-family:'Poppins', Arial, sans-serif; letter-spacing:0; }
        a { color:inherit; text-decoration:none; }
        .flag-bar { height:4px; background:linear-gradient(90deg, #ce1126 33.3%, #fcd116 33.3% 66.6%, #006b3f 66.6%); }
        .shell { display:grid; grid-template-columns:280px 1fr; min-height:calc(100vh - 4px); }
        .side { position:sticky; top:0; height:calc(100vh - 4px); background:linear-gradient(180deg, var(--side), var(--side-2)); color:white; padding:22px 18px; display:flex; flex-direction:column; border-right:1px solid rgba(255,255,255,.08); }
        .side-brand { display:flex; align-items:center; gap:12px; padding:4px 6px 22px; border-bottom:1px solid rgba(255,255,255,.1); margin-bottom:18px; }
        .side-logo { width:42px; height:42px; background:var(--gold); border-radius:8px; display:flex; align-items:center; justify-content:center; font-family:'Poppins',sans-serif; font-weight:800; color:#14213d; box-shadow:0 10px 22px rgba(242,183,5,.22); }
        .side-name { display:block; font-family:'Poppins',sans-serif; font-weight:800; font-size:18px; line-height:1.1; }
        .side-sub { display:block; color:rgba(255,255,255,.55); font-size:12px; margin-top:3px; }
        .nav { display:flex; flex-direction:column; gap:6px; flex:1; }
        .nav a { display:flex; align-items:center; gap:10px; min-height:42px; padding:0 12px; border-radius:8px; color:rgba(255,255,255,.72); font-size:14px; font-weight:600; transition:background .15s, color .15s, transform .15s; }
        .nav a::before { content:attr(data-icon); width:20px; text-align:center; color:var(--gold); font-size:15px; }
        .nav a:hover { background:rgba(255,255,255,.08); color:white; transform:translateX(2px); }
        .nav a.active { background:rgba(15,118,110,.78); color:white; box-shadow:inset 3px 0 0 var(--gold); }
        .account { border-top:1px solid rgba(255,255,255,.12); margin-top:18px; padding-top:16px; color:rgba(255,255,255,.64); font-size:13px; }
        .account strong { color:white; display:block; margin-bottom:2px; }
        .role-tag { color:var(--gold); font-weight:700; font-size:12px; display:block; margin-bottom:12px; }
        .main-wrap { min-width:0; display:flex; flex-direction:column; }
        .main { width:100%; max-width:1440px; margin:0 auto; padding:30px 34px 0; flex:1; }
        .page-head, .topbar { display:flex; justify-content:space-between; gap:18px; align-items:flex-start; margin-bottom:20px; padding:18px 20px; background:var(--surface); border:1px solid var(--line); border-radius:8px; box-shadow:var(--shadow); }
        .page-head h1, .topbar h1 { font-size:26px; font-weight:800; margin-bottom:4px; }
        .muted { color:var(--muted); }
        .grid { display:grid; gap:16px; }
        .cols-4 { grid-template-columns:repeat(4, minmax(0, 1fr)); }
        .cols-2 { grid-template-columns:repeat(2, minmax(0, 1fr)); }
        .panel, .card { background:white; border:1px solid var(--line); border-radius:8px; padding:20px; box-shadow:0 10px 24px rgba(20,33,61,.04); }
        .panel h2 { font-size:18px; margin-bottom:8px; }
        .card { min-height:112px; }
        .stat { font-size:28px; font-weight:800; margin-top:8px; color:#0f2f39; }
        .actions { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:38px; padding:0 13px; border:1px solid var(--line); border-radius:7px; background:white; color:var(--ink); font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; font-size:13px; white-space:nowrap; transition:background .15s, border-color .15s, color .15s, transform .15s; }
        .btn:hover { border-color:#aebdcc; transform:translateY(-1px); }
        .btn.primary { background:var(--brand); border-color:var(--brand); color:white; }
        .btn.primary:hover { background:var(--brand-dark); border-color:var(--brand-dark); }
        .btn.warn { background:var(--red); border-color:var(--red); color:white; }
        .btn.subtle { background:#f8fafc; }
        .logout { width:100%; color:white; background:rgba(255,255,255,.08); border-color:rgba(255,255,255,.18); justify-content:flex-start; }
        .table-card { background:white; border:1px solid var(--line); border-radius:8px; padding:16px; box-shadow:var(--shadow); overflow:hidden; }
        table { width:100%; border-collapse:collapse; }
        th, td { padding:13px 14px; border-bottom:1px solid var(--line); text-align:left; font-size:14px; vertical-align:middle; }
        th { background:#f7fafc; color:#344054; font-weight:800; font-size:12px; text-transform:uppercase; letter-spacing:.04em; }
        tr:last-child td { border-bottom:0; }
        tbody tr:hover { background:#fbfdff; }
        .filter-row { display:grid; grid-template-columns:repeat(4, minmax(160px, 1fr)); gap:12px; margin-bottom:14px; padding:14px; background:white; border:1px solid var(--line); border-radius:8px; box-shadow:0 10px 24px rgba(20,33,61,.04); }
        .filter-row label { font-size:12px; text-transform:uppercase; letter-spacing:.05em; }
        table.dataTable { border:1px solid var(--line); border-radius:8px; overflow:hidden; }
        table.dataTable > thead > tr > th, table.dataTable > tbody > tr > td { border-bottom:1px solid var(--line); }
        table.dataTable > thead > tr > th { background:linear-gradient(135deg, #0f2f39, #0f766e); color:white; padding-top:15px; padding-bottom:15px; border-bottom:0; }
        table.dataTable > thead > tr > th:first-child { border-top-left-radius:7px; }
        table.dataTable > thead > tr > th:last-child { border-top-right-radius:7px; }
        table.dataTable thead .dt-column-order::before, table.dataTable thead .dt-column-order::after { color:rgba(255,255,255,.8) !important; opacity:.9 !important; }
        table.dataTable thead th.dt-ordering-asc, table.dataTable thead th.dt-ordering-desc { background:linear-gradient(135deg, #115e59, #0b4f49); color:white; }
        table.dataTable.fixedHeader-floating { border:1px solid var(--line); box-shadow:0 14px 30px rgba(20,33,61,.14); }
        table.dataTable.fixedHeader-floating > thead > tr > th { background:linear-gradient(135deg, #0f2f39, #0f766e); color:white; }
        table.dataTable.stripe > tbody > tr:nth-child(odd) > *, table.dataTable.display > tbody > tr:nth-child(odd) > * { box-shadow:none; background:#fff; }
        table.dataTable.hover > tbody > tr:hover > *, table.dataTable.display > tbody > tr:hover > * { box-shadow:none; background:#f5fbfa; }
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before, table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before { background:var(--brand); border:0; box-shadow:none; line-height:15px; top:50%; transform:translateY(-50%); }
        .dt-container { font-family:'Inter', Arial, sans-serif; color:var(--ink); }
        .dt-container .dt-layout-row { display:flex; align-items:center; justify-content:space-between; gap:14px; margin:0 0 14px; flex-wrap:wrap; }
        .dt-container .dt-layout-row.dt-layout-table { display:block; margin:0; overflow-x:auto; }
        .dt-container .dt-layout-row:last-child { margin:14px 0 0; padding-top:12px; border-top:1px solid var(--line); }
        .dt-container .dt-layout-cell { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
        .dt-container .dt-layout-cell.dt-layout-full { display:block; width:100%; }
        .dt-container .dt-search label, .dt-container .dt-length label { color:#344054; font-weight:800; font-size:12px; text-transform:uppercase; letter-spacing:.05em; }
        .dt-container .dt-search input, .dt-container .dt-length select { border:1px solid var(--line); border-radius:7px; padding:9px 11px; margin-left:8px; min-height:38px; background:#fff; color:var(--ink); outline:none; }
        .dt-container .dt-search input:focus, .dt-container .dt-length select:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(15,118,110,.12); }
        .dt-container .dt-info { color:var(--muted); font-size:13px; font-weight:600; }
        .dt-container .dt-paging { display:flex; gap:6px; flex-wrap:wrap; align-items:center; }
        .dt-container .dt-paging .dt-paging-button { border-radius:7px !important; border:1px solid var(--line) !important; padding:7px 11px !important; margin:0 !important; color:var(--ink) !important; background:#fff !important; font-weight:800; font-size:13px; }
        .dt-container .dt-paging .dt-paging-button:hover { border-color:var(--brand) !important; color:var(--brand) !important; background:var(--brand-soft) !important; }
        .dt-container .dt-paging .dt-paging-button.current { background:var(--brand) !important; border-color:var(--brand) !important; color:white !important; }
        .dt-container .dt-paging .dt-paging-button.disabled { opacity:.45; cursor:not-allowed !important; }
        .dt-buttons { display:flex; gap:8px; flex-wrap:wrap; }
        .dt-buttons .dt-button { border:1px solid var(--line) !important; border-radius:7px !important; background:#fff !important; color:#24364b !important; box-shadow:none !important; font-family:'Inter',sans-serif !important; font-size:12px !important; font-weight:800 !important; min-height:36px; padding:0 12px !important; transition:background .15s, border-color .15s, color .15s, transform .15s; }
        .dt-buttons .dt-button:hover { border-color:var(--brand) !important; background:var(--brand-soft) !important; color:var(--brand) !important; transform:translateY(-1px); }
        .dt-buttons .dt-button.buttons-excel { background:var(--brand) !important; border-color:var(--brand) !important; color:white !important; }
        .dt-buttons .dt-button.buttons-excel:hover { background:var(--brand-dark) !important; border-color:var(--brand-dark) !important; color:white !important; }
        .dt-button-collection { border:1px solid var(--line) !important; border-radius:8px !important; box-shadow:0 20px 45px rgba(20,33,61,.16) !important; padding:8px !important; background:white !important; }
        .dt-button-collection .dt-button { display:block !important; width:100%; text-align:left !important; margin:0 0 6px !important; border-radius:7px !important; }
        .dt-button-collection .dt-button.active { background:var(--brand-soft) !important; color:var(--brand) !important; border-color:var(--brand) !important; }
        .dt-button-background { background:rgba(15,47,57,.22) !important; }
        .dtcr-moving { outline:2px solid var(--gold); outline-offset:-2px; }
        .dt-empty { padding:30px 14px !important; text-align:center !important; color:var(--muted); font-weight:700; }
        label { display:block; font-size:13px; color:#344054; font-weight:700; margin-bottom:6px; }
        input, textarea, select { width:100%; border:1px solid var(--line); border-radius:7px; padding:10px 12px; font:inherit; font-size:14px; background:white; transition:border-color .2s, box-shadow .2s; outline:none; }
        input:focus, textarea:focus, select:focus { border-color:var(--brand); box-shadow:0 0 0 3px rgba(15,118,110,.12); }
        textarea { min-height:104px; resize:vertical; }
        .form-grid { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:16px; }
        .full { grid-column:1 / -1; }
        .notice, .success, .errors { padding:12px 14px; border-radius:8px; margin-bottom:16px; font-size:14px; line-height:1.6; }
        .notice { background:#fffbeb; border:1px solid #fde68a; color:#78350f; }
        .success { background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
        .errors { background:#fef3f2; border:1px solid #fecdca; color:#7a271a; }
        .badge, .status-pill { display:inline-flex; align-items:center; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800; background:var(--brand-soft); color:#0f766e; }
        .status-paid { background:#dcfae6; color:var(--green); }
        .status-partially-paid { background:#fff8db; color:#8a5a00; }
        .status-pending, .status-processing { background:#eef4ff; color:var(--blue); }
        .status-returned-to-bank, .status-cancelled { background:var(--red-soft); color:var(--red); }
        .logo-preview { max-width:130px; max-height:74px; border:1px solid var(--line); border-radius:7px; padding:8px; background:white; }
        .check-option { display:block; border:1px solid var(--line); border-radius:8px; padding:12px; margin:0; background:#f8fafc; }
        .qr-img { width:118px; height:118px; border:1px solid var(--line); border-radius:7px; padding:8px; background:white; }
        .app-credit { margin:32px 34px 0; padding:18px 0 22px; border-top:1px solid var(--line); color:var(--muted); font-size:12px; line-height:1.7; display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; }
        .app-credit a { color:var(--brand); font-weight:800; }
        @media (max-width:1080px) { .shell { grid-template-columns:1fr; } .side { position:relative; height:auto; } .nav { display:grid; grid-template-columns:repeat(2, minmax(0,1fr)); } .account { margin-top:14px; } .cols-4, .cols-2, .form-grid, .filter-row { grid-template-columns:1fr; } .main { padding:20px 18px 0; } .app-credit { margin-left:18px; margin-right:18px; } .page-head, .topbar { flex-direction:column; } .dt-container .dt-layout-row { align-items:stretch; } .dt-container .dt-layout-cell { width:100%; } .dt-container .dt-search, .dt-container .dt-search input, .dt-container .dt-length, .dt-container .dt-length select { width:100%; margin-left:0; } .dt-buttons, .dt-buttons .dt-button { width:100%; } }
    </style>
    @stack('styles')
</head>
<body>
    <div class="flag-bar"></div>
    <div class="shell">
        <aside class="side">
            <div class="side-brand">
                <div class="side-logo">PH</div>
                <div>
                    <span class="side-name">Payroll Hub</span>
                    <span class="side-sub">Ghana payroll suite</span>
                </div>
            </div>
            <nav class="nav">
                <a data-icon="D" href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Dashboard</a>
                @can('manage employees')
                    <a data-icon="E" href="{{ route('employees.index') }}" @class(['active' => request()->routeIs('employees.*')])>Employees</a>
                @endcan
                @can('manage payroll')
                    <a data-icon="P" href="{{ route('payroll-runs.index') }}" @class(['active' => request()->routeIs('payroll-runs.*')])>Payroll Runs</a>
                @endcan
                @can('view own payslips')
                    <a data-icon="M" href="{{ route('my-payslips.index') }}" @class(['active' => request()->routeIs('my-payslips.*')])>My Payslips</a>
                @endcan
                @can('manage company settings')
                    <a data-icon="S" href="{{ route('settings.edit') }}" @class(['active' => request()->routeIs('settings.*')])>Company Setup</a>
                @endcan
                @can('manage users')
                    <a data-icon="U" href="{{ route('users.index') }}" @class(['active' => request()->routeIs('users.*')])>Users</a>
                @endcan
                @can('manage roles')
                    <a data-icon="R" href="{{ route('roles.index') }}" @class(['active' => request()->routeIs('roles.*')])>Roles</a>
                @endcan
                @can('view audit logs')
                    <a data-icon="A" href="{{ route('audit-logs.index') }}" @class(['active' => request()->routeIs('audit-logs.*')])>Audit Trail</a>
                @endcan
            </nav>
            @auth
                <div class="account">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span class="role-tag">{{ auth()->user()->roles->pluck('name')->join(', ') ?: 'No role assigned' }}</span>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn logout">Sign Out</button>
                    </form>
                </div>
            @endauth
        </aside>
        <div class="main-wrap">
            <main class="main">
                @if (session('status'))
                    <div class="success">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="errors">{{ $errors->first() }}</div>
                @endif
                @yield('content')
            </main>
            <footer class="app-credit">
                <span>Developed and managed by <strong>Amodon Technologies</strong></span>
                <span><a href="https://www.amodon.net" target="_blank" rel="noopener">www.amodon.net</a></span>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/2.0.3/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.DataTable) return;

            document.querySelectorAll('table.data-table').forEach((table) => {
                if (table.querySelector('tbody tr td[colspan]')) return;

                table.classList.add('display', 'hover', 'stripe', 'nowrap');

                const hasButtons = Boolean(window.DataTable.Buttons);
                const actionColumn = table.querySelector('thead tr th:last-child')?.textContent.trim() === '';
                const columnDefs = [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: -1 }
                ];

                if (actionColumn) {
                    columnDefs.push({ orderable: false, searchable: false, targets: -1 });
                }

                const options = {
                    pageLength: 10,
                    lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
                    order: [],
                    stateSave: true,
                    colReorder: true,
                    fixedHeader: true,
                    responsive: {
                        details: {
                            type: 'column',
                            target: 0
                        }
                    },
                    columnDefs: columnDefs,
                    language: {
                        search: 'Search table',
                        lengthMenu: 'Show _MENU_ rows',
                        info: 'Showing _START_ to _END_ of _TOTAL_ records',
                        infoEmpty: 'No records available',
                        zeroRecords: 'No matching records found',
                        paginate: {
                            first: 'First',
                            previous: 'Prev',
                            next: 'Next',
                            last: 'Last'
                        }
                    }
                };

                if (hasButtons) {
                    options.layout = {
                        topStart: {
                            buttons: [
                                {
                                    extend: 'colvis',
                                    text: 'Columns',
                                    columns: actionColumn ? ':not(:last-child)' : undefined,
                                    collectionLayout: 'fixed two-column'
                                },
                                { extend: 'copyHtml5', text: 'Copy', exportOptions: { columns: ':not(:last-child)' } },
                                { extend: 'csvHtml5', text: 'CSV', exportOptions: { columns: ':not(:last-child)' } },
                                { extend: 'excelHtml5', text: 'Excel', exportOptions: { columns: ':not(:last-child)' } },
                                { extend: 'print', text: 'Print', exportOptions: { columns: ':not(:last-child)' } },
                                {
                                    text: 'Reset',
                                    action: function (e, dt) {
                                        dt.state.clear();
                                        window.location.reload();
                                    }
                                }
                            ]
                        },
                        topEnd: 'search',
                        bottomStart: 'pageLength',
                        bottomEnd: 'paging'
                    };
                }

                table._dataTable = new DataTable(table, options);
            });

            document.querySelectorAll('[data-table-filter]').forEach((filter) => {
                const applyFilter = () => {
                    const table = document.querySelector(filter.dataset.tableFilter);
                    if (!table || !table._dataTable) return;

                    table._dataTable
                        .column(Number(filter.dataset.column))
                        .search(filter.value)
                        .draw();
                };

                filter.addEventListener('input', applyFilter);
                filter.addEventListener('change', applyFilter);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
