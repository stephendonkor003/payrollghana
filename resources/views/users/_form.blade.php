@csrf
<div class="form-grid">
    <div>
        <label>Name</label>
        <input name="name" value="{{ old('name', $user->name) }}" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>
    <div>
        <label>Password {{ $user->exists ? '(leave blank to keep)' : '' }}</label>
        <input type="password" name="password" @required(! $user->exists)>
    </div>
    <div>
        <label>Linked Employee</label>
        <select name="employee_id">
            <option value="">No employee link</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" @selected((string) old('employee_id', $user->employee_id) === (string) $employee->id)>{{ $employee->full_name }} - {{ $employee->employee_number }}</option>
            @endforeach
        </select>
    </div>
    <div class="full">
        <label>Roles</label>
        <div class="grid cols-4">
            @php($selectedRoles = old('roles', $user->exists ? $user->roles->pluck('name')->all() : []))
            @foreach ($roles as $role)
                <label class="check-option">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" @checked(in_array($role->name, $selectedRoles, true)) style="width:auto; margin-right:8px">
                    {{ $role->name }}
                </label>
            @endforeach
        </div>
    </div>
</div>
<div class="actions" style="margin-top:18px">
    <button class="btn primary">{{ $button }}</button>
    <a class="btn" href="{{ route('users.index') }}">Cancel</a>
</div>
