@extends('layouts.app', ['title' => 'Edit Employee'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Edit Employee</h1>
            <p class="muted">Update profile, salary, statutory, and bank details.</p>
        </div>
        <div class="actions">
            <a class="btn subtle" href="{{ route('employees.show', $employee) }}">Back</a>
            <a class="btn" href="{{ route('employees.index') }}">Employees</a>
        </div>
    </div>
    <form class="panel" method="post" action="{{ route('employees.update', $employee) }}">
        @method('put')
        @include('employees._form', ['button' => 'Save Changes'])
    </form>
@endsection
