<?php

namespace App\Helpers;

use App\Models\Account;
use App\Models\Journal;
use App\Models\MultipleJournal;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Carbon\Carbon;

class AccountAmount
{
    private function getAccountAmount(string $side, int $companyId, string $accountKey): ?object
    {
        $company = Company::select('fiscal_start_date', 'fiscal_end_date')
        ->where('id', $companyId)
        ->first();

        $accounts = Account::select('name', 'account_key', 'classification')
        ->where('company_id', $companyId)
        ->get();
       
        $subQuery = Journal::from('journals as j')
        ->select(
            "j.{$side}_amount",
            "j.{$side}_account_key",
            'a.classification'
        )
        ->leftjoin('accounts as a', "j.{$side}_account_key", '=', 'a.account_key')
        ->where('j.company_id', $companyId)
        ->where('a.company_id', $companyId)
        ->where('a.account_key', $accountKey)
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
        ->where('a.account_key', $accountKey)
        ->whereBetween('deal_date', [$company->fiscal_start_date, $company->fiscal_end_date])
        ->UnionAll($subQuery);

        $accountAmount = DB::query()->fromSub($journals, 'journals')
        ->select("{$side}_account_key as account_key", 'classification', DB::raw("SUM({$side}_amount) as amount"))
        ->groupBy("{$side}_account_key")
        ->first();

        return $accountAmount;
    }

    public function getActualAccountAmount(int $companyId, string $accountKey, string $sideOfAccount): int
    {
        $debitAccountAmount = is_null($this->getAccountAmount('debit', $companyId, $accountKey))
            ? 0
            : $this->getAccountAmount('debit', $companyId, $accountKey)->amount;
        $creditAccountAmount = is_null($this->getAccountAmount('credit', $companyId, $accountKey))
            ? 0
            : $this->getAccountAmount('credit', $companyId, $accountKey)->amount;

        $actualAccountAmount = 0;
        if ($sideOfAccount === 'debit') {
            $actualAccountAmount = $debitAccountAmount - $creditAccountAmount;
            return $actualAccountAmount;
        }
        $actualAccountAmount = $creditAccountAmount - $debitAccountAmount;
        return $actualAccountAmount;
    }

    private function getEachMonthAccountAmounts(string $side, int $companyId, string $accountKey, string $currentMonth): array
    {
        $company = Company::select('fiscal_start_date', 'fiscal_end_date')
        ->where('id', $companyId)
        ->first();

        $endOfTerm = date('Y', strtotime($company->fiscal_end_date)) . "-$currentMonth";
        $endOfTerm = Carbon::parse($endOfTerm)->endOfMonth()->toDateString();

        $fiscalStartDate = new Carbon($company->fiscal_start_date);
        $targetTerm = $company->fiscal_start_date;

        $totalAmounts = 0;
        $monthAccountAmounts = [];
        for ($i=0; $targetTerm < $endOfTerm; $i++) {
            $targetTerm = $fiscalStartDate->copy()->addMonth($i)->endOfMonth()->toDateString();

            $accounts = Account::select('name', 'account_key', 'classification')
                ->where('company_id', $companyId)
                ->get();
       
            $subQuery = Journal::from('journals as j')
                ->select(
                    "j.{$side}_amount",
                    "j.{$side}_account_key",
                    'a.classification'
                )
                ->leftjoin('accounts as a', "j.{$side}_account_key", '=', 'a.account_key')
                ->where('j.company_id', $companyId)
                ->where('a.company_id', $companyId)
                ->where('a.account_key', $accountKey)
                ->whereBetween('deal_date', [$company->fiscal_start_date,$targetTerm ]);

            $journals = MultipleJournal::from('multiple_journals as m')
                ->select(
                    "m.{$side}_amount",
                    "m.{$side}_account_key",
                    'a.classification'
                )
                ->leftjoin('accounts as a', "m.{$side}_account_key", '=', 'a.account_key')
                ->where('m.company_id', $companyId)
                ->where('a.company_id', $companyId)
                ->where('a.account_key', $accountKey)
                ->whereBetween('deal_date', [$company->fiscal_start_date, $targetTerm])
                ->UnionAll($subQuery);

            $totalAmounts = DB::query()->fromSub($journals, 'journals')
                ->select("{$side}_account_key as account_key", 'classification', DB::raw("SUM({$side}_amount) as amount"))
                ->groupBy("{$side}_account_key")
                ->first();
            
            $monthAccountAmounts[] = array(
                'amount' => is_null($totalAmounts) ? 0 : (int)$totalAmounts->amount,
                'month' => $targetTerm
            );
        }
        
        return $monthAccountAmounts;
    }

    private function getActualMonthAccountAmounts(array $debitAccountAmounts, array $creditAccountAmounts, string $sideOfAccount): array
    {
        $actualAccountAmounts = [];
        if ($sideOfAccount === 'debit') {
            foreach ($debitAccountAmounts as $index => $debitAccountAmount) {
                $actualAccountAmounts[] = array(
                    'amount' => $debitAccountAmount['amount'] - $creditAccountAmounts[$index]['amount'],
                    'month' => date('Y-m', strtotime($debitAccountAmount['month']))
                );
            }
            return $actualAccountAmounts;
        }
        foreach ($creditAccountAmounts as $index => $creditAccountAmount) {
            $actualAccountAmounts[] = array(
                'amount' => $creditAccountAmount['amount'] - $debitAccountAmounts[$index]['amount'],
                'month' => date('Y-m', strtotime($creditAccountAmount['month']))
            );
        }
        return $actualAccountAmounts;
    }

    public function getMonthAccountAmounts(int $companyId, string $accountKey, string $sideOfAccount): array
    {
        $currentMonth = date("m");
        $debitAccountAmounts = $this->getEachMonthAccountAmounts('debit', $companyId, $accountKey, $currentMonth);
        $creditAccountAmounts = $this->getEachMonthAccountAmounts('credit', $companyId, $accountKey, $currentMonth);
        $actualAccountAmounts = $this->getActualMonthAccountAmounts($debitAccountAmounts, $creditAccountAmounts, $sideOfAccount);

        return $actualAccountAmounts;
    }
}
