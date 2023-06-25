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
        Schema::create('extra_repayment_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('month_number');
            $table->decimal('starting_balance', 12, 2);
            $table->decimal('monthly_payment', 12, 2);
            $table->decimal('principal_component', 12, 2);
            $table->decimal('interest_component', 12, 2);
            $table->decimal('extra_repayment_made', 12, 2)->nullable();
            $table->decimal('ending_balance_after_repayment', 12, 2);
            $table->decimal('remaining_loan_term_after_repayment', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_repayment_schedule');
    }
};
