<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'industry_class',
        'number_of_employees',
        'fiscal_start_date',
        'fiscal_end_date',
        'founded_date',
    ];

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\Account');
    }

    public function journals()
    {
        return $this->hasMany('App\Models\Journal');
    }

    public function multipleJournals()
    {
        return $this->hasMany('App\Models\MultipleJournal');
    }
}
