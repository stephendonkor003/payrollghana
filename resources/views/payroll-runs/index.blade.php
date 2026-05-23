@extends('layouts.app', ['title' => 'Payroll Runs'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Payroll Runs</h1>
            <p class="muted">Process a month once, then review and download employee payslips.</p>
        </div>
        <div class="actions">
            <a class="btn subtle" href="{{ route('dashboard') }}">Back</a>
            <a class="btn primary" href="{{ route('payroll-runs.create') }}">Run Payroll</a>
        </div>
    </div>

    <div class="filter-row">
        <div>
            <label for="run-period-filter">Filter by period</label>
            <input id="run-period-filter" data-table-filter="#payroll-runs-table" data-column="0" placeholder="Example: May 2026">
        </div>
    </div>

    <div class="table-card">
    <table id="payroll-runs-table" class="data-table">
        <thead><tr><th>Period</th><th>Employees</th><th>Gross</th><th>Deductions</th><th>Net</th><th>Employer Cost</th><th></th></tr></thead>
        <tbody>
            @forelse ($payrollRuns as $run)
                <tr>
                    <td><strong>{{ $run->title }}</strong><br><span class="muted">{{ $run->period_start->format('M d') }} - {{ $run->period_end->format('M d, Y') }}</span></td>
                    <td>{{ $run->employee_count }}</td>
                    <td>GH¢ {{ number_format((float) $run->gross_total, 2) }}</td>
                    <td>GH¢ {{ number_format((float) $run->deductions_total, 2) }}</td>
                    <td><strong>GH¢ {{ number_format((float) $run->net_total, 2) }}</strong></td>
                    <td>GH¢ {{ number_format((float) $run->employer_total_cost, 2) }}</td>
                    <td><a class="btn" href="{{ route('payroll-runs.show', $run) }}">Open</a></td>
                </tr>
            @empty
                <tr><td colspan="7">No payroll runs yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
@endsection
