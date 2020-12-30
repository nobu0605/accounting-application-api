<?php

namespace App\Helpers;

use App\Models\Account;

class DefaultAccounts
{
    public static function createDefaultAccounts(int $companyId)
    {
        foreach (config('constants.DEFAULT_ACCOUNTS') as $account) {
            $defaultAccounts = Account::create([
                'company_id' => $companyId,
                'name' => $account['name'],
                'account_key' => $account['account_key'],
                'classification' => $account['classification'],
                'is_default_account' => true,
            ]);
        }
    }
}
