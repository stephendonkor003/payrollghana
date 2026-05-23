<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family:DejaVu Sans, sans-serif; color:#172033; font-size:12px; margin:0; }
        .pdf-wrap { padding:24px; }
        .payslip-head { border-bottom:3px solid #0b5d51; padding-bottom:14px; margin-bottom:18px; }
        .company { display:table; width:100%; }
        .logo, .company-info { display:table-cell; vertical-align:middle; }
        .logo { width:120px; }
        .logo img { max-width:105px; max-height:70px; }
        .company-info h2 { margin:0; font-size:22px; color:#0b5d51; }
        .muted { color:#667085; }
        table { width:100%; border-collapse:collapse; margin-top:12px; }
        th, td { border:1px solid #d9e0ea; padding:8px; text-align:left; }
        th { background:#f3f6f9; }
        .summary td { font-size:13px; }
        .right { text-align:right; }
        .net { background:#e6f4ef; font-weight:bold; }
        .footer { position:fixed; bottom:18px; left:24px; right:24px; border-top:1px solid #d9e0ea; padding-top:8px; color:#667085; font-size:10px; }
    </style>
</head>
<body>
    <div class="pdf-wrap">
        @include('payslips.partials.document', ['pdf' => true])
    </div>
    <div class="footer">{{ $company->payslip_footer ?: 'This is a computer-generated payslip.' }}</div>
</body>
</html>
