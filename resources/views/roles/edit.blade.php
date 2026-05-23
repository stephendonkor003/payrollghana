@extends('layouts.app', ['title' => 'Edit Role'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Edit Role</h1>
            <p class="muted">Adjust the permissions available to this role.</p>
        </div>
        <a class="btn subtle" href="{{ route('roles.index') }}">Back</a>
    </div>
    <form class="panel" method="post" action="{{ route('roles.update', $role) }}">
        @method('put')
        @include('roles._form', ['button' => 'Save Role'])
    </form>
@endsection
