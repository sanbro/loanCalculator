<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanCalculatorTest extends TestCase
{
    /**
     * Test function for valid data
     */
    public function testCalculateMonthlyPaymentWithExtraPayment()
    {
        $response = $this->post('/api/calculate', [
            'loan_amount' => 100000,
            'annual_interest_rate' => 5,
            'loan_term' => 10,
            'monthly_extra_payment' => 100
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'monthly_payment' => 1060.66
                ]
            ]);
    }
    /*
     * Test case for invalid data
     */
    public function testCalculateMonthlyPaymentWithInvalidData()
    {
        $response = $this->json('POST', '/api/calculate', [
            'loan_amount' => -100000,
            'annual_interest_rate' => -5,
            'loan_term' => -10,
            'monthly_extra_payment' => -100
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'loan_amount',
                'annual_interest_rate',
                'loan_term',
                'monthly_extra_payment'
            ]);
    }

}
