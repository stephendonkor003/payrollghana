@extends('layouts.app', ['title' => $payrollRun->title])

@section('content')
    <div class="topbar">
        <div>
            <h1>{{ $payrollRun->title }}</h1>
            <p class="muted">{{ $payrollRun->period_start->format('F Y') }} - {{ $payrollRun->employee_count }} employees</p>
        </div>
        <div class="actions">
            <a class="btn subtle" href="{{ route('payroll-runs.index') }}">Back</a>
            <form method="post" action="{{ route('payroll-runs.destroy', $payrollRun) }}" onsubmit="return confirm('Delete this payroll run and its payslips?')">
                @csrf @method('delete')
                <button class="btn warn">Delete Run</button>
            </form>
        </div>
    </div>

    <div class="grid cols-4" style="margin-bottom:18px">
        <div class="card"><div class="muted">Gross</div><div class="stat">GHS {{ number_format((float) $payrollRun->gross_total, 2) }}</div></div>
        <div class="card"><div class="muted">Deductions</div><div class="stat">GHS {{ number_format((float) $payrollRun->deductions_total, 2) }}</div></div>
        <div class="card"><div class="muted">Net</div><div class="stat">GHS {{ number_format((float) $payrollRun->net_total, 2) }}</div></div>
        <div class="card"><div class="muted">Employer Cost</div><div class="stat">GHS {{ number_format((float) $payrollRun->employer_total_cost, 2) }}</div></div>
    </div>

    <div class="filter-row">
        <div>
            <label for="run-payslip-status-filter">Filter by payment status</label>
            <select id="run-payslip-status-filter" data-table-filter="#run-payslips-table" data-column="4">
                <option value="">All statuses</option>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Paid">Paid</option>
                <option value="Partially Paid">Partially Paid</option>
                <option value="Returned to Bank">Returned to Bank</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <div class="table-card">
    <table id="run-payslips-table" class="data-table">
        <thead><tr><th>Employee</th><th>Gross</th><th>PAYE</th><th>Net</th><th>Payment Status</th><th>Paid</th><th></th></tr></thead>
        <tbody>
            @foreach ($payrollRun->payslips as $payslip)
                <tr>
                    <td><strong>{{ $payslip->employee_name }}</strong><br><span class="muted">{{ $payslip->employee_number }} - {{ $payslip->department }}</span></td>
                    <td>GHS {{ number_format((float) $payslip->gross_pay, 2) }}</td>
                    <td>GHS {{ number_format((float) $payslip->paye, 2) }}</td>
                    <td><strong>GHS {{ number_format((float) $payslip->net_pay, 2) }}</strong></td>
                    <td><span class="status-pill status-{{ str_replace('_', '-', $payslip->payment_status) }}">{{ $payslip->payment_status_label }}</span></td>
                    <td>GHS {{ number_format((float) $payslip->paid_amount, 2) }}</td>
                    <td><a class="btn" href="{{ route('payslips.show', $payslip) }}">Payslip</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="panel" style="margin-top:18px">
        <h2>Employer Statutory Pension Summary</h2>
        <p class="muted">Employer pension is an employer obligation and is not deducted again from employee net pay.</p>
        <div class="grid cols-4">
            <div><strong>Employer 13%</strong><br>GHS {{ number_format((float) $payrollRun->employer_pension_total, 2) }}</div>
            <div><strong>Tier 1 / SSNIT 13.5%</strong><br>GHS {{ number_format((float) $payrollRun->tier_one_ssnit_total, 2) }}</div>
            <div><strong>Tier 2 5%</strong><br>GHS {{ number_format((float) $payrollRun->tier_two_pension_total, 2) }}</div>
            <div><strong>NHIA portion 2.5%</strong><br>GHS {{ number_format((float) $payrollRun->nhia_portion_total, 2) }}</div>
        </div>
    </div>
@endsection
