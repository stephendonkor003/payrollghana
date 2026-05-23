<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('bank_account_name')->nullable();
        });

        Schema::table('payroll_runs', function (Blueprint $table) {
            $table->decimal('employer_pension_total', 14, 2)->default(0);
            $table->decimal('tier_one_ssnit_total', 14, 2)->default(0);
            $table->decimal('tier_two_pension_total', 14, 2)->default(0);
            $table->decimal('nhia_portion_total', 14, 2)->default(0);
            $table->decimal('employer_total_cost', 14, 2)->default(0);
        });

        Schema::table('payslips', function (Blueprint $table) {
            $table->decimal('employer_pension', 12, 2)->default(0);
            $table->decimal('tier_one_ssnit', 12, 2)->default(0);
            $table->decimal('tier_two_pension', 12, 2)->default(0);
            $table->decimal('nhia_portion', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn([
                'employer_pension',
                'tier_one_ssnit',
                'tier_two_pension',
                'nhia_portion',
            ]);
        });

        Schema::table('payroll_runs', function (Blueprint $table) {
            $table->dropColumn([
                'employer_pension_total',
                'tier_one_ssnit_total',
                'tier_two_pension_total',
                'nhia_portion_total',
                'employer_total_cost',
            ]);
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('bank_account_name');
        });
    }
};
