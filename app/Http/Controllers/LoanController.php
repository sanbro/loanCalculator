<?php

namespace App\Http\Controllers;

use App\Http\Requests\loan\StoreLoanRequest;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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

            return response()->json([
                'monthly_payment' => $monthlyPayment,
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
