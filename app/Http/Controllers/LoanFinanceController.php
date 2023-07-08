<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Loan;
use App\Models\LoanEmi;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Http\Request;

class LoanFinanceController extends Controller
{
    public function loanfinance()
    {
        return view('pages.create-loan');
    }
    public function storeLoanFinanceDetails(Request $request)
    {

        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'name' => 'required',
                'father_name' => 'required',
            ]);

            $customersave['name'] = $request->name;
            $customersave['father_name'] = $request->father_name;
            $customersave['contact_no'] = $request->contact_no;
            $customersave['address'] = $request->address;
            $customersave['status'] = 1;
            $savecustomerdetails = Customer::create($customersave);

            $loansave['customer_id'] = $savecustomerdetails->id;
            $loansave['loan_amount'] = $request->loan_amount;
            $loansave['no_of_emi'] = $request->no_of_emi;
            $loansave['emi_amount'] = $request->emi_amount;
            $loansave['emi_date'] = $request->emi_date;
            $loansave['rate_of_interest'] = $request->rate_of_interest;
            $loansave['interest_to_paid'] = $request->interest_to_paid;
            $loansave['total_amount'] = $request->total_amount;

            // $pending_amount = $request->no_of_emi * $request->emi_amount;
            $loansave['received_amount'] = 0;
            $loansave['pending_amount'] = $request->total_amount;
            $loansave['status'] = 1;

            $emi_date = explode('-',$request->emi_date);
            $emi_date = $emi_date[0].'-' . $emi_date[1];
            $today_month = date('Y-m');
            if($today_month > $emi_date){
                $loansave['previous_status'] = 0;
            }else{
                $loansave['previous_status'] = 1;
            }
            
            $saveloandetails = Loan::create($loansave);
            if ($saveloandetails) {
                $response['success'] = true;
                $response['error'] = false;
                $response['success_message'] = 'Data saved successfully';
            } else {
                $response['success'] = false;
                $response['error'] = true;
                $response['error_message'] = "Can not import consignees please try again";
            }

            DB::commit();
        } catch (Exception $e) {
            $response['error'] = false;
            $response['error_message'] = $e;
            $response['success'] = false;
            $response['redirect_url'] = $url;
        }
        return response()->json($response);

    }
    public function loanList()
    {
        $loan_details = Customer::with('LoanDetail')->get();
        return view('pages.loan-list', ['loan_details' => $loan_details]);
    }

    public function loanEmi()
    {
        $current_month = date('m');
        $current_year = date('Y');

        $loan_details = Loan::with('Customer', 'LoanEmi')->where('pending_amount', '!=', 0)->get();
        return view('pages.loan-emi-list', ['loan_details' => $loan_details]);
    }

    public function emiReceived(Request $request)
    {
        try {
            DB::beginTransaction();

            $lona_details = Loan::where('id', $request->loan_id)->first();
            $pending_amount = $lona_details->pending_amount - $lona_details->emi_amount;
            $received_amount = $lona_details->received_amount + $lona_details->emi_amount;
            $updatdetails = Loan::where('id', $request->loan_id)->update(['pending_amount' => $pending_amount, 'received_amount' => $received_amount]);

            if ($updatdetails) {
                $last_month_date = LoanEmi::where('loan_id', $request->loan_id)->orderBy('id', 'desc')->first();
                if (!empty($last_month_date)) {
                    $last_date = $last_month_date->emi_date;
                    $emi_date = date("Y-m-d", strtotime($last_date . ' + 1 month'));
                } else {
                    $emi_date = $lona_details->emi_date;
                }

                $loanemisave['loan_id'] = $request->loan_id;
                $loanemisave['pending_amt'] = $pending_amount;
                $loanemisave['emi_amount'] = $lona_details->emi_amount;
                $loanemisave['emi_date'] = $emi_date;
                $loanemisave['remarks'] = $request->remarks;
                $loanemisave['emi_received_date'] = date('Y-m-d');
                $loanemisave['status'] = 1;
                $savecustomerdetails = LoanEmi::create($loanemisave);

                $response['success'] = true;
                $response['error'] = false;
                $response['success_message'] = 'Data saved successfully';
            } else {
                $response['success'] = false;
                $response['error'] = true;
                $response['error_message'] = "Can not import consignees please try again";
            }

            DB::commit();
        } catch (Exception $e) {
            $response['error'] = false;
            $response['error_message'] = $e;
            $response['success'] = false;
            $response['redirect_url'] = $url;
        }
        return response()->json($response);

    }
    public function viewEmisList($id)
    {

        $Emi_details = LoanEmi::where('loan_id', $id)->get();
        $customer_details = Loan::with('Customer')->where('id', $id)->first();
        return view('pages.view-emis-list', ['Emi_details' => $Emi_details, 'customer_details' => $customer_details]);
    }

    public function updatePreviousData(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $get_loan_details = Loan::where('id', $request->loan_id)->first();
            $starting_emi = $get_loan_details->emi_date;
            $end_date = date('Y-m-d', strtotime("+".$request->count_emi - 1 ." months", strtotime($starting_emi)));

            $result = CarbonPeriod::create($starting_emi, '1 month', $end_date);
            

            foreach ($result as $dt) { 
                $get_loan_details = Loan::where('id', $request->loan_id)->first();
                $starting_emi = $get_loan_details->emi_date;

                $pending_amount = $get_loan_details->pending_amount - $get_loan_details->emi_amount;
                

                $loanemisave['loan_id'] = $request->loan_id;
                $loanemisave['pending_amt'] = $pending_amount;
                $loanemisave['emi_amount'] = $get_loan_details->emi_amount;
                $loanemisave['emi_date'] = $dt->format("Y-m-d");
                $loanemisave['emi_received_date'] = $dt->format("Y-m-d");
                $loanemisave['remarks'] = $request->remarks;
                $loanemisave['status'] = 1;
                $savecustomerdetails = LoanEmi::create($loanemisave);

                $loan_update = Loan::where('id', $request->loan_id)->update(['received_amount' => $request->received_amount, 'pending_amount' => $pending_amount,'previous_status' => 1]);

            }
                $response['success'] = true;
                $response['error'] = false;
                $response['success_message'] = 'Data saved successfully';

    
            DB::commit();
        } catch (Exception $e) {
            $response['error'] = false;
            $response['error_message'] = $e;
            $response['success'] = false;
            $response['redirect_url'] = $url;
        }
        return response()->json($response);

    }
}
