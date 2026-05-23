<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use App\Models\Employee;
use App\Models\PayrollRun;
use App\Models\User;
use App\Services\GhanaPayrollCalculator;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'access dashboard',
            'manage company settings',
            'manage employees',
            'manage payroll',
            'manage users',
            'manage roles',
            'view audit logs',
            'view own payslips',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        $hrManager = Role::findOrCreate('HR Manager', 'web');
        $employeeRole = Role::findOrCreate('Employee', 'web');

        $superAdmin->syncPermissions($permissions);
        $hrManager->syncPermissions([
            'access dashboard',
            'manage company settings',
            'manage employees',
            'manage payroll',
        ]);
        $employeeRole->syncPermissions([
            'access dashboard',
            'view own payslips',
        ]);

        CompanySetting::updateOrCreate(['id' => 1], [
            'name' => 'Ghana Payroll Company Ltd',
            'email' => 'payroll@example.com',
            'phone' => '+233 20 000 0000',
            'tin' => 'C0000000000',
            'address' => 'Accra, Ghana',
            'city' => 'Accra',
            'payslip_footer' => 'This is a computer-generated payslip for payroll records.',
        ]);

        $employee = Employee::updateOrCreate(['employee_number' => 'EMP-001'], [
            'first_name' => 'Justice',
            'last_name' => 'Okyere',
            'email' => 'justice.okyere@example.com',
            'phone' => '+233 24 000 0000',
            'department' => 'Engineering',
            'job_title' => 'Senior Web Developer',
            'tin' => 'P0000000000',
            'ssnit_number' => 'C000000000000',
            'hire_date' => now()->startOfYear(),
            'basic_salary' => 13542.86,
            'allowances' => 0,
            'other_deductions' => 0,
            'bank_name' => 'GCB Bank PLC',
            'bank_branch' => 'Accra Central',
            'bank_account_name' => 'Justice Okyere',
            'bank_account' => '0123456789012',
            'is_active' => true,
        ]);

        $master = User::updateOrCreate(['email' => 'master@payroll.local'], [
            'name' => 'Master User',
            'password' => 'Master@12345',
            'email_verified_at' => now(),
        ]);
        $master->syncRoles(['Super Admin']);

        $justiceUser = User::updateOrCreate(['email' => 'justice.okyere@example.com'], [
            'employee_id' => $employee->id,
            'name' => 'Justice Okyere',
            'password' => 'Employee@12345',
            'email_verified_at' => now(),
        ]);
        $justiceUser->syncRoles(['Employee']);

        $periodStart = now()->startOfMonth();
        $periodEnd = now()->endOfMonth();

        $run = PayrollRun::updateOrCreate([
            'title' => 'Sample Monthly Payroll',
            'period_start' => $periodStart->toDateString(),
            'period_end' => $periodEnd->toDateString(),
        ], [
            'payment_date' => now()->toDateString(),
            'status' => 'processed',
            'notes' => 'Seeded sample payroll run.',
        ]);

        $amounts = app(GhanaPayrollCalculator::class)->calculate(
            (float) $employee->basic_salary,
            (float) $employee->allowances,
            (float) $employee->other_deductions,
        );

        $payslip = $run->payslips()->updateOrCreate(['employee_id' => $employee->id], array_merge($amounts, [
            'employee_number' => $employee->employee_number,
            'employee_name' => $employee->full_name,
            'department' => $employee->department,
            'job_title' => $employee->job_title,
            'payment_status' => 'pending',
            'paid_amount' => 0,
            'meta' => [
                'tin' => $employee->tin,
                'ssnit_number' => $employee->ssnit_number,
                'bank_name' => $employee->bank_name,
                'bank_branch' => $employee->bank_branch,
                'bank_account_name' => $employee->bank_account_name,
                'bank_account' => $employee->bank_account,
            ],
        ]));
        $payslip->ensureVerificationToken();

        $run->update([
            'employee_count' => $run->payslips()->count(),
            'gross_total' => $run->payslips()->sum('gross_pay'),
            'deductions_total' => $run->payslips()->sum('total_deductions'),
            'net_total' => $run->payslips()->sum('net_pay'),
            'employer_pension_total' => $run->payslips()->sum('employer_pension'),
            'tier_one_ssnit_total' => $run->payslips()->sum('tier_one_ssnit'),
            'tier_two_pension_total' => $run->payslips()->sum('tier_two_pension'),
            'nhia_portion_total' => $run->payslips()->sum('nhia_portion'),
            'employer_total_cost' => $run->payslips()->sum('gross_pay') + $run->payslips()->sum('employer_pension'),
        ]);
    }
}
