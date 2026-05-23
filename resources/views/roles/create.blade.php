@extends('layouts.app', ['title' => 'Create Role'])

@section('content')
    <div class="topbar"><h1>Create Role</h1></div>
    <form class="panel" method="post" action="{{ route('roles.store') }}">
        @include('roles._form', ['button' => 'Create Role'])
    </form>
@endsection
