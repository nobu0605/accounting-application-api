<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\MultipleJournal;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\Company;
use App\Helpers\AccountAmount;

class HomeController extends Controller
{
    public function getCashEquivalentAccounts(int $companyId): array
    {
        $accountAmount = new AccountAmount;
        $cashAmount = $accountAmount->getActualAccountAmount($companyId, 'cash', 'debit');
        $savingsAccountsAmount = $accountAmount->getActualAccountAmount($companyId, 'savings_accounts', 'debit');
        $checkingAccountsAmount = $accountAmount->getActualAccountAmount($companyId, 'checking_accounts', 'debit');
        $totalCashEquivalentAmount = $cashAmount + $savingsAccountsAmount + $checkingAccountsAmount;
        
        $cashEachMonthAmounts = $accountAmount->getMonthAccountAmounts($companyId, 'cash', 'debit');
        $savingsAccountsEachMonthAmounts = $accountAmount->getMonthAccountAmounts($companyId, 'savings_accounts', 'debit');
        $checkingAccountsEachMonthAmounts = $accountAmount->getMonthAccountAmounts($companyId, 'checking_accounts', 'debit');

        $totalCashEquivalentEachMonthAmounts = [array('', '')];
        foreach ($cashEachMonthAmounts as $index => $cashEachMonthAmount) {
            $totalCashEquivalentEachMonthAmounts[] = array(
                date('Y-m', strtotime($cashEachMonthAmount['month'])),
                $cashEachMonthAmount['amount'] +
                $savingsAccountsEachMonthAmounts[$index]['amount'] +
                $checkingAccountsEachMonthAmounts[$index]['amount']
            );
        }

        return [
            'cash' => $cashAmount,
            'savings_accounts_amount' => $savingsAccountsAmount,
            'checking_accounts_amount' => $checkingAccountsAmount,
            'total_cash_equivalent_amount' => $totalCashEquivalentAmount,
            'total_cash_equivalent_each_month_amounts' => $totalCashEquivalentEachMonthAmounts
        ];
    }
}
