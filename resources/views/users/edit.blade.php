@extends('layouts.app', ['title' => 'Edit User'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Edit User</h1>
            <p class="muted">Update account access and role assignments.</p>
        </div>
        <a class="btn subtle" href="{{ route('users.index') }}">Back</a>
    </div>
    <form class="panel" method="post" action="{{ route('users.update', $user) }}">
        @method('put')
        @include('users._form', ['button' => 'Save User'])
    </form>
@endsection
