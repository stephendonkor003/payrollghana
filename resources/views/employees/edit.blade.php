@extends('layouts.app', ['title' => 'Edit Employee'])

@section('content')
    <div class="topbar"><h1>Edit Employee</h1></div>
    <form class="panel" method="post" action="{{ route('employees.update', $employee) }}">
        @method('put')
        @include('employees._form', ['button' => 'Save Changes'])
    </form>
@endsection
