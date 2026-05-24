<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_update_their_own_account(): void
    {
        $user = User::create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'password' => 'Password@12345',
        ]);

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'New Name',
                'email' => 'new@example.com',
            ])
            ->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertSame('New Name', $user->name);
        $this->assertSame('new@example.com', $user->email);
    }

    public function test_linked_employee_can_update_their_own_profile_data(): void
    {
        $employee = Employee::create([
            'employee_number' => 'EMP-900',
            'first_name' => 'Old',
            'last_name' => 'Employee',
            'email' => 'old.employee@example.com',
            'job_title' => 'Developer',
            'basic_salary' => 1000,
        ]);

        $user = User::create([
            'employee_id' => $employee->id,
            'name' => 'Old Employee',
            'email' => 'employee@example.com',
            'password' => 'Password@12345',
        ]);

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Old Employee',
                'email' => 'employee@example.com',
                'employee' => [
                    'first_name' => 'Ama',
                    'last_name' => 'Mensah',
                    'email' => 'ama.mensah@example.com',
                    'phone' => '+233 20 111 2222',
                    'tin' => 'P1111111111',
                    'ssnit_number' => 'C111111111111',
                    'bank_name' => 'GCB Bank PLC',
                    'bank_branch' => 'Accra Central',
                    'bank_account_name' => 'Ama Mensah',
                    'bank_account' => '1234567890',
                ],
            ])
            ->assertRedirect(route('profile.edit'));

        $employee->refresh();

        $this->assertSame('Ama', $employee->first_name);
        $this->assertSame('Mensah', $employee->last_name);
        $this->assertSame('+233 20 111 2222', $employee->phone);
        $this->assertSame('GCB Bank PLC', $employee->bank_name);
    }

    public function test_password_update_requires_the_current_password(): void
    {
        $user = User::create([
            'name' => 'Profile User',
            'email' => 'profile@example.com',
            'password' => 'Password@12345',
        ]);

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.update'), [
                'name' => 'Profile User',
                'email' => 'profile@example.com',
                'password' => 'NewPassword@12345',
                'password_confirmation' => 'NewPassword@12345',
            ])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHasErrors('current_password');

        $this->actingAs($user)
            ->put(route('profile.update'), [
                'name' => 'Profile User',
                'email' => 'profile@example.com',
                'current_password' => 'Password@12345',
                'password' => 'NewPassword@12345',
                'password_confirmation' => 'NewPassword@12345',
            ])
            ->assertRedirect(route('profile.edit'));

        $this->assertTrue(Hash::check('NewPassword@12345', $user->refresh()->password));
    }
}
