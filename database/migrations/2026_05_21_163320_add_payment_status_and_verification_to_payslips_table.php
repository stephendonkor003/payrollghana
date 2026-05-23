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
        Schema::table('payslips', function (Blueprint $table) {
            $table->string('verification_token', 80)->nullable()->unique()->after('id');
            $table->string('payment_status')->default('pending')->after('net_pay');
            $table->decimal('paid_amount', 12, 2)->default(0)->after('payment_status');
            $table->text('payment_note')->nullable()->after('paid_amount');
            $table->foreignId('payment_status_updated_by')->nullable()->after('payment_note')->constrained('users')->nullOnDelete();
            $table->timestamp('payment_status_updated_at')->nullable()->after('payment_status_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropConstrainedForeignId('payment_status_updated_by');
            $table->dropColumn([
                'verification_token',
                'payment_status',
                'paid_amount',
                'payment_note',
                'payment_status_updated_at',
            ]);
        });
    }
};
