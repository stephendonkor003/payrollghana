<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class CompanySetting extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'logo_path',
        'email',
        'phone',
        'tin',
        'address',
        'city',
        'payslip_footer',
    ];

    public static function current(): self
    {
        return self::firstOrCreate([], [
            'name' => 'Your Company Ltd',
            'city' => 'Accra',
            'payslip_footer' => 'This is a computer-generated payslip.',
        ]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('company')
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
