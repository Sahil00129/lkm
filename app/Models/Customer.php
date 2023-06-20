<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'father_name', 'contact_no', 'address','status', 'created_at', 'updated_at'
    ];

    public function LoanDetail()
    {
        return $this->belongsTo('App\Models\Loan','id','customer_id');
    }
}
