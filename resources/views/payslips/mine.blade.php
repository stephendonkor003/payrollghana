@extends('layouts.app', ['title' => 'My Payslips'])

@section('content')
    <div class="topbar">
        <div>
            <h1>My Payslips</h1>
            <p class="muted">Your monthly e-payslips, payment status, and PDF downloads.</p>
        </div>
    </div>

    <table>
        <thead><tr><th>Period</th><th>Gross</th><th>Deductions</th><th>Net</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse ($payslips as $payslip)
                <tr>
                    <td>{{ $payslip->payrollRun->period_start->format('F Y') }}</td>
                    <td>GHS {{ number_format((float) $payslip->gross_pay, 2) }}</td>
                    <td>GHS {{ number_format((float) $payslip->total_deductions, 2) }}</td>
                    <td><strong>GHS {{ number_format((float) $payslip->net_pay, 2) }}</strong></td>
                    <td><span class="status-pill status-{{ str_replace('_', '-', $payslip->payment_status) }}">{{ $payslip->payment_status_label }}</span></td>
                    <td>
                        <div class="actions">
                            <a class="btn" href="{{ route('my-payslips.show', $payslip) }}">View</a>
                            <a class="btn primary" href="{{ route('my-payslips.download', $payslip) }}">PDF</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No payslips have been issued to your account yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px">{{ $payslips->links() }}</div>
@endsection
