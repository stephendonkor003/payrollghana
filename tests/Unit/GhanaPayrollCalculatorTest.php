<?php

namespace Tests\Unit;

use App\Services\GhanaPayrollCalculator;
use PHPUnit\Framework\TestCase;

class GhanaPayrollCalculatorTest extends TestCase
{
    public function test_justice_okyere_seed_salary_nets_ten_thousand_ghana_cedis(): void
    {
        $amounts = (new GhanaPayrollCalculator())->calculate(13542.86);

        $this->assertSame(10000.00, $amounts['net_pay']);
        $this->assertSame(744.86, $amounts['ssnit_employee']);
        $this->assertSame(2798.00, $amounts['paye']);
        $this->assertSame(1760.57, $amounts['employer_pension']);
    }
}
