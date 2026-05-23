<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRun;
use App\Services\GhanaPayrollCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollRunController extends Controller
{
    public function index()
    {
        $payrollRuns = PayrollRun::latest('period_end')->get();

        return view('payroll-runs.index', compact('payrollRuns'));
    }

    public function create()
    {
        return view('payroll-runs.create', [
            'activeEmployees' => Employee::where('is_active', true)->count(),
        ]);
    }

    public function store(Request $request, GhanaPayrollCalculator $calculator)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'pay_period' => ['required', 'date_format:Y-m'],
            'payment_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $periodStart = Carbon::createFromFormat('Y-m', $data['pay_period'])->startOfMonth();
        $periodEnd = (clone $periodStart)->endOfMonth();
        $employees = Employee::where('is_active', true)->orderBy('last_name')->get();

        if ($employees->isEmpty()) {
            return back()->withErrors(['pay_period' => 'Add at least one active employee before running payroll.'])->withInput();
        }

        $payrollRun = DB::transaction(function () use ($data, $periodStart, $periodEnd, $employees, $calculator) {
            $run = PayrollRun::create([
                'title' => $data['title'],
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'payment_date' => $data['payment_date'] ?? null,
                'status' => 'processed',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($employees as $employee) {
                $amounts = $calculator->calculate(
                    (float) $employee->basic_salary,
                    (float) $employee->allowances,
                    (float) $employee->other_deductions,
                );

                $run->payslips()->create(array_merge($amounts, [
                    'employee_id' => $employee->id,
                    'employee_number' => $employee->employee_number,
                    'employee_name' => $employee->full_name,
                    'department' => $employee->department,
                    'job_title' => $employee->job_title,
                    'meta' => [
                        'tin' => $employee->tin,
                        'ssnit_number' => $employee->ssnit_number,
                        'bank_name' => $employee->bank_name,
                        'bank_branch' => $employee->bank_branch,
                        'bank_account_name' => $employee->bank_account_name,
                        'bank_account' => $employee->bank_account,
                    ],
                ]));
            }

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

            return $run;
        });

        return redirect()->route('payroll-runs.show', $payrollRun)->with('status', 'Payroll run processed.');
    }

    public function show(PayrollRun $payrollRun)
    {
        $payrollRun->load('payslips.employee');

        return view('payroll-runs.show', compact('payrollRun'));
    }

    public function destroy(PayrollRun $payrollRun)
    {
        $payrollRun->delete();

        return redirect()->route('payroll-runs.index')->with('status', 'Payroll run deleted.');
    }

}
