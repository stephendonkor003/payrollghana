<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user()->load('employee'),
            'employee' => $request->user()->employee,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user()->load('employee');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(10)->mixedCase()->numbers()],
            'employee.first_name' => ['nullable', 'required_with:employee.last_name', 'string', 'max:100'],
            'employee.last_name' => ['nullable', 'required_with:employee.first_name', 'string', 'max:100'],
            'employee.email' => ['nullable', 'email', 'max:255'],
            'employee.phone' => ['nullable', 'string', 'max:50'],
            'employee.tin' => ['nullable', 'string', 'max:100'],
            'employee.ssnit_number' => ['nullable', 'string', 'max:100'],
            'employee.bank_name' => ['nullable', 'string', 'max:100'],
            'employee.bank_branch' => ['nullable', 'string', 'max:100'],
            'employee.bank_account_name' => ['nullable', 'string', 'max:150'],
            'employee.bank_account' => ['nullable', 'string', 'max:100'],
        ]);

        $userData = Arr::only($data, ['name', 'email', 'password']);

        if (blank($userData['password'] ?? null)) {
            unset($userData['password']);
        }

        $user->update($userData);

        if ($user->employee && isset($data['employee'])) {
            $employeeData = Arr::only($data['employee'], [
                'first_name',
                'last_name',
                'email',
                'phone',
                'tin',
                'ssnit_number',
                'bank_name',
                'bank_branch',
                'bank_account_name',
                'bank_account',
            ]);

            $user->employee->update($employeeData);
        }

        activity('profile')
            ->causedBy($user)
            ->withProperties(['updated_employee_profile' => (bool) $user->employee])
            ->log('Updated own profile');

        return redirect()->route('profile.edit')->with('status', 'Profile updated.');
    }
}
