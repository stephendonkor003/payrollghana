@extends('layouts.app', ['title' => 'Employees'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Employees</h1>
            <p class="muted">Salary details here are used when you process payroll.</p>
        </div>
        <a class="btn primary" href="{{ route('employees.create') }}">Add Employee</a>
    </div>

    <table>
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
    <div style="margin-top:16px">{{ $employees->links() }}</div>
@endsection
