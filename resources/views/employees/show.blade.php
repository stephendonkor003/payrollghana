@extends('layouts.app', ['title' => $employee->full_name])

@section('content')
    <div class="topbar">
        <div>
            <h1>{{ $employee->full_name }}</h1>
            <p class="muted">{{ $employee->employee_number }} · {{ $employee->job_title }} · {{ $employee->department }}</p>
        </div>
        <div class="actions">
            <a class="btn" href="{{ route('employees.edit', $employee) }}">Edit</a>
            <form method="post" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('Delete this employee?')">
                @csrf @method('delete')
                <button class="btn warn">Delete</button>
            </form>
        </div>
    </div>

    <div class="grid cols-2">
        <div class="panel">
            <h2>Pay Details</h2>
            <p>Basic salary: <strong>GH¢ {{ number_format((float) $employee->basic_salary, 2) }}</strong></p>
            <p>Allowances: <strong>GH¢ {{ number_format((float) $employee->allowances, 2) }}</strong></p>
            <p>Other deductions: <strong>GH¢ {{ number_format((float) $employee->other_deductions, 2) }}</strong></p>
        </div>
        <div class="panel">
            <h2>Statutory Details</h2>
            <p>TIN: <strong>{{ $employee->tin ?: 'N/A' }}</strong></p>
            <p>SSNIT: <strong>{{ $employee->ssnit_number ?: 'N/A' }}</strong></p>
            <p>Bank: <strong>{{ $employee->bank_name ?: 'N/A' }}</strong></p>
            <p>Branch: <strong>{{ $employee->bank_branch ?: 'N/A' }}</strong></p>
            <p>Account name: <strong>{{ $employee->bank_account_name ?: 'N/A' }}</strong></p>
            <p>Account number: <strong>{{ $employee->bank_account ?: 'N/A' }}</strong></p>
        </div>
    </div>

    <div class="panel" style="margin-top:18px">
        <h2>Payslips</h2>
        <table>
            <thead><tr><th>Period</th><th>Gross</th><th>Deductions</th><th>Net</th><th></th></tr></thead>
            <tbody>
                @forelse ($employee->payslips->sortByDesc('created_at') as $payslip)
                    <tr>
                        <td>{{ $payslip->payrollRun->period_start->format('M Y') }}</td>
                        <td>GH¢ {{ number_format((float) $payslip->gross_pay, 2) }}</td>
                        <td>GH¢ {{ number_format((float) $payslip->total_deductions, 2) }}</td>
                        <td><strong>GH¢ {{ number_format((float) $payslip->net_pay, 2) }}</strong></td>
                        <td><a class="btn" href="{{ route('payslips.show', $payslip) }}">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">No payslips yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
