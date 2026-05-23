@php
    $logo = $company->logo_path ? public_path('storage/'.$company->logo_path) : null;
    $webLogo = $company->logo_path ? asset('storage/'.$company->logo_path) : null;
    $meta = $payslip->meta ?? [];
    $statusClass = 'status-'.str_replace('_', '-', $payslip->payment_status);
@endphp

<style>
    .payslip-document { position:relative; overflow:hidden; }
    .watermark { position:absolute; left:50%; top:48%; transform:translate(-50%, -50%) rotate(-32deg); font-size:86px; font-weight:900; color:rgba(11, 93, 81, .09); letter-spacing:8px; white-space:nowrap; z-index:0; }
    .payslip-content { position:relative; z-index:1; }
    .payslip-head { border-bottom:3px solid #0b5d51; padding-bottom:14px; margin-bottom:18px; }
    .company { display:flex; justify-content:space-between; gap:20px; align-items:center; }
    .company h2 { margin:0; font-size:24px; color:#0b5d51; }
    .payslip-logo { max-width:120px; max-height:78px; border:1px solid #d9e0ea; padding:7px; border-radius:7px; }
    .doc-grid { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:14px; margin-bottom:16px; }
    .doc-box { border:1px solid #d9e0ea; border-radius:8px; padding:12px; background:rgba(255,255,255,.86); }
    .doc-box h3 { margin:0 0 8px; font-size:15px; }
    .summary-table { width:100%; border-collapse:collapse; margin-top:12px; background:rgba(255,255,255,.9); }
    .summary-table th, .summary-table td { border:1px solid #d9e0ea; padding:10px; text-align:left; }
    .summary-table th { background:#f3f6f9; }
    .right { text-align:right !important; }
    .net-row { background:#e6f4ef; font-weight:800; }
    .status-row { display:flex; justify-content:space-between; gap:16px; align-items:center; border:1px solid #d9e0ea; border-radius:8px; padding:12px; margin-bottom:16px; background:rgba(248,250,252,.92); }
    .status-pill { display:inline-block; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:800; background:#eef2ff; color:#3538cd; }
    .status-paid { background:#dcfae6; color:#067647; }
    .status-partially-paid { background:#fff8db; color:#8a5a00; }
    .status-pending, .status-processing { background:#eef4ff; color:#175cd3; }
    .status-returned-to-bank, .status-cancelled { background:#fef3f2; color:#b42318; }
    .qr-block { display:flex; gap:12px; align-items:center; }
    .qr-block img { width:112px; height:112px; border:1px solid #d9e0ea; border-radius:7px; padding:6px; background:white; }
    .small { font-size:12px; }
    .footer-note { margin-top:18px; padding-top:12px; border-top:1px solid #d9e0ea; color:#667085; }
    @media (max-width:700px) { .company, .doc-grid, .status-row, .qr-block { display:block; } .doc-box { margin-bottom:12px; } .qr-block img { margin-top:10px; } }
</style>

<div class="payslip-document">
    <div class="watermark">PAY SLIP</div>
    <div class="payslip-content">
        <div class="payslip-head">
            <div class="company">
                <div>
                    <h2>{{ $company->name }}</h2>
                    <div class="muted">{{ $company->address }} {{ $company->city ? ' - '.$company->city : '' }}</div>
                    <div class="muted">{{ $company->phone }} {{ $company->email ? ' - '.$company->email : '' }}</div>
                    @if ($company->tin)<div class="muted">TIN: {{ $company->tin }}</div>@endif
                </div>
                @if (($pdf ?? false) && $logo && file_exists($logo))
                    <img class="payslip-logo" src="{{ $logo }}" alt="Logo">
                @elseif ($webLogo)
                    <img class="payslip-logo" src="{{ $webLogo }}" alt="Logo">
                @endif
            </div>
        </div>

        <div class="status-row">
            <div>
                <strong>Payment Status</strong><br>
                <span class="status-pill {{ $statusClass }}">{{ $payslip->payment_status_label }}</span>
                <p class="muted small">Paid: GHS {{ number_format((float) $payslip->paid_amount, 2) }} - Balance: GHS {{ number_format((float) $payslip->payment_balance, 2) }}</p>
                @if ($payslip->payment_status_updated_at)
                    <p class="muted small">Updated {{ $payslip->payment_status_updated_at->format('M d, Y H:i') }} by {{ $payslip->paymentStatusUpdater?->name ?: 'System' }}</p>
                @endif
            </div>
            <div class="qr-block">
                <div class="small">
                    <strong>Scan to Verify</strong><br>
                    <span class="muted">Open the live payslip status page.</span><br>
                    <span class="muted">Ref: {{ $payslip->verification_token }}</span>
                </div>
                @if ($qrCode ?? null)
                    <img src="{{ $qrCode }}" alt="Payslip verification QR code">
                @endif
            </div>
        </div>

        <div class="doc-grid">
            <div class="doc-box">
                <h3>Employee</h3>
                <p><strong>{{ $payslip->employee_name }}</strong></p>
                <p class="muted">{{ $payslip->employee_number }} - {{ $payslip->job_title ?: 'N/A' }}</p>
                <p>Department: <strong>{{ $payslip->department ?: 'N/A' }}</strong></p>
                <p>TIN: <strong>{{ $meta['tin'] ?? 'N/A' }}</strong></p>
                <p>SSNIT: <strong>{{ $meta['ssnit_number'] ?? 'N/A' }}</strong></p>
            </div>
            <div class="doc-box">
                <h3>Payment Destination</h3>
                <p><strong>{{ $payslip->payrollRun->period_start->format('F Y') }}</strong></p>
                <p>From {{ $payslip->payrollRun->period_start->format('M d, Y') }} to {{ $payslip->payrollRun->period_end->format('M d, Y') }}</p>
                <p>Payment date: <strong>{{ optional($payslip->payrollRun->payment_date)->format('M d, Y') ?: 'N/A' }}</strong></p>
                <p>Bank: <strong>{{ $meta['bank_name'] ?? 'N/A' }}</strong></p>
                <p>Branch: <strong>{{ $meta['bank_branch'] ?? 'N/A' }}</strong></p>
                <p>Account name: <strong>{{ $meta['bank_account_name'] ?? $payslip->employee_name }}</strong></p>
                <p>Account number: <strong>{{ $meta['bank_account'] ?? 'N/A' }}</strong></p>
            </div>
        </div>

        <table class="summary-table">
            <thead><tr><th>Earnings</th><th class="right">Amount</th><th>Deductions</th><th class="right">Amount</th></tr></thead>
            <tbody>
                <tr><td>Basic Salary</td><td class="right">GHS {{ number_format((float) $payslip->basic_salary, 2) }}</td><td>SSNIT Employee 5.5%</td><td class="right">GHS {{ number_format((float) $payslip->ssnit_employee, 2) }}</td></tr>
                <tr><td>Allowances</td><td class="right">GHS {{ number_format((float) $payslip->allowances, 2) }}</td><td>PAYE</td><td class="right">GHS {{ number_format((float) $payslip->paye, 2) }}</td></tr>
                <tr><td></td><td></td><td>Other Deductions</td><td class="right">GHS {{ number_format((float) $payslip->other_deductions, 2) }}</td></tr>
                <tr><th>Gross Pay</th><th class="right">GHS {{ number_format((float) $payslip->gross_pay, 2) }}</th><th>Total Deductions</th><th class="right">GHS {{ number_format((float) $payslip->total_deductions, 2) }}</th></tr>
                <tr class="net-row"><td colspan="3">Net Pay</td><td class="right">GHS {{ number_format((float) $payslip->net_pay, 2) }}</td></tr>
            </tbody>
        </table>

        <p class="muted">Taxable income: GHS {{ number_format((float) $payslip->taxable_income, 2) }}</p>

        <table class="summary-table">
            <thead><tr><th colspan="2">Employer Statutory Pension Obligations</th></tr></thead>
            <tbody>
                <tr><td>Employer Pension Contribution 13%</td><td class="right">GHS {{ number_format((float) $payslip->employer_pension, 2) }}</td></tr>
                <tr><td>Total Tier 1 / SSNIT Remittance 13.5%</td><td class="right">GHS {{ number_format((float) $payslip->tier_one_ssnit, 2) }}</td></tr>
                <tr><td>Mandatory Tier 2 Pension 5%</td><td class="right">GHS {{ number_format((float) $payslip->tier_two_pension, 2) }}</td></tr>
                <tr><td>NHIA Portion inside Tier 1 2.5%</td><td class="right">GHS {{ number_format((float) $payslip->nhia_portion, 2) }}</td></tr>
            </tbody>
        </table>

        @if ($payslip->payment_note)
            <div class="footer-note"><strong>Payment note:</strong> {{ $payslip->payment_note }}</div>
        @endif

        @if (! ($pdf ?? false))
            <div class="footer-note">{{ $company->payslip_footer ?: 'This is a computer-generated payslip.' }}</div>
        @endif
    </div>
</div>
