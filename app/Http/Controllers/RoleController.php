<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->with('permissions')->orderBy('name')->get();

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create', [
            'role' => new Role(),
            'permissions' => Permission::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
        $role->syncPermissions($data['permissions'] ?? []);

        activity('roles')->causedBy($request->user())->performedOn($role)->withProperties(['permissions' => $data['permissions'] ?? []])->log('Created role');

        return redirect()->route('roles.index')->with('status', 'Role created.');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $data = $this->validated($request, $role);

        if ($role->name !== 'Super Admin') {
            $role->update(['name' => $data['name']]);
        }

        $role->syncPermissions($data['permissions'] ?? []);

        activity('roles')->causedBy($request->user())->performedOn($role)->withProperties(['permissions' => $data['permissions'] ?? []])->log('Updated role');

        return redirect()->route('roles.index')->with('status', 'Role updated.');
    }

    public function destroy(Request $request, Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'HR Manager', 'Employee'], true)) {
            return back()->withErrors(['role' => 'Default roles cannot be deleted.']);
        }

        activity('roles')->causedBy($request->user())->performedOn($role)->log('Deleted role');
        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Role deleted.');
    }

    private function validated(Request $request, ?Role $role = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles')->ignore($role?->id)],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);
    }
}
