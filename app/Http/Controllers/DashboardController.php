<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRun;
use App\Models\Payslip;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        try {
            $lastRun = PayrollRun::latest('period_end')->first();
            $activeEmployees = Employee::where('is_active', true)->count();
            $employees = Employee::count();
            $monthlyPayroll = PayrollRun::whereYear('period_end', now()->year)
                ->whereMonth('period_end', now()->month)
                ->sum('net_total');

            $stats = [
                'employees' => $employees,
                'activeEmployees' => $activeEmployees,
                'inactiveEmployees' => max(0, $employees - $activeEmployees),
                'payrollRuns' => PayrollRun::count(),
                'lastRun' => $lastRun,
                'monthlyPayroll' => $monthlyPayroll,
                'totalNetPaid' => PayrollRun::sum('net_total'),
                'pendingPayslips' => Payslip::whereIn('payment_status', [Payslip::STATUS_PENDING, Payslip::STATUS_PROCESSING])->count(),
                'paidPayslips' => Payslip::where('payment_status', Payslip::STATUS_PAID)->count(),
                'activeRate' => $employees > 0 ? round(($activeEmployees / $employees) * 100) : 0,
                'lastRunPaidRate' => $lastRun && $lastRun->employee_count > 0
                    ? round(($lastRun->payslips()->where('payment_status', Payslip::STATUS_PAID)->count() / $lastRun->employee_count) * 100)
                    : 0,
            ];

            $recentRuns = PayrollRun::latest('period_end')->take(5)->get();
            $recentEmployees = Employee::latest()->take(5)->get();
            $paymentStatusCounts = Payslip::select('payment_status', DB::raw('count(*) as total'))
                ->groupBy('payment_status')
                ->pluck('total', 'payment_status');
        } catch (QueryException) {
            $stats = null;
            $recentRuns = collect();
            $recentEmployees = collect();
            $paymentStatusCounts = collect();
        }

        return view('dashboard', compact('stats', 'recentRuns', 'recentEmployees', 'paymentStatusCounts'));
    }
}
