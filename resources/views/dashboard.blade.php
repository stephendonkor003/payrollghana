@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <style>
        .dash-hero { display:grid; grid-template-columns:1.4fr .8fr; gap:18px; margin-bottom:18px; }
        .dash-welcome { background:linear-gradient(135deg, #0f2f39, #0f766e); color:white; border-radius:8px; padding:24px; min-height:190px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 18px 45px rgba(20,33,61,.14); }
        .dash-welcome h1 { font-size:30px; margin-bottom:6px; }
        .dash-welcome p { color:rgba(255,255,255,.78); max-width:680px; line-height:1.7; }
        .dash-welcome .actions { margin-top:18px; }
        .dash-welcome .btn { border-color:rgba(255,255,255,.2); }
        .dash-welcome .btn.primary { background:#f2b705; border-color:#f2b705; color:#14213d; }
        .pay-card { background:white; border:1px solid var(--line); border-radius:8px; padding:20px; box-shadow:var(--shadow); }
        .pay-card .amount { font-size:30px; font-weight:900; margin:10px 0 8px; color:#0f2f39; }
        .progress { height:9px; border-radius:999px; background:#e8eef3; overflow:hidden; margin-top:12px; }
        .progress span { display:block; height:100%; background:linear-gradient(90deg, #0f766e, #f2b705); border-radius:999px; }
        .metric-grid { display:grid; grid-template-columns:repeat(4, minmax(0, 1fr)); gap:16px; margin-bottom:18px; }
        .metric { background:white; border:1px solid var(--line); border-radius:8px; padding:18px; box-shadow:0 10px 24px rgba(20,33,61,.04); }
        .metric-top { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .metric-icon { width:38px; height:38px; border-radius:8px; display:grid; place-items:center; background:#e6fffb; color:#0f766e; font-weight:900; }
        .metric strong { display:block; font-size:28px; margin-top:10px; color:#0f2f39; }
        .dashboard-grid { display:grid; grid-template-columns:1.25fr .75fr; gap:18px; align-items:start; }
        .panel-head { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:14px; }
        .panel-head h2 { margin:0; }
        .run-list, .employee-list, .status-list { display:grid; gap:10px; }
        .run-item, .employee-item, .status-item { display:flex; align-items:center; justify-content:space-between; gap:14px; padding:12px; border:1px solid var(--line); border-radius:8px; background:#fbfdff; }
        .run-item strong, .employee-item strong { display:block; margin-bottom:3px; }
        .status-dot { width:10px; height:10px; border-radius:999px; background:#0f766e; flex-shrink:0; }
        .status-item > div:first-child { display:flex; align-items:center; gap:9px; }
        .workflow { display:grid; gap:10px; counter-reset:steps; }
        .workflow-item { position:relative; padding:12px 12px 12px 44px; border:1px solid var(--line); border-radius:8px; background:white; }
        .workflow-item::before { counter-increment:steps; content:counter(steps); position:absolute; left:12px; top:12px; width:22px; height:22px; border-radius:999px; display:grid; place-items:center; background:#0f766e; color:white; font-size:12px; font-weight:900; }
        .empty-state { border:1px dashed var(--line); border-radius:8px; padding:20px; color:var(--muted); background:#fbfdff; }
        @media (max-width:1080px) { .dash-hero, .dashboard-grid, .metric-grid { grid-template-columns:1fr; } }
    </style>

    @if (! $stats)
        <div class="notice">
            PostgreSQL is not migrated yet. Set your database in <strong>.env</strong>, create the database, then run <strong>php artisan migrate</strong>.
        </div>
    @else
        <section class="dash-hero">
            <div class="dash-welcome">
                <div>
                    <h1>Payroll Dashboard</h1>
                    <p>Welcome back, {{ auth()->user()->name }}. Review payroll health, employee setup, payslip payments, and month-end readiness from one place.</p>
                </div>
                <div class="actions">
                    @can('manage payroll')
                        <a class="btn primary" href="{{ route('payroll-runs.create') }}">Run Payroll</a>
                        <a class="btn" href="{{ route('payroll-runs.index') }}">View Payroll Runs</a>
                    @endcan
                    @can('manage employees')
                        <a class="btn" href="{{ route('employees.create') }}">Add Employee</a>
                    @endcan
                </div>
            </div>

            <div class="pay-card">
                <span class="muted">This Month Net Payroll</span>
                <div class="amount">GHS {{ number_format((float) $stats['monthlyPayroll'], 2) }}</div>
                <p class="muted">Last run payment completion: <strong>{{ $stats['lastRunPaidRate'] }}%</strong></p>
                <div class="progress"><span style="width:{{ $stats['lastRunPaidRate'] }}%"></span></div>
                @if ($stats['lastRun'])
                    <p class="muted" style="margin-top:12px">Latest: {{ $stats['lastRun']->title }} - {{ $stats['lastRun']->period_end->format('M Y') }}</p>
                @endif
            </div>
        </section>

        <section class="metric-grid">
            <div class="metric">
                <div class="metric-top"><span class="muted">Employees</span><span class="metric-icon">E</span></div>
                <strong>{{ $stats['employees'] }}</strong>
                <span class="muted">{{ $stats['activeEmployees'] }} active, {{ $stats['inactiveEmployees'] }} inactive</span>
            </div>
            <div class="metric">
                <div class="metric-top"><span class="muted">Active Rate</span><span class="metric-icon">%</span></div>
                <strong>{{ $stats['activeRate'] }}%</strong>
                <span class="muted">Employees ready for payroll</span>
            </div>
            <div class="metric">
                <div class="metric-top"><span class="muted">Payroll Runs</span><span class="metric-icon">P</span></div>
                <strong>{{ $stats['payrollRuns'] }}</strong>
                <span class="muted">Total processed cycles</span>
            </div>
            <div class="metric">
                <div class="metric-top"><span class="muted">Pending Payslips</span><span class="metric-icon">!</span></div>
                <strong>{{ $stats['pendingPayslips'] }}</strong>
                <span class="muted">{{ $stats['paidPayslips'] }} fully paid</span>
            </div>
        </section>

        <section class="dashboard-grid">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Recent Payroll Runs</h2>
                        <p class="muted">Latest processed payroll cycles and net totals.</p>
                    </div>
                    @can('manage payroll')
                        <a class="btn subtle" href="{{ route('payroll-runs.index') }}">Open All</a>
                    @endcan
                </div>
                <div class="run-list">
                    @forelse ($recentRuns as $run)
                        <div class="run-item">
                            <div>
                                <strong>{{ $run->title }}</strong>
                                <span class="muted">{{ $run->period_start->format('M d') }} - {{ $run->period_end->format('M d, Y') }} · {{ $run->employee_count }} employees</span>
                            </div>
                            <div class="actions">
                                <strong>GHS {{ number_format((float) $run->net_total, 2) }}</strong>
                                @can('manage payroll')
                                    <a class="btn" href="{{ route('payroll-runs.show', $run) }}">Open</a>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">No payroll runs yet. Process your first payroll cycle when employees are ready.</div>
                    @endforelse
                </div>
            </div>

            <div class="grid">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <h2>Payment Status</h2>
                            <p class="muted">Payslip distribution by status.</p>
                        </div>
                    </div>
                    <div class="status-list">
                        @foreach (\App\Models\Payslip::paymentStatuses() as $status => $label)
                            @php $count = (int) ($paymentStatusCounts[$status] ?? 0); @endphp
                            <div class="status-item">
                                <div><span class="status-dot"></span><strong>{{ $label }}</strong></div>
                                <span class="badge">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <h2>Newest Employees</h2>
                            <p class="muted">Recently added staff records.</p>
                        </div>
                    </div>
                    <div class="employee-list">
                        @forelse ($recentEmployees as $employee)
                            <div class="employee-item">
                                <div>
                                    <strong>{{ $employee->full_name }}</strong>
                                    <span class="muted">{{ $employee->job_title }} · {{ $employee->department ?: 'No department' }}</span>
                                </div>
                                <span class="badge">{{ $employee->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>
                        @empty
                            <div class="empty-state">No employees have been added yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>

        <section class="panel" style="margin-top:18px">
            <div class="panel-head">
                <div>
                    <h2>Payroll Workflow</h2>
                    <p class="muted">A clean monthly rhythm for processing Ghana payroll.</p>
                </div>
                @can('manage company settings')
                    <a class="btn subtle" href="{{ route('settings.edit') }}">Company Setup</a>
                @endcan
            </div>
            <div class="workflow">
                <div class="workflow-item"><strong>Confirm company setup</strong><br><span class="muted">Keep company TIN, logo, contact details, and payslip footer current.</span></div>
                <div class="workflow-item"><strong>Review employees</strong><br><span class="muted">Check active status, salary, bank details, TIN, and SSNIT numbers.</span></div>
                <div class="workflow-item"><strong>Run payroll</strong><br><span class="muted">Process the monthly payroll and review deductions, net pay, and employer obligations.</span></div>
                <div class="workflow-item"><strong>Track payment status</strong><br><span class="muted">Update each payslip as pending, processing, paid, partially paid, returned, or cancelled.</span></div>
            </div>
        </section>
    @endif
@endsection
