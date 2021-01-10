<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use App\Models\MultipleJournal;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class ReportController extends Controller
{
    private function getClassAmounts(string $side, int $companyId): array
    {
        $classificationAmounts = [
            'sales' => 0,
            'cost_of_goods_sold' => 0,
            'selling_general_admin_expenses' => 0,
            'non_operating_income' => 0,
            'non_operating_expenses' => 0,
            'special_income' => 0,
            'special_expenses' => 0,
            'current_assets' => 0,
            'non_current_assets' => 0,
            'current_liabilities' => 0,
            'non_current_liabilities' => 0,
            'equity' => 0
        ];

        $company = Company::select('fiscal_start_date', 'fiscal_end_date')
        ->where('id', $companyId)
        ->first();

        $subQuery = Journal::from('journals as j')
        ->select(
            "j.{$side}_amount",
            'a.classification'
        )
        ->leftjoin('accounts as a', "j.{$side}_account_key", '=', 'a.account_key')
        ->where('j.company_id', $companyId)
        ->where('a.company_id', $companyId)
        ->whereBetween('deal_date', [$company->fiscal_start_date, $company->fiscal_end_date]);

        $journals = MultipleJournal::from('multiple_journals as m')
        ->select(
            "m.{$side}_amount",
            'a.classification'
        )
        ->leftjoin('accounts as a', "m.{$side}_account_key", '=', 'a.account_key')
        ->where('m.company_id', $companyId)
        ->where('a.company_id', $companyId)
        ->whereBetween('deal_date', [$company->fiscal_start_date, $company->fiscal_end_date])
        ->UnionAll($subQuery);

        $totalAmounts = DB::query()->fromSub($journals, 'journals')
        ->select('classification', DB::raw("SUM({$side}_amount) as amount"))
        ->groupBy('classification')
        ->get();

        foreach ($totalAmounts as $eachAmounts) {
            $classificationAmounts[$eachAmounts->classification] = $eachAmounts->amount;
        };
        
        return $classificationAmounts;
    }

    private function calculateActualAmounts(array $targetAmounts, array $amountsToDeduct, string $side): array
    {
        $classifications = [
            'debit' => [
                'current_assets',
                'non_current_assets',
                'cost_of_goods_sold',
                'selling_general_admin_expenses',
                'non_operating_expenses',
                'special_expenses'
            ],
            'credit' => [
                'sales',
                'current_liabilities',
                'non_current_liabilities',
                'equity'
            ],
        ];

        $actualAmounts = [];
        foreach ($classifications[$side] as $classification) {
            $actualAmounts[$classification] = $targetAmounts[$classification] - $amountsToDeduct[$classification];
        }

        return $actualAmounts;
    }

    private function calculateRatio(array $actualAmounts, string $targetClass): array
    {
        $classifications = [
            'assets' => [
                'current_assets',
                'non_current_assets',
            ],
            'income_statement' => [
                'cost_of_goods_sold',
                'selling_general_admin_expenses',
                'operating_income'
            ],
            'liabilities_and_equity' => [
                'current_liabilities',
                'non_current_liabilities',
                'equity'
            ],
        ];

        $totalAmount = 0;
        foreach ($classifications[$targetClass] as $classification) {
            $totalAmount = $totalAmount + $actualAmounts[$classification];
        };
        $ratios = [];
        foreach ($classifications[$targetClass] as $classification) {
            $ratios[$classification] = round($actualAmounts[$classification] / $totalAmount, 2);
        };

        return $ratios;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFinancialStatementRatios(int $companyId): object
    {
        $debitTotalAmounts = $this->getClassAmounts('debit', $companyId);
        $creditTotalAmounts = $this->getClassAmounts('credit', $companyId);
        
        $actualDebitAmounts = $this->calculateActualAmounts($debitTotalAmounts, $creditTotalAmounts, 'debit');
        $actualCreditAmounts = $this->calculateActualAmounts($creditTotalAmounts, $debitTotalAmounts, 'credit');

        $assetsRatios = $this->calculateRatio($actualDebitAmounts, 'assets');
        $liabilitiesAndEquityRatios = $this->calculateRatio($actualCreditAmounts, 'liabilities_and_equity');
        $operatingIncome = $actualCreditAmounts['sales'] -
            $actualDebitAmounts['cost_of_goods_sold'] -
            $actualDebitAmounts['selling_general_admin_expenses'];
        $actualDebitAmounts['operating_income'] = $operatingIncome;
        $incomeStatementRatios = $this->calculateRatio($actualDebitAmounts, 'income_statement');
        
        return $this->jsonResponse([
            'current_assets_ratio' => $assetsRatios['current_assets'],
            'non_current_assets_ratio' => $assetsRatios['non_current_assets'],
            'current_liabilities_ratio' => $liabilitiesAndEquityRatios['current_liabilities'],
            'non_current_liabilities_ratio' => $liabilitiesAndEquityRatios['non_current_liabilities'],
            'equity_ratio' => $liabilitiesAndEquityRatios['equity'],
            'cost_of_goods_sold_ratio' => $incomeStatementRatios['cost_of_goods_sold'],
            'selling_general_admin_expenses_ratio' => $incomeStatementRatios['selling_general_admin_expenses'],
            'operating_income_ratio' => $incomeStatementRatios['operating_income']
        ]);
    }
}
