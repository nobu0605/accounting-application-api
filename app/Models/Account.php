<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'account_key',
        'classification',
        'is_default_account'
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function subAccounts()
    {
        return $this->hasMany('App\Models\SubAccount');
    }
}
