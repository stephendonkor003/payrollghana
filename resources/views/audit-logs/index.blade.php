@extends('layouts.app', ['title' => 'Audit Trail'])

@section('content')
    <div class="topbar">
        <div>
            <h1>Audit Trail</h1>
            <p class="muted">Security and payroll activity across the system.</p>
        </div>
        <a class="btn subtle" href="{{ route('dashboard') }}">Back</a>
    </div>

    <div class="filter-row">
        <div>
            <label for="audit-log-filter">Filter by log</label>
            <input id="audit-log-filter" data-table-filter="#audit-table" data-column="1" placeholder="users, payroll, employees">
        </div>
        <div>
            <label for="audit-user-filter">Filter by user</label>
            <input id="audit-user-filter" data-table-filter="#audit-table" data-column="3" placeholder="Name or System">
        </div>
    </div>

    <div class="table-card">
    <table id="audit-table" class="data-table">
        <thead><tr><th>Time</th><th>Log</th><th>Action</th><th>By</th><th>Subject</th><th>Changes</th></tr></thead>
        <tbody>
            @forelse ($activities as $activity)
                <tr>
                    <td>{{ $activity->created_at->format('M d, Y H:i') }}</td>
                    <td><span class="badge">{{ $activity->log_name }}</span></td>
                    <td>{{ $activity->description }}</td>
                    <td>{{ $activity->causer?->name ?: 'System' }}</td>
                    <td>{{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}</td>
                    <td><code>{{ str(collect(['changes' => $activity->attribute_changes, 'properties' => $activity->properties])->toJson())->limit(120) }}</code></td>
                </tr>
            @empty
                <tr><td colspan="6">No audit records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
@endsection
