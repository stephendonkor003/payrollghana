<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Payslip extends Model
{
    use LogsActivity;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_PAID = 'paid';
    public const STATUS_PARTIALLY_PAID = 'partially_paid';
    public const STATUS_RETURNED_TO_BANK = 'returned_to_bank';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'payroll_run_id',
        'employee_id',
        'verification_token',
        'employee_number',
        'employee_name',
        'department',
        'job_title',
        'basic_salary',
        'allowances',
        'gross_pay',
        'ssnit_employee',
        'taxable_income',
        'paye',
        'other_deductions',
        'total_deductions',
        'net_pay',
        'payment_status',
        'paid_amount',
        'payment_note',
        'payment_status_updated_by',
        'payment_status_updated_at',
        'employer_pension',
        'tier_one_ssnit',
        'tier_two_pension',
        'nhia_portion',
        'meta',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'gross_pay' => 'decimal:2',
        'ssnit_employee' => 'decimal:2',
        'taxable_income' => 'decimal:2',
        'paye' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'payment_status_updated_at' => 'datetime',
        'employer_pension' => 'decimal:2',
        'tier_one_ssnit' => 'decimal:2',
        'tier_two_pension' => 'decimal:2',
        'nhia_portion' => 'decimal:2',
        'meta' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Payslip $payslip): void {
            $payslip->verification_token ??= (string) Str::ulid();
            $payslip->payment_status ??= self::STATUS_PENDING;
        });
    }

    public static function paymentStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_PAID => 'Paid',
            self::STATUS_PARTIALLY_PAID => 'Partially Paid',
            self::STATUS_RETURNED_TO_BANK => 'Returned to Bank',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::paymentStatuses()[$this->payment_status] ?? 'Unknown';
    }

    public function getPaymentBalanceAttribute(): float
    {
        return max(0, round((float) $this->net_pay - (float) $this->paid_amount, 2));
    }

    public function ensureVerificationToken(): string
    {
        if (! $this->verification_token) {
            $this->forceFill(['verification_token' => (string) Str::ulid()])->save();
        }

        return $this->verification_token;
    }

    public function payrollRun()
    {
        return $this->belongsTo(PayrollRun::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function paymentStatusUpdater()
    {
        return $this->belongsTo(User::class, 'payment_status_updated_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('payslips')
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
