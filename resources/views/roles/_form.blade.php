@csrf
<div class="form-grid">
    <div class="full">
        <label>Role Name</label>
        <input name="name" value="{{ old('name', $role->name) }}" required @readonly($role->name === 'Super Admin')>
    </div>
    <div class="full">
        <label>Permissions</label>
        <div class="grid cols-4">
            @php($selectedPermissions = old('permissions', $role->exists ? $role->permissions->pluck('name')->all() : []))
            @foreach ($permissions as $permission)
                <label class="check-option">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, $selectedPermissions, true)) style="width:auto; margin-right:8px">
                    {{ str($permission->name)->title() }}
                </label>
            @endforeach
        </div>
    </div>
</div>
<div class="actions" style="margin-top:18px">
    <button class="btn primary">{{ $button }}</button>
    <a class="btn" href="{{ route('roles.index') }}">Cancel</a>
</div>
