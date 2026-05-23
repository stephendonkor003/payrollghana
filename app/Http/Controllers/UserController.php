<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'employee')->latest()->paginate(12);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', [
            'user' => new User(),
            'roles' => Role::orderBy('name')->get(),
            'employees' => Employee::orderBy('first_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $password = $data['password'];
        $roles = $data['roles'] ?? [];
        unset($data['password'], $data['roles']);

        $user = User::create($data + ['password' => $password]);
        $user->syncRoles($roles);

        activity('users')->causedBy($request->user())->performedOn($user)->withProperties(['roles' => $roles])->log('Created user account');

        return redirect()->route('users.index')->with('status', 'User account created.');
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::orderBy('name')->get(),
            'employees' => Employee::orderBy('first_name')->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validated($request, $user);
        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->update($data);
        $user->syncRoles($roles);

        activity('users')->causedBy($request->user())->performedOn($user)->withProperties(['roles' => $roles])->log('Updated user account');

        return redirect()->route('users.index')->with('status', 'User account updated.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($request->user()->is($user)) {
            return back()->withErrors(['user' => 'You cannot delete your own account while logged in.']);
        }

        activity('users')->causedBy($request->user())->performedOn($user)->log('Deleted user account');
        $user->delete();

        return redirect()->route('users.index')->with('status', 'User account deleted.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $passwordRule = $user
            ? ['nullable', Password::min(10)->mixedCase()->numbers()]
            : ['required', Password::min(10)->mixedCase()->numbers()];

        return $request->validate([
            'employee_id' => ['nullable', 'exists:employees,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user?->id)],
            'password' => $passwordRule,
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['exists:roles,name'],
        ]);
    }
}
