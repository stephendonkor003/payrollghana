<?php

namespace App\Services;

class GhanaPayrollCalculator
{
    public const SSNIT_EMPLOYEE_RATE = 0.055;
    public const EMPLOYER_PENSION_RATE = 0.13;
    public const TIER_ONE_SSNIT_RATE = 0.135;
    public const TIER_TWO_PENSION_RATE = 0.05;
    public const NHIA_PORTION_RATE = 0.025;

    public function calculate(float $basicSalary, float $allowances = 0, float $otherDeductions = 0): array
    {
        $grossPay = $this->money($basicSalary + $allowances);
        $ssnitEmployee = $this->money($basicSalary * self::SSNIT_EMPLOYEE_RATE);
        $taxableIncome = $this->money(max(0, $grossPay - $ssnitEmployee));
        $paye = $this->calculatePaye($taxableIncome);
        $totalDeductions = $this->money($ssnitEmployee + $paye + $otherDeductions);

        return [
            'basic_salary' => $this->money($basicSalary),
            'allowances' => $this->money($allowances),
            'gross_pay' => $grossPay,
            'ssnit_employee' => $ssnitEmployee,
            'taxable_income' => $taxableIncome,
            'paye' => $paye,
            'other_deductions' => $this->money($otherDeductions),
            'total_deductions' => $totalDeductions,
            'net_pay' => $this->money($grossPay - $totalDeductions),
            'employer_pension' => $this->money($basicSalary * self::EMPLOYER_PENSION_RATE),
            'tier_one_ssnit' => $this->money($basicSalary * self::TIER_ONE_SSNIT_RATE),
            'tier_two_pension' => $this->money($basicSalary * self::TIER_TWO_PENSION_RATE),
            'nhia_portion' => $this->money($basicSalary * self::NHIA_PORTION_RATE),
        ];
    }

    public function calculatePaye(float $taxableIncome): float
    {
        $bands = [
            [490.00, 0.00],
            [110.00, 0.05],
            [130.00, 0.10],
            [3166.67, 0.175],
            [16000.00, 0.25],
            [30520.00, 0.30],
            [INF, 0.35],
        ];

        $remaining = $taxableIncome;
        $tax = 0;

        foreach ($bands as [$limit, $rate]) {
            if ($remaining <= 0) {
                break;
            }

            $taxableAtBand = min($remaining, $limit);
            $tax += $taxableAtBand * $rate;
            $remaining -= $taxableAtBand;
        }

        return $this->money($tax);
    }

    private function money(float $amount): float
    {
        return round($amount, 2);
    }
}
