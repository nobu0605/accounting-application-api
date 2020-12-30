<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubAccount extends Model
{
    public $table = 'sub_accounts';

    protected $fillable = [
        'account_id',
        'name',
        'sub_account_key'
    ];
    
    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }
}
