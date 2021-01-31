<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function getAllAccounts(int $companyId): object
    {
        $accounts = Account::select(
            'id',
            'name',
            'company_id',
            'account_key',
            'classification',
            'is_default_account'
        )
        ->where('company_id', $companyId)
        ->orderBy('classification', 'asc')
        ->get();

        return $this->jsonResponse($accounts);
    }

    public function registerAccount(Request $request): object
    {
        try {
            $existingAccount = Account::select(
                'company_id',
                'account_key',
            )
            ->where('company_id', $request['company_id'])
            ->where('account_key', $request['account_key'])
            ->get();

            if (count($existingAccount) > 0) {
                return response([
                    'message' => 'This account is already registered.',
                    'isDuplicate' => true
                ], 400);
            }
            
            Account::create([
                'company_id' => $request['company_id'],
                'name' => $request['name'],
                'account_key' => $request['account_key'],
                'classification' => $request['classification'],
                'is_default_account' => false
            ]);
            return response([
                'message' => 'Registered successfully.'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response([
                'message' => 'Internal server error.'
            ], 500);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $account = Account::find($request['id']);
            $account->delete();
            return response([
                'message' => 'Deleted successfully.'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response([
                'message' => 'Internal server error.'
            ], 500);
        }
    }
}
