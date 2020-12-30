<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Account;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllJournals(int $companyId)
    {
        $journals = Journal::where('company_id', $companyId)
            ->orderBy('deal_date', 'desc')
            ->get();
        $accounts = Account::where('company_id', $companyId)
            ->get()
            ->toArray();
        $accountKeys = array_column($accounts, 'account_key');
        
        foreach ($journals as $journal) {
            $debitAccountKey = array_search($journal['debit_account_key'], $accountKeys);
            $creditAccountKey = array_search($journal['credit_account_key'], $accountKeys);

            $allJournals[] = [
                'id'  => $journal['id'],
                'company_id'  => $journal['company_id'],
                'deal_date'  => $journal['deal_date'],
                'debit_account_name'  => $accounts[$debitAccountKey]['name'],
                'is_default_account_debit'  => (boolean)$accounts[$debitAccountKey]['is_default_account'],
                'debit_account_key'  => $journal['debit_account_key'],
                'debit_sub_account_key'  => $journal['debit_sub_account_key'],
                'debit_amount'  => $journal['debit_amount'],
                'credit_account_name'  => $accounts[$creditAccountKey]['name'],
                'is_default_account_credit'  => (boolean)$accounts[$creditAccountKey]['is_default_account'],
                'credit_account_key'  => $journal['credit_account_key'],
                'credit_sub_account_key'  => $journal['credit_sub_account_key'],
                'credit_amount'  => $journal['credit_amount'],
                'remark'  => $journal['remark'],
                'is_multiple_journal'  => (boolean)$journal['is_multiple_journal'],
            ];
        }
        
        return $this->jsonResponse($allJournals);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Journal $journal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Journal  $journal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
