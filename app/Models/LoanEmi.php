<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanEmi extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_id','pending_amt', 'emi_amount','emi_date','remarks','emi_received_date','status', 'created_at', 'updated_at'
    ];

    public function LoanDetails()
    {
        return $this->hasOne('App\Models\Loan','id','loan_id');
    }
}
