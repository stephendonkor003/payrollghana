<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create', ['employee' => new Employee()]);
    }

    public function store(Request $request)
    {
        Employee::create($this->validated($request));

        return redirect()->route('employees.index')->with('status', 'Employee created.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['payslips.payrollRun']);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $employee->update($this->validated($request, $employee));

        return redirect()->route('employees.show', $employee)->with('status', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('status', 'Employee deleted.');
    }

    private function validated(Request $request, ?Employee $employee = null): array
    {
        $data = $request->validate([
            'employee_number' => ['required', 'string', 'max:50', Rule::unique('employees')->ignore($employee?->id)],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'department' => ['nullable', 'string', 'max:100'],
            'job_title' => ['required', 'string', 'max:100'],
            'tin' => ['nullable', 'string', 'max:100'],
            'ssnit_number' => ['nullable', 'string', 'max:100'],
            'hire_date' => ['nullable', 'date'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
            'allowances' => ['nullable', 'numeric', 'min:0'],
            'other_deductions' => ['nullable', 'numeric', 'min:0'],
            'bank_name' => ['required', 'string', 'max:100'],
            'bank_branch' => ['required', 'string', 'max:100'],
            'bank_account_name' => ['required', 'string', 'max:150'],
            'bank_account' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['allowances'] = $data['allowances'] ?? 0;
        $data['other_deductions'] = $data['other_deductions'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
