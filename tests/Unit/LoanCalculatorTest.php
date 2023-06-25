<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase as TestsTestCase;

class LoanCalculatorTest extends TestsTestCase
{
    use RefreshDatabase;

    /**
     * Test function for valid data
     */
    public function test_calculate_monthly_payment_with_extra_payment()
    {
        $loanData = [
            'loan_amount' => 100000,
            'annual_interest_rate' => 5,
            'loan_term' => 2,
            'monthly_extra_payment' => 0,
        ];

        $response = $this->post('/api/calculate-payment', $loanData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'messages' => 'Monthly Payment Generated',
                'data' => [
                    'monthly_payment' => 4387.14
                ]
            ]);

        $this->assertDatabaseHas('loans', [
            'loan_amount' => 100000,
            'annual_interest_rate' => 5,
            'loan_term' => 2,
            'monthly_extra_payment' => 0,
        ]);
    }
    /*
     * Test case for invalid data
     */
    public function test_calculate_monthly_payment_with_invalid_data()
    {
        $loanData = [
            'loan_amount' => -100000,
            'annual_interest_rate' => -5,
            'loan_term' => -2,
            'monthly_extra_payment' => -500,
        ];

        $response = $this->post('/api/calculate-payment', $loanData);

        $response->assertStatus(422)
            ->assertJson([
                'status' => false,
                'messages' => 'Invalid Data',
                
            ]);

        $this->assertDatabaseMissing('loans', [
            'loan_amount' => -100000,
            'annual_interest_rate' => -5,
            'loan_term' => -2,
            'monthly_extra_payment' => -500,
        ]);
    }
}
