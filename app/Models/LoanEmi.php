<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanEmi extends Model
{
    use HasFactory;
    protected $fillable = [
        'loan_id', 'emi_amount', 'emi_date', 'status', 'created_at', 'updated_at'
    ];
}
