<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request): object
    {
        $companyId = $request->user()->company_id;
        $result = Company::find($companyId);
        $company = [
            "id" => $result->id,
            "name" => $result->name,
            "industry_class" => $result->industry_class,
            "number_of_employees" => $result->number_of_employees,
            "founded_date" => $result->founded_date,
            "fiscal_start_date" => $result->fiscal_start_date,
            "fiscal_end_date" => $result->fiscal_end_date,
            "accounting_term" => $result->accounting_term,
        ];
        $user = [
            "id" => $request->user()->id,
            "name" => $request->user()->name,
            "company" => $company
        ];
        
        return $this->jsonResponse($user);
    }
}
