@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
    <div class="topbar"><h1>Edit User</h1></div>
    <form class="panel" method="post" action="{{ route('users.update', $user) }}">
        @method('put')
        @include('users._form', ['button' => 'Save User'])
    </form>
@endsection
