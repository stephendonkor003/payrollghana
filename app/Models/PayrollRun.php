<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class PayrollRun extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'period_start',
        'period_end',
        'payment_date',
        'status',
        'employee_count',
        'gross_total',
        'deductions_total',
        'net_total',
        'employer_pension_total',
        'tier_one_ssnit_total',
        'tier_two_pension_total',
        'nhia_portion_total',
        'employer_total_cost',
        'notes',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'payment_date' => 'date',
        'gross_total' => 'decimal:2',
        'deductions_total' => 'decimal:2',
        'net_total' => 'decimal:2',
        'employer_pension_total' => 'decimal:2',
        'tier_one_ssnit_total' => 'decimal:2',
        'tier_two_pension_total' => 'decimal:2',
        'nhia_portion_total' => 'decimal:2',
        'employer_total_cost' => 'decimal:2',
    ];

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('payroll')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
