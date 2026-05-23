@csrf
<div class="form-grid">
    <div><label>Employee No.</label><input name="employee_number" value="{{ old('employee_number', $employee->employee_number) }}" required></div>
    <div><label>First Name</label><input name="first_name" value="{{ old('first_name', $employee->first_name) }}" required></div>
    <div><label>Last Name</label><input name="last_name" value="{{ old('last_name', $employee->last_name) }}" required></div>
    <div><label>Email</label><input type="email" name="email" value="{{ old('email', $employee->email) }}"></div>
    <div><label>Phone</label><input name="phone" value="{{ old('phone', $employee->phone) }}"></div>
    <div><label>Hire Date</label><input type="date" name="hire_date" value="{{ old('hire_date', optional($employee->hire_date)->format('Y-m-d')) }}"></div>
    <div><label>Department</label><input name="department" value="{{ old('department', $employee->department) }}"></div>
    <div><label>Job Title</label><input name="job_title" value="{{ old('job_title', $employee->job_title) }}" required></div>
    <div><label>Status</label><select name="is_active"><option value="1" @selected(old('is_active', $employee->is_active ?? true))>Active</option><option value="0" @selected(! old('is_active', $employee->is_active ?? true))>Inactive</option></select></div>
    <div><label>TIN</label><input name="tin" value="{{ old('tin', $employee->tin) }}"></div>
    <div><label>SSNIT No.</label><input name="ssnit_number" value="{{ old('ssnit_number', $employee->ssnit_number) }}"></div>
    <div><label>Basic Salary (GH¢)</label><input type="number" step="0.01" min="0" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary ?? 0) }}" required></div>
    <div><label>Allowances (GH¢)</label><input type="number" step="0.01" min="0" name="allowances" value="{{ old('allowances', $employee->allowances ?? 0) }}"></div>
    <div><label>Other Deductions (GH¢)</label><input type="number" step="0.01" min="0" name="other_deductions" value="{{ old('other_deductions', $employee->other_deductions ?? 0) }}"></div>
    <div><label>Bank Name</label><input name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}" required></div>
    <div><label>Bank Branch</label><input name="bank_branch" value="{{ old('bank_branch', $employee->bank_branch) }}" required></div>
    <div><label>Account Name</label><input name="bank_account_name" value="{{ old('bank_account_name', $employee->bank_account_name) }}" required></div>
    <div><label>Bank Account</label><input name="bank_account" value="{{ old('bank_account', $employee->bank_account) }}" required></div>
</div>
<div class="actions" style="margin-top:18px">
    <button class="btn primary">{{ $button }}</button>
    <a class="btn" href="{{ route('employees.index') }}">Cancel</a>
</div>
