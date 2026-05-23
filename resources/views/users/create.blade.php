@extends('layouts.app', ['title' => 'Create User'])

@section('content')
    <div class="topbar"><h1>Create User</h1></div>
    <form class="panel" method="post" action="{{ route('users.store') }}">
        @include('users._form', ['button' => 'Create User'])
    </form>
@endsection
