<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'company_id',
        'deal_date',
        'debit_account_key',
        'debit_sub_account_key',
        'debit_amount',
        'credit_account_key',
        'credit_sub_account_key',
        'credit_amount',
        'remark',
        'is_multiple_journal',
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
