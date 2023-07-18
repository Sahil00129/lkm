<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'loan_amount', 'rate_of_interest', 'no_of_emi', 'emi_amount','emi_date','interest_to_paid','total_amount','received_amount','pending_amount', 'status','previous_status', 'created_at', 'updated_at'
    ];

    
    public function Customer()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }
    public function LoanEmi()
    {
        return $this->hasOne('App\Models\LoanEmi','loan_id','id')->whereMonth('emi_received_date',date('m'))->whereYear('emi_received_date', date('Y'));
    }
    public function LoanEmiFilter()
    {
        return $this->hasOne('App\Models\LoanEmi','loan_id','id');
    }
}
