@extends('layouts.app', ['title' => 'My Profile'])

@section('content')
    <div class="topbar">
        <div>
            <h1>My Profile</h1>
            <p class="muted">Update your account details and employee contact information.</p>
        </div>
    </div>

    <form class="panel" method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('put')

        <h2>Account</h2>
        <div class="form-grid" style="margin-top:14px">
            <div>
                <label>Name</label>
                <input name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div>
                <label>Current Password</label>
                <input type="password" name="current_password" autocomplete="current-password">
            </div>
            <div>
                <label>New Password</label>
                <input type="password" name="password" autocomplete="new-password">
            </div>
            <div>
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" autocomplete="new-password">
            </div>
        </div>

        @if ($employee)
            <h2 style="margin-top:26px">Employee Details</h2>
            <div class="form-grid" style="margin-top:14px">
                <div>
                    <label>First Name</label>
                    <input name="employee[first_name]" value="{{ old('employee.first_name', $employee->first_name) }}" required>
                </div>
                <div>
                    <label>Last Name</label>
                    <input name="employee[last_name]" value="{{ old('employee.last_name', $employee->last_name) }}" required>
                </div>
                <div>
                    <label>Employee Email</label>
                    <input type="email" name="employee[email]" value="{{ old('employee.email', $employee->email) }}">
                </div>
                <div>
                    <label>Phone</label>
                    <input name="employee[phone]" value="{{ old('employee.phone', $employee->phone) }}">
                </div>
                <div>
                    <label>TIN</label>
                    <input name="employee[tin]" value="{{ old('employee.tin', $employee->tin) }}">
                </div>
                <div>
                    <label>SSNIT No.</label>
                    <input name="employee[ssnit_number]" value="{{ old('employee.ssnit_number', $employee->ssnit_number) }}">
                </div>
                <div>
                    <label>Bank Name</label>
                    <input name="employee[bank_name]" value="{{ old('employee.bank_name', $employee->bank_name) }}">
                </div>
                <div>
                    <label>Bank Branch</label>
                    <input name="employee[bank_branch]" value="{{ old('employee.bank_branch', $employee->bank_branch) }}">
                </div>
                <div>
                    <label>Account Name</label>
                    <input name="employee[bank_account_name]" value="{{ old('employee.bank_account_name', $employee->bank_account_name) }}">
                </div>
                <div>
                    <label>Bank Account</label>
                    <input name="employee[bank_account]" value="{{ old('employee.bank_account', $employee->bank_account) }}">
                </div>
            </div>
        @else
            <div class="notice" style="margin-top:22px">No employee record is linked to this user account yet.</div>
        @endif

        <div class="actions" style="margin-top:18px">
            <button class="btn primary">Save Profile</button>
        </div>
    </form>
@endsection
