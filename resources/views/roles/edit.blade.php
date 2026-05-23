@extends('layouts.app', ['title' => 'Edit Role'])

@section('content')
    <div class="topbar"><h1>Edit Role</h1></div>
    <form class="panel" method="post" action="{{ route('roles.update', $role) }}">
        @method('put')
        @include('roles._form', ['button' => 'Save Role'])
    </form>
@endsection
