@extends('layouts.app', ['title' => 'Create User'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Create User</h1>
            <p class="muted">Add a login account and assign the right access roles.</p>
        </div>
        <a class="btn subtle" href="{{ route('users.index') }}">Back</a>
    </div>
    <form class="panel" method="post" action="{{ route('users.store') }}">
        @include('users._form', ['button' => 'Create User'])
    </form>
@endsection
