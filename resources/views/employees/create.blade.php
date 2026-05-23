@extends('layouts.app', ['title' => 'Add Employee'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Add Employee</h1>
            <p class="muted">Create a staff profile with salary, statutory, and bank details.</p>
        </div>
        <a class="btn subtle" href="{{ route('employees.index') }}">Back</a>
    </div>
    <form class="panel" method="post" action="{{ route('employees.store') }}">
        @include('employees._form', ['button' => 'Create Employee'])
    </form>
@endsection
