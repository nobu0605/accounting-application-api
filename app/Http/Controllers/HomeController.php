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
    public function getCashAccounts(int $companyId)
    {
        $accountAmount = new AccountAmount;
        $cashAmount = $accountAmount->getActualAccountAmount($companyId, 'cash', 'debit');
        $savingsAccountsAmount = $accountAmount->getActualAccountAmount($companyId, 'savings_accounts', 'debit');
        $checkingAccountsAmount = $accountAmount->getActualAccountAmount($companyId, 'checking_accounts', 'debit');
        $totalCashAmount = $cashAmount + $savingsAccountsAmount + $checkingAccountsAmount;
        
        $cashEachMonthAmounts = $accountAmount->getMonthAccountAmounts($companyId, 'cash', 'debit');
        $savingsAccountsEachMonthAmounts = $accountAmount->getMonthAccountAmounts($companyId, 'savings_accounts', 'debit');
        $checkingAccountsEachMonthAmounts = $accountAmount->getMonthAccountAmounts($companyId, 'checking_accounts', 'debit');

        $totalCashEachMonthAmounts = [array('', '')];
        foreach ($cashEachMonthAmounts as $index => $cashEachMonthAmount) {
            $totalCashEachMonthAmounts[] = array(
                date('Y-m', strtotime($cashEachMonthAmount['month'])),
                $cashEachMonthAmount['amount'] +
                $savingsAccountsEachMonthAmounts[$index]['amount'] +
                $checkingAccountsEachMonthAmounts[$index]['amount']
            );
        }

        return [
            'cash' => $cashAmount,
            'savings_accounts_amount' => $savingsAccountsAmount,
            'total_cash_amount' => $totalCashAmount,
            'checking_accounts_amount' => $checkingAccountsAmount,
            'total_cash_each_month_amounts' => $totalCashEachMonthAmounts
        ];
    }
}
