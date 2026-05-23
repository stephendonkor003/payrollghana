@extends('layouts.app', ['title' => 'Payslip'])

@section('content')
    <div class="topbar">
        <div>
            <h1>E-Payslip</h1>
            <p class="muted">{{ $payslip->employee_name }} - {{ $payslip->payrollRun->period_start->format('F Y') }}</p>
        </div>
        <div class="actions">
            @can('manage payroll')
                <a class="btn subtle" href="{{ route('payroll-runs.show', $payslip->payrollRun) }}">Back to Run</a>
                <a class="btn primary" href="{{ route('payslips.download', $payslip) }}">Download PDF</a>
            @else
                <a class="btn subtle" href="{{ route('my-payslips.index') }}">My Payslips</a>
                <a class="btn primary" href="{{ route('my-payslips.download', $payslip) }}">Download PDF</a>
            @endcan
            <a class="btn" href="{{ $verificationUrl }}" target="_blank">Verification Page</a>
        </div>
    </div>

    <div class="panel">
        @include('payslips.partials.document')
    </div>

    @can('manage payroll')
        <div style="margin-top:18px">
            @include('payslips.partials.payment-status-form')
        </div>
    @endcan
@endsection
