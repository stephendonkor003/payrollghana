@extends('layouts.app', ['title' => 'Company Setup'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Company Setup</h1>
            <p class="muted">This information appears on every generated e-payslip and PDF.</p>
        </div>
        <a class="btn subtle" href="{{ route('dashboard') }}">Back</a>
    </div>

    <form class="panel" method="post" action="{{ route('settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="form-grid">
            <div>
                <label>Company Name</label>
                <input name="name" value="{{ old('name', $company->name) }}" required>
            </div>
            <div>
                <label>Company TIN</label>
                <input name="tin" value="{{ old('tin', $company->tin) }}">
            </div>
            <div>
                <label>Phone</label>
                <input name="phone" value="{{ old('phone', $company->phone) }}">
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $company->email) }}">
            </div>
            <div>
                <label>City</label>
                <input name="city" value="{{ old('city', $company->city) }}">
            </div>
            <div>
                <label>Logo</label>
                <input type="file" name="logo" accept="image/*">
            </div>
            <div class="full">
                <label>Address</label>
                <input name="address" value="{{ old('address', $company->address) }}">
            </div>
            <div class="full">
                <label>Payslip Footer</label>
                <textarea name="payslip_footer">{{ old('payslip_footer', $company->payslip_footer) }}</textarea>
            </div>
            @if ($company->logo_path)
                <div>
                    <label>Current Logo</label>
                    <img class="logo-preview" src="{{ asset('storage/'.$company->logo_path) }}" alt="Company logo">
                </div>
            @endif
        </div>
        <div class="actions" style="margin-top:18px">
            <button class="btn primary">Save Settings</button>
            <a class="btn subtle" href="{{ route('dashboard') }}">Cancel</a>
        </div>
    </form>
@endsection
