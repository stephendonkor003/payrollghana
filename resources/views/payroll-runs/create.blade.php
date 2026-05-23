@extends('layouts.app', ['title' => 'Run Payroll'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Run Payroll</h1>
            <p class="muted">{{ $activeEmployees }} active employees will be included.</p>
        </div>
        <a class="btn subtle" href="{{ route('payroll-runs.index') }}">Back</a>
    </div>

    <form class="panel" method="post" action="{{ route('payroll-runs.store') }}">
        @csrf
        <div class="form-grid">
            <div><label>Title</label><input name="title" value="{{ old('title', 'Monthly Payroll') }}" required></div>
            <div><label>Pay Period</label><input type="month" name="pay_period" value="{{ old('pay_period', now()->format('Y-m')) }}" required></div>
            <div><label>Payment Date</label><input type="date" name="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}"></div>
            <div class="full"><label>Notes</label><textarea name="notes">{{ old('notes') }}</textarea></div>
        </div>
        <div class="notice" style="margin-top:18px">PAYE uses GRA monthly resident bands. Employee SSNIT is 5.5% of basic salary. Employer pension is tracked separately at 13%, with total pension split as 13.5% Tier 1/SSNIT and 5% Tier 2. Review rates before live payroll filing.</div>
        <div class="actions">
            <button class="btn primary">Process Payroll</button>
            <a class="btn subtle" href="{{ route('payroll-runs.index') }}">Cancel</a>
        </div>
    </form>
@endsection
