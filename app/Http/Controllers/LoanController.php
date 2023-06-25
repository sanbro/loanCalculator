<?php

namespace App\Http\Controllers;

use App\Http\Requests\loan\StoreLoanRequest;
use App\Models\ExtraRepaymentSchedule;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;
use Illuminate\Http\Request;

class LoanController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanRequest $request)
    {
        try {
            $input=$request->validated();
            // Perform the calculation
            $loanAmount = $input['loan_amount'];
            $annualInterestRate = $input['annual_interest_rate'];
            $loanTerm = $input['loan_term'];
            $monthlyExtraPayment = $input['monthly_extra_payment'];

            $monthlyInterestRate = ($annualInterestRate / 12) / 100;
            $numberOfMonths = $loanTerm * 12;

            $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));
            // Truncate the existing records in the loans table
            Loan::truncate();

            // Insert the new loan record
            Loan::insert([
                'loan_amount'           => $loanAmount,
                'annual_interest_rate'  => $annualInterestRate,
                'loan_term'             => $loanTerm,
                'monthly_extra_payment' => $monthlyExtraPayment,
                'monthly_payment'       => $monthlyPayment,
            ]);
            $this->generateAmortizationSchedule($input);
            $data = [
                'monthly_payment' => round($monthlyPayment,2),
            ];
            return response()->json( [
                'status' => True,
                'messages' => 'Monthly Payment Generated',
                'data' => $data
            ], 200 );

        } catch (\Throwable $th) {
           return response()->json( [
                'status' => False,
                'messages' => 'Invalid Data',
                'exceptionMessage' =>  (app()->environment('local') && $th instanceof \Exception) ? $th->getMessage(): null, // Message only on local environment. Please check .env file
            ], 422 );
           
        }
    }
    /**Generated the amortization schedule  */
    public function generateAmortizationSchedule($input)
    {
        // Get the loan setup data
        $loanAmount = $input['loan_amount'];
        $annualInterestRate = $input['annual_interest_rate'];
        $loanTerm = $input['loan_term'];
        $monthlyExtraPayment = $input['monthly_extra_payment'];

        // Calculate monthly payment and other parameters
        $monthlyInterestRate = ($annualInterestRate / 12) / 100;
        $numberOfMonths = $loanTerm * 12;
        $currentBalance = $loanAmount;
        $amortizationSchedule = [];
        $extraRepaymentSchedule = [];

        // Generate the amortization schedule
        for ($month = 1; $month <= $numberOfMonths; $month++) {
            $monthlyPayment = ($currentBalance * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));
            $interest = $currentBalance * $monthlyInterestRate;
            $principal = $monthlyPayment - $interest;
            $endingBalance = $currentBalance - $principal;

            $amortizationSchedule[] = [
                'month_number' => $month,
                'starting_balance' => $currentBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principal,
                'interest_component' => $interest,
                'ending_balance' => $endingBalance,
            ];

            // Update the current balance after considering the extra repayment
            $currentBalance = $endingBalance - $monthlyExtraPayment;
        }

        // Store the amortization schedule in the "loan_amortization_schedule" table
        LoanAmortizationSchedule::truncate();
        LoanAmortizationSchedule::insert($amortizationSchedule);
        if($monthlyExtraPayment > 0)
        {
            // Generate the extra repayment schedule
            $currentBalance = $loanAmount;
            $remainingLoanTerm = $loanTerm * 12;

            for ($month = 1; $month <= $numberOfMonths; $month++) {
                $monthlyPayment = ($currentBalance * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));
                $interest = $currentBalance * $monthlyInterestRate;
                $principal = $monthlyPayment - $interest;
                $endingBalance = $currentBalance - $principal;

                $extraRepayment = min($monthlyExtraPayment, $currentBalance);
                $endingBalanceAfterRepayment = $endingBalance - $extraRepayment;
                $remainingLoanTerm--;

                $extraRepaymentSchedule[] = [
                    'month_number' => $month,
                    'starting_balance' => $currentBalance,
                    'monthly_payment' => $monthlyPayment,
                    'principal_component' => $principal,
                    'interest_component' => $interest,
                    'extra_repayment_made' => $extraRepayment,
                    'ending_balance_after_repayment' => $endingBalanceAfterRepayment,
                    'remaining_loan_term_after_repayment' => $remainingLoanTerm,
                ];

                // Update the current balance after considering the extra repayment
                $currentBalance = $endingBalanceAfterRepayment;
            }
            // Calculate the effective interest rate
            $totalInterestPaid = array_sum(array_column($extraRepaymentSchedule, 'interest_component'));
            $effectiveInterestRate = ($totalInterestPaid / $loanAmount) * 100;
            Loan::where('id',1)->update(['effective_interest_rate'=>$effectiveInterestRate]);
            // Store the extra repayment schedule in the "extra_repayment_schedule" table
            ExtraRepaymentSchedule::truncate();
            ExtraRepaymentSchedule::insert($extraRepaymentSchedule);
        }
        
    }
}
