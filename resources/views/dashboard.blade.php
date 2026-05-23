@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Payroll Dashboard</h1>
            <p class="muted">Manage employees, process monthly payroll, and generate e-payslips.</p>
        </div>
        <div class="actions">
            @can('manage company settings')
                <a class="btn" href="{{ route('settings.edit') }}">Company Setup</a>
            @endcan
            @can('manage payroll')
                <a class="btn primary" href="{{ route('payroll-runs.create') }}">Run Payroll</a>
            @endcan
        </div>
    </div>

    @if (! $stats)
        <div class="notice">
            PostgreSQL is not migrated yet. Set your database in <strong>.env</strong>, create the database, then run <strong>php artisan migrate</strong>.
        </div>
    @else
        <div class="grid cols-4">
            <div class="card"><div class="muted">Employees</div><div class="stat">{{ $stats['employees'] }}</div></div>
            <div class="card"><div class="muted">Active</div><div class="stat">{{ $stats['activeEmployees'] }}</div></div>
            <div class="card"><div class="muted">Payroll Runs</div><div class="stat">{{ $stats['payrollRuns'] }}</div></div>
            <div class="card"><div class="muted">Last Net Total</div><div class="stat">GH¢ {{ number_format((float) optional($stats['lastRun'])->net_total, 2) }}</div></div>
        </div>
    @endif

    <div class="panel" style="margin-top:18px">
        <h2>Quick Start</h2>
        <p class="muted">First upload your company details and logo, add employees with salaries, then process a monthly payroll run. Each employee gets a web payslip and a PDF download.</p>
    </div>
@endsection
