@extends('layouts.app', ['title' => 'Create Role'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Create Role</h1>
            <p class="muted">Group permissions into a reusable access level.</p>
        </div>
        <a class="btn subtle" href="{{ route('roles.index') }}">Back</a>
    </div>
    <form class="panel" method="post" action="{{ route('roles.store') }}">
        @include('roles._form', ['button' => 'Create Role'])
    </form>
@endsection
