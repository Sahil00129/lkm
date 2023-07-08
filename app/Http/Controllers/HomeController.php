<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Loan;
use App\Models\LoanEmi;
use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_customer = Customer::select('id')->count();
        // total emis
        $total_Emis = Loan::where('pending_amount','!=',0)->count();
        // current_month receved emis
        $recevied_emis = LoanEmi::select('loan_id')->whereMonth('emi_received_date',date('m'))->whereYear('emi_received_date', date('Y'))->distinct('loan_id')->count();
        $pending_emis = $total_Emis - $recevied_emis;

        return view('pages.dashboard',(['total_customer' => $total_customer,'total_Emis' => $total_Emis,'recevied_emis' => $recevied_emis, 'pending_emis' => $pending_emis]));
    }

    public function totalAmountChart()
    {
        $total_amount = Loan::sum('total_amount');
        $pending_amount = Loan::sum('pending_amount');
        $receving_amount = Loan::sum('received_amount');

        $response['total_amount'] = $total_amount;
        $response['pending_amount'] = $pending_amount;
        $response['receving_amount'] = $receving_amount;
        $response['success'] = true;
        $response['messages'] = 'load_data';

        return Response::json($response);
    }
}
