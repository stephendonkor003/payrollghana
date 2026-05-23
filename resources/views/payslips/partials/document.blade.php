@php
    $logo = $company->logo_path ? public_path('storage/'.$company->logo_path) : null;
    $webLogo = $company->logo_path ? asset('storage/'.$company->logo_path) : null;
    $meta = $payslip->meta ?? [];
    $statusClass = 'status-'.str_replace('_', '-', $payslip->payment_status);
    $period = $payslip->payrollRun->period_start->format('F Y');
@endphp

<style>
    .payslip-document { position:relative; overflow:hidden; background:#fff; color:#172033; font-family:'Inter', DejaVu Sans, Arial, sans-serif; }
    .payslip-document * { box-sizing:border-box; }
    .payslip-watermark { position:absolute; left:50%; top:55%; transform:translate(-50%, -50%) rotate(-28deg); font-size:74px; font-weight:900; color:rgba(15,118,110,.055); letter-spacing:7px; white-space:nowrap; z-index:0; }
    .payslip-sheet { position:relative; z-index:1; border:1px solid #d9e2ec; border-radius:8px; overflow:hidden; background:#fff; }
    .payslip-band { height:8px; background:linear-gradient(90deg, #ce1126 0 33.33%, #fcd116 33.33% 66.66%, #006b3f 66.66%); }
    .payslip-header { width:100%; border-collapse:collapse; border:0; margin:0; }
    .payslip-header td { border:0; padding:22px 24px 18px; vertical-align:top; }
    .payslip-title { text-align:right; }
    .company-name { margin:0 0 6px; color:#0f766e; font-size:24px; line-height:1.15; font-weight:800; }
    .company-lines { color:#667085; font-size:12px; line-height:1.65; }
    .payslip-logo { max-width:110px; max-height:68px; border:1px solid #d9e2ec; padding:6px; border-radius:6px; margin-bottom:10px; background:#fff; }
    .doc-title { display:block; color:#172033; font-size:22px; font-weight:900; letter-spacing:.04em; }
    .doc-subtitle { color:#667085; font-size:12px; margin-top:4px; }
    .meta-strip { width:100%; border-collapse:collapse; border-left:0; border-right:0; margin:0; background:#f7fafc; border-top:1px solid #d9e2ec; border-bottom:1px solid #d9e2ec; }
    .meta-strip td { border:0; padding:12px 18px; width:25%; }
    .label { display:block; color:#667085; font-size:10px; text-transform:uppercase; letter-spacing:.08em; font-weight:800; margin-bottom:4px; }
    .value { display:block; color:#172033; font-size:13px; font-weight:800; line-height:1.35; }
    .status-pill { display:inline-block; padding:5px 10px; border-radius:999px; font-size:11px; font-weight:900; background:#eef2ff; color:#3538cd; }
    .status-paid { background:#dcfae6; color:#067647; }
    .status-partially-paid { background:#fff8db; color:#8a5a00; }
    .status-pending, .status-processing { background:#eef4ff; color:#175cd3; }
    .status-returned-to-bank, .status-cancelled { background:#fef3f2; color:#b42318; }
    .section-wrap { padding:20px 24px 22px; }
    .info-table { width:100%; border-collapse:separate; border-spacing:0 0; margin:0 0 16px; border:0; }
    .info-table td { width:50%; border:1px solid #d9e2ec; padding:14px 16px; vertical-align:top; background:#fff; }
    .info-table td:first-child { border-radius:8px 0 0 8px; border-right:0; }
    .info-table td:last-child { border-radius:0 8px 8px 0; }
    .box-title { color:#0f766e; font-size:13px; font-weight:900; text-transform:uppercase; letter-spacing:.06em; margin:0 0 10px; }
    .detail-table { width:100%; border-collapse:collapse; border:0; margin:0; }
    .detail-table td { border:0; padding:4px 0; font-size:12px; line-height:1.45; }
    .detail-table td:first-child { color:#667085; width:42%; }
    .detail-table td:last-child { color:#172033; font-weight:700; text-align:right; }
    .statement-table { width:100%; border-collapse:collapse; margin:0; border:1px solid #d9e2ec; }
    .statement-table th, .statement-table td { border:1px solid #d9e2ec; padding:10px 12px; font-size:12px; }
    .statement-table th { background:#0f2f39; color:#fff; font-size:11px; text-transform:uppercase; letter-spacing:.06em; }
    .statement-table .subhead { background:#f7fafc; color:#344054; font-weight:900; }
    .right { text-align:right !important; }
    .total-row th, .total-row td { background:#f7fafc; color:#172033; font-weight:900; }
    .net-summary { width:100%; border-collapse:collapse; margin:16px 0; border:0; }
    .net-summary td { border:0; padding:0; vertical-align:stretch; }
    .net-card { background:#0f766e; color:#fff; border-radius:8px; padding:18px 20px; }
    .net-card .label { color:rgba(255,255,255,.72); margin-bottom:8px; }
    .net-card .net-amount { display:block; font-size:28px; font-weight:900; line-height:1; }
    .payment-card { margin-left:14px; border:1px solid #d9e2ec; border-radius:8px; padding:14px 16px; background:#fbfdff; min-height:86px; }
    .payment-card p { margin:4px 0 0; color:#667085; font-size:12px; line-height:1.55; }
    .statutory-table { width:100%; border-collapse:collapse; margin:0; border:1px solid #d9e2ec; }
    .statutory-table th, .statutory-table td { border:1px solid #d9e2ec; padding:9px 12px; font-size:12px; }
    .statutory-table th { background:#f7fafc; color:#344054; text-align:left; }
    .verification-block { width:100%; border-collapse:collapse; margin-top:16px; border:1px solid #d9e2ec; border-radius:8px; overflow:hidden; }
    .verification-block td { border:0; padding:14px 16px; vertical-align:middle; background:#fbfdff; }
    .verification-block img { width:96px; height:96px; border:1px solid #d9e2ec; border-radius:6px; padding:6px; background:#fff; }
    .small-muted { color:#667085; font-size:11px; line-height:1.55; }
    .note { margin-top:14px; padding:12px 14px; border:1px solid #d9e2ec; border-radius:8px; background:#fffdf5; color:#6b4e00; font-size:12px; line-height:1.6; }
    .footer-note { margin-top:14px; color:#667085; font-size:11px; line-height:1.6; text-align:center; }
    @media (max-width:700px) {
        .payslip-header td, .meta-strip td, .info-table td, .net-summary td, .verification-block td { display:block; width:100%; text-align:left; }
        .payslip-title { text-align:left; }
        .meta-strip td { border-bottom:1px solid #d9e2ec; }
        .info-table td:first-child, .info-table td:last-child { border-radius:8px; border:1px solid #d9e2ec; margin-bottom:12px; }
        .payment-card { margin:12px 0 0; }
        .statement-table { min-width:620px; }
        .section-wrap { overflow-x:auto; padding:16px; }
    }
</style>

<div class="payslip-document">
    <div class="payslip-watermark">PAYSLIP</div>

    <div class="payslip-sheet">
        <div class="payslip-band"></div>

        <table class="payslip-header">
            <tr>
                <td>
                    <h2 class="company-name">{{ $company->name }}</h2>
                    <div class="company-lines">
                        {{ $company->address }}{{ $company->city ? ', '.$company->city : '' }}<br>
                        {{ $company->phone }}{{ $company->email ? ' | '.$company->email : '' }}<br>
                        @if ($company->tin) Company TIN: {{ $company->tin }} @endif
                    </div>
                </td>
                <td class="payslip-title">
                    @if (($pdf ?? false) && $logo && file_exists($logo))
                        <img class="payslip-logo" src="{{ $logo }}" alt="Logo"><br>
                    @elseif ($webLogo)
                        <img class="payslip-logo" src="{{ $webLogo }}" alt="Logo"><br>
                    @endif
                    <span class="doc-title">PAYSLIP</span>
                    <div class="doc-subtitle">{{ $period }} payroll statement</div>
                </td>
            </tr>
        </table>

        <table class="meta-strip">
            <tr>
                <td><span class="label">Employee No.</span><span class="value">{{ $payslip->employee_number }}</span></td>
                <td><span class="label">Pay Period</span><span class="value">{{ $payslip->payrollRun->period_start->format('M d') }} - {{ $payslip->payrollRun->period_end->format('M d, Y') }}</span></td>
                <td><span class="label">Payment Date</span><span class="value">{{ optional($payslip->payrollRun->payment_date)->format('M d, Y') ?: 'Not set' }}</span></td>
                <td><span class="label">Status</span><span class="status-pill {{ $statusClass }}">{{ $payslip->payment_status_label }}</span></td>
            </tr>
        </table>

        <div class="section-wrap">
            <table class="info-table">
                <tr>
                    <td>
                        <h3 class="box-title">Employee Information</h3>
                        <table class="detail-table">
                            <tr><td>Name</td><td>{{ $payslip->employee_name }}</td></tr>
                            <tr><td>Job Title</td><td>{{ $payslip->job_title ?: 'N/A' }}</td></tr>
                            <tr><td>Department</td><td>{{ $payslip->department ?: 'N/A' }}</td></tr>
                            <tr><td>TIN</td><td>{{ $meta['tin'] ?? 'N/A' }}</td></tr>
                            <tr><td>SSNIT</td><td>{{ $meta['ssnit_number'] ?? 'N/A' }}</td></tr>
                        </table>
                    </td>
                    <td>
                        <h3 class="box-title">Payment Destination</h3>
                        <table class="detail-table">
                            <tr><td>Bank</td><td>{{ $meta['bank_name'] ?? 'N/A' }}</td></tr>
                            <tr><td>Branch</td><td>{{ $meta['bank_branch'] ?? 'N/A' }}</td></tr>
                            <tr><td>Account Name</td><td>{{ $meta['bank_account_name'] ?? $payslip->employee_name }}</td></tr>
                            <tr><td>Account No.</td><td>{{ $meta['bank_account'] ?? 'N/A' }}</td></tr>
                            <tr><td>Payroll Run</td><td>{{ $payslip->payrollRun->title }}</td></tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="statement-table">
                <thead>
                    <tr>
                        <th colspan="2">Earnings</th>
                        <th colspan="2">Deductions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="subhead">
                        <td>Description</td>
                        <td class="right">Amount</td>
                        <td>Description</td>
                        <td class="right">Amount</td>
                    </tr>
                    <tr>
                        <td>Basic Salary</td>
                        <td class="right">GHS {{ number_format((float) $payslip->basic_salary, 2) }}</td>
                        <td>SSNIT Employee 5.5%</td>
                        <td class="right">GHS {{ number_format((float) $payslip->ssnit_employee, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Allowances</td>
                        <td class="right">GHS {{ number_format((float) $payslip->allowances, 2) }}</td>
                        <td>PAYE</td>
                        <td class="right">GHS {{ number_format((float) $payslip->paye, 2) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="right"></td>
                        <td>Other Deductions</td>
                        <td class="right">GHS {{ number_format((float) $payslip->other_deductions, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>Gross Pay</td>
                        <td class="right">GHS {{ number_format((float) $payslip->gross_pay, 2) }}</td>
                        <td>Total Deductions</td>
                        <td class="right">GHS {{ number_format((float) $payslip->total_deductions, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="net-summary">
                <tr>
                    <td style="width:48%">
                        <div class="net-card">
                            <span class="label">Net Pay</span>
                            <span class="net-amount">GHS {{ number_format((float) $payslip->net_pay, 2) }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="payment-card">
                            <span class="label">Payment Tracking</span>
                            <span class="value">Paid: GHS {{ number_format((float) $payslip->paid_amount, 2) }} | Balance: GHS {{ number_format((float) $payslip->payment_balance, 2) }}</span>
                            @if ($payslip->payment_status_updated_at)
                                <p>Updated {{ $payslip->payment_status_updated_at->format('M d, Y H:i') }} by {{ $payslip->paymentStatusUpdater?->name ?: 'System' }}</p>
                            @else
                                <p>Payment status has not been updated yet.</p>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <table class="statutory-table">
                <thead>
                    <tr>
                        <th colspan="2">Employer Statutory Pension Obligations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Employer Pension Contribution 13%</td><td class="right">GHS {{ number_format((float) $payslip->employer_pension, 2) }}</td></tr>
                    <tr><td>Total Tier 1 / SSNIT Remittance 13.5%</td><td class="right">GHS {{ number_format((float) $payslip->tier_one_ssnit, 2) }}</td></tr>
                    <tr><td>Mandatory Tier 2 Pension 5%</td><td class="right">GHS {{ number_format((float) $payslip->tier_two_pension, 2) }}</td></tr>
                    <tr><td>NHIA Portion inside Tier 1 2.5%</td><td class="right">GHS {{ number_format((float) $payslip->nhia_portion, 2) }}</td></tr>
                    <tr><td>Taxable Income</td><td class="right">GHS {{ number_format((float) $payslip->taxable_income, 2) }}</td></tr>
                </tbody>
            </table>

            <table class="verification-block">
                <tr>
                    <td>
                        <span class="label">Verification</span>
                        <span class="value">Scan the QR code or open the verification page to confirm live payment status.</span>
                        <div class="small-muted">Reference: {{ $payslip->verification_token }}</div>
                    </td>
                    @if ($qrCode ?? null)
                        <td style="width:120px; text-align:right">
                            <img src="{{ $qrCode }}" alt="Payslip verification QR code">
                        </td>
                    @endif
                </tr>
            </table>

            @if ($payslip->payment_note)
                <div class="note"><strong>Payment note:</strong> {{ $payslip->payment_note }}</div>
            @endif

            @if (! ($pdf ?? false))
                <div class="footer-note">{{ $company->payslip_footer ?: 'This is a computer-generated payslip.' }}</div>
            @endif
        </div>
    </div>
</div>
