<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function index()
    {
        $activities = Activity::with('causer', 'subject')->latest()->paginate(20);

        return view('audit-logs.index', compact('activities'));
    }
}
