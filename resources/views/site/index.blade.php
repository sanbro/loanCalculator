@extends('layouts.app')
@section('title', 'Index')
@section('content')
    <div class="col-lg-8 mx-auto p-3 py-md-5">
        <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <span class="fs-4">Amortization Calculation</span>
            </a>
        </header>
        <div class="row">
            <div class="col-md-6">
                <h2>Loan Details</h2>
                <ul class="icon-list">
                    <li>Loan Amount : AED <b>{{ $loan->loan_amount }}</b></li>
                    <li>Annual Interest Rate : <b>{{ $loan->annual_interest_rate }}%</b></li>
                    <li>Loan Term : <b>{{ $loan->loan_term }} Years</b></li>
                    <li>Extra Monthly Payment : AED <b>{{ $loan->monthly_extra_payment }}</b></li>
                    <li>Effective Interest Rate : <b>{{ $loan->effective_interest_rate }}%</b></li>

                    <li class="text-muted">Monthly Payment : AED <b>{{ $loan->monthly_payment }}</b></li>
                </ul>
            </div>
        </div>
        <hr class="col-md-8 mb-5">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Amortization Schedule</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Month Number</th>
                            <th>Starting Balance</th>
                            <th>Monthly Payment</th>
                            <th>Principal Component</th>
                            <th>Interest Component</th>
                            <th>Ending Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($loanAmortizationSchedule as $schedule)
                            <tr>
                                <td>{{ $schedule->month_number }}</td>
                                <td>{{ $schedule->starting_balance }}</td>
                                <td>{{ $schedule->monthly_payment }}</td>
                                <td>{{ $schedule->principal_component }}</td>
                                <td>{{ $schedule->interest_component }}</td>
                                <td>{{ $schedule->ending_balance }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($loan->monthly_extra_payment > 0)
                <div class="col-lg-6">
                    <h1>Extra Repayment Schedule</h1>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month Number</th>
                                <th>Starting Balance</th>
                                <th>Monthly Payment</th>
                                <th>Principal Component</th>
                                <th>Interest Component</th>
                                <th>Extra Repayment Made</th>
                                <th>Ending Balance After Repayment</th>
                                <th>Remaining Loan Term After Repayment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($extraRepaymentSchedule as $schedule)
                                <tr>
                                    <td>{{ $schedule->month_number }}</td>
                                    <td>{{ $schedule->starting_balance }}</td>
                                    <td>{{ $schedule->monthly_payment }}</td>
                                    <td>{{ $schedule->principal_component }}</td>
                                    <td>{{ $schedule->interest_component }}</td>
                                    <td>{{ $schedule->extra_repayment_made }}</td>
                                    <td>{{ $schedule->ending_balance_after_repayment }}</td>
                                    <td>{{ $schedule->remaining_loan_term_after_repayment }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif


        </div>

    </div>
@endsection
