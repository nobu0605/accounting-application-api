<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MultipleJournal extends Model
{
    protected $fillable = [
        'company_id',
        'journal_id',
        'multiple_journal_index',
        'deal_date',
        'debit_account_key',
        'debit_sub_account_key',
        'debit_amount',
        'credit_account_key',
        'credit_sub_account_key',
        'credit_amount',
        'remark',
    ];

    public function journal()
    {
        return $this->belongsTo('App\Models\Journal');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
