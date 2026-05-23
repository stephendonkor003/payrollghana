@extends('layouts.app', ['title' => 'Users'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Users</h1>
            <p class="muted">Create login accounts and assign Spatie roles.</p>
        </div>
        <div class="actions">
            <a class="btn subtle" href="{{ route('dashboard') }}">Back</a>
            <a class="btn primary" href="{{ route('users.create') }}">Create User</a>
        </div>
    </div>

    <div class="filter-row">
        <div>
            <label for="user-role-filter">Filter by role</label>
            <input id="user-role-filter" data-table-filter="#users-table" data-column="2" placeholder="Type role">
        </div>
    </div>

    <div class="table-card">
    <table id="users-table" class="data-table">
        <thead><tr><th>User</th><th>Linked Employee</th><th>Roles</th><th>Created</th><th></th></tr></thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong><br><span class="muted">{{ $user->email }}</span></td>
                    <td>{{ $user->employee?->full_name ?: 'N/A' }}</td>
                    <td>{{ $user->roles->pluck('name')->join(', ') ?: 'No role' }}</td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn" href="{{ route('users.edit', $user) }}">Edit</a>
                            <form method="post" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                @csrf @method('delete')
                                <button class="btn warn">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No users yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
@endsection
