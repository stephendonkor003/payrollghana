@extends('layouts.app', ['title' => 'Employees'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Employees</h1>
            <p class="muted">Salary details here are used when you process payroll.</p>
        </div>
        <div class="actions">
            <a class="btn subtle" href="{{ route('dashboard') }}">Back</a>
            <a class="btn primary" href="{{ route('employees.create') }}">Add Employee</a>
        </div>
    </div>

    <div class="filter-row">
        <div>
            <label for="employee-status-filter">Filter by status</label>
            <select id="employee-status-filter" data-table-filter="#employees-table" data-column="4">
                <option value="">All statuses</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div>
            <label for="employee-department-filter">Filter by department</label>
            <input id="employee-department-filter" data-table-filter="#employees-table" data-column="2" placeholder="Type department or role">
        </div>
    </div>

    <div class="table-card">
    <table id="employees-table" class="data-table">
        <thead><tr><th>No.</th><th>Name</th><th>Role</th><th>Basic Salary</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse ($employees as $employee)
                <tr>
                    <td>{{ $employee->employee_number }}</td>
                    <td><a href="{{ route('employees.show', $employee) }}"><strong>{{ $employee->full_name }}</strong></a><br><span class="muted">{{ $employee->email }}</span></td>
                    <td>{{ $employee->job_title ?: 'N/A' }}<br><span class="muted">{{ $employee->department }}</span></td>
                    <td>GH¢ {{ number_format((float) $employee->basic_salary, 2) }}</td>
                    <td><span class="badge">{{ $employee->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td><a class="btn" href="{{ route('employees.edit', $employee) }}">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="6">No employees yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
@endsection
