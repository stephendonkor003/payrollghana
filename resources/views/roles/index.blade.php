@extends('layouts.app', ['title' => 'Roles'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Roles</h1>
            <p class="muted">Spatie permission roles control what each login account can do.</p>
        </div>
        <div class="actions">
            <a class="btn subtle" href="{{ route('dashboard') }}">Back</a>
            <a class="btn primary" href="{{ route('roles.create') }}">Create Role</a>
        </div>
    </div>

    <div class="table-card">
    <table id="roles-table" class="data-table">
        <thead><tr><th>Role</th><th>Users</th><th>Permissions</th><th></th></tr></thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td><strong>{{ $role->name }}</strong></td>
                    <td>{{ $role->users_count }}</td>
                    <td>{{ $role->permissions->pluck('name')->join(', ') ?: 'No permissions' }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn" href="{{ route('roles.edit', $role) }}">Edit</a>
                            <form method="post" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('Delete this role?')">
                                @csrf @method('delete')
                                <button class="btn warn">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
