@extends('layouts.app', ['title' => 'Add Employee'])

@section('content')
    <div class="topbar"><h1>Add Employee</h1></div>
    <form class="panel" method="post" action="{{ route('employees.store') }}">
        @include('employees._form', ['button' => 'Create Employee'])
    </form>
@endsection
