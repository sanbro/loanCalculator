<?php

namespace App\Http\Controllers;

use App\Models\ExtraRepaymentSchedule;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $loan                     = Loan::findorfail(1);
        $loanAmortizationSchedule = LoanAmortizationSchedule::all();
        $extraRepaymentSchedule   = ExtraRepaymentSchedule::all();
        return View::make('site.index', [
            'loan'                     => $loan,
            'loanAmortizationSchedule' => $loanAmortizationSchedule,
            'extraRepaymentSchedule'   => $extraRepaymentSchedule
        ]);
        
    }
}
