<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Company extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'industry_class',
        'number_of_employees',
        'fiscal_start_date',
        'fiscal_end_date',
        'founded_date',
    ];
}
