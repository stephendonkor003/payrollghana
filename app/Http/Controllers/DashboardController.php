<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollRun;
use Illuminate\Database\QueryException;

class DashboardController extends Controller
{
    public function __invoke()
    {
        try {
            $stats = [
                'employees' => Employee::count(),
                'activeEmployees' => Employee::where('is_active', true)->count(),
                'payrollRuns' => PayrollRun::count(),
                'lastRun' => PayrollRun::latest()->first(),
            ];
        } catch (QueryException) {
            $stats = null;
        }

        return view('dashboard', compact('stats'));
    }
}
