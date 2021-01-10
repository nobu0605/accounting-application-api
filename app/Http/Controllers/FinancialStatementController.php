<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\MultipleJournal;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use App\Models\Company;

class FinancialStatementController extends Controller
{
    private function getAccountAmounts(string $side, int $companyId): array
    {
        $company = Company::select('fiscal_start_date', 'fiscal_end_date')
        ->where('id', $companyId)
        ->first();

        $accounts = Account::select('name', 'account_key', 'classification')
        ->where('company_id', $companyId)
        ->get();

        $accountsAmounts = [];
        foreach ($accounts as $account) {
            $accountsAmounts[$account->account_key] =
                array(
                    'account_key' => $account->account_key,
                    'classification' => $account->classification,
                    'amount' => 0
                );
        }
        
        $subQuery = Journal::from('journals as j')
        ->select(
            "j.{$side}_amount",
            "j.{$side}_account_key",
            'a.classification'
        )
        ->leftjoin('accounts as a', "j.{$side}_account_key", '=', 'a.account_key')
        ->where('j.company_id', $companyId)
        ->where('a.company_id', $companyId)
        ->whereBetween('deal_date', [$company->fiscal_start_date, $company->fiscal_end_date]);

        $journals = MultipleJournal::from('multiple_journals as m')
        ->select(
            "m.{$side}_amount",
            "m.{$side}_account_key",
            'a.classification'
        )
        ->leftjoin('accounts as a', "m.{$side}_account_key", '=', 'a.account_key')
        ->where('m.company_id', $companyId)
        ->where('a.company_id', $companyId)
        ->whereBetween('deal_date', [$company->fiscal_start_date, $company->fiscal_end_date])
        ->UnionAll($subQuery);

        $totalAmounts = DB::query()->fromSub($journals, 'journals')
        ->select("{$side}_account_key as account_key", 'classification', DB::raw("SUM({$side}_amount) as amount"))
        ->groupBy("{$side}_account_key")
        ->get();

        foreach ($totalAmounts as $eachAmounts) {
            $accountsAmounts[$eachAmounts->account_key]['amount'] = (int)$eachAmounts->amount;
        };
        
        return $accountsAmounts;
    }

    private function calculateActualAmounts(array $targetAmounts, array $amountsToDeduct, string $side): array
    {
        $class = [
            'debit' => [
                'current_assets',
                'non_current_assets',
                'cost_of_goods_sold',
                'selling_general_admin_expenses',
                'non_operating_expenses',
                'special_expenses',
                'income_taxes'
            ],
            'credit' => [
                'sales',
                'current_liabilities',
                'non_current_liabilities',
                'equity',
                'special_income',
                'non_operating_income'
            ],
        ];

        $classAmounts = [];
        foreach ($targetAmounts as $eachTargetAmount) {
            if (in_array($eachTargetAmount['classification'], $class[$side])) {
                $amount = $eachTargetAmount['amount'] - $amountsToDeduct[$eachTargetAmount['account_key']]['amount'];
                
                $classIndex = $eachTargetAmount['classification'] . '_total';
                if (!isset($classAmounts[$classIndex])) {
                    $classAmounts[$classIndex] = 0;
                }
                $classAmounts[$classIndex] = $classAmounts[$classIndex] + $amount;

                if ($amount === 0) {
                    continue;
                };
                
                $classAmounts[$eachTargetAmount['classification']][] =
                    array(
                        'account_key' => $eachTargetAmount['account_key'],
                        'classification' => $eachTargetAmount['classification'],
                        'amount' => $amount
                    );
            }
        }

        return $classAmounts;
    }

    public function getFinancialStatement(int $companyId)
    {
        $debitTotalAmounts = $this->getAccountAmounts('debit', $companyId);
        $creditTotalAmounts = $this->getAccountAmounts('credit', $companyId);
        
        $actualDebitAmounts = $this->calculateActualAmounts($debitTotalAmounts, $creditTotalAmounts, 'debit');
        $actualCreditAmounts = $this->calculateActualAmounts($creditTotalAmounts, $debitTotalAmounts, 'credit');
      
        // PL
        $grossProfit = $actualCreditAmounts['sales_total'] - $actualDebitAmounts['cost_of_goods_sold_total'];
        $operatingIncome = $grossProfit - $actualDebitAmounts['selling_general_admin_expenses_total'];
        $ordinaryIncome = $operatingIncome -
                    $actualDebitAmounts['non_operating_expenses_total'] +
                    $actualCreditAmounts['non_operating_income_total'];
        $incomeBeforeIncomeTaxes = $ordinaryIncome -
                    $actualDebitAmounts['special_expenses_total'] +
                    $actualCreditAmounts['special_income_total'];
        $netIncome = $incomeBeforeIncomeTaxes - $actualDebitAmounts['income_taxes_total'];

        // BS
        $assetsTotalAmount = $actualDebitAmounts['current_assets_total'] + $actualDebitAmounts['non_current_assets_total'];
        $liabilitiesTotalAmount = $actualCreditAmounts['current_liabilities_total'] + $actualCreditAmounts['non_current_liabilities_total'];
        $liabilitiesAndEquityTotalAmount = $liabilitiesTotalAmount + $actualCreditAmounts['equity_total'] + $netIncome;

        $actualAmounts = array_merge($actualDebitAmounts, $actualCreditAmounts);

        return [
            'assets_total_amount' => $assetsTotalAmount,
            'liabilities_total_amount' => $liabilitiesTotalAmount,
            'liabilities_and_equity_total_amount' => $liabilitiesAndEquityTotalAmount,
            'gross_profit' => $grossProfit,
            'operating_income' => $operatingIncome,
            'ordinary_income' => $ordinaryIncome,
            'income_before_income_taxes' => $incomeBeforeIncomeTaxes,
            'net_income' => $netIncome,
            'account_amounts' => $actualAmounts
        ];
    }
}
