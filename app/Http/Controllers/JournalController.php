<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\MultipleJournal;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllJournals(int $companyId)
    {
        $subQuery = Journal::from('journals as j')
        ->select(
            'j.id',
            'j.company_id',
            'j.deal_date',
            'j.debit_account_key',
            'j.debit_sub_account_key',
            'j.debit_amount',
            'j.credit_account_key',
            'j.credit_sub_account_key',
            'j.credit_amount',
            'j.remark',
            DB::raw('1 as multiple_journal_index'),
            DB::raw('false as is_multiple_journal')
        )
        ->where('company_id', $companyId);

        $journals = MultipleJournal::from('multiple_journals as m')
        ->select(
            'm.journal_id as id',
            'm.company_id',
            'm.deal_date',
            'm.debit_account_key',
            'm.debit_sub_account_key',
            'm.debit_amount',
            'm.credit_account_key',
            'm.credit_sub_account_key',
            'm.credit_amount',
            'm.remark',
            'm.multiple_journal_index',
            DB::raw('true as is_multiple_journal')
        )
        ->where('company_id', $companyId)
        ->UnionAll($subQuery)
        ->orderBy('deal_date', 'desc')
        ->orderBy('id', 'asc')
        ->orderBy('multiple_journal_index', 'asc')
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
    public function registerJournal(Request $request)
    {
        try {
            $journal =  Journal::create([
                'company_id' => $request['journal']['company_id'],
                'deal_date' => $request['journal']['deal_date'],
                'debit_account_key' => $request['journal']['debit_account_key'],
                'debit_sub_account_key' => $request['journal']['debit_sub_account_key'],
                'debit_amount' => $request['journal']['debit_amount'],
                'credit_account_key' => $request['journal']['credit_account_key'],
                'credit_sub_account_key' => $request['journal']['credit_sub_account_key'],
                'credit_amount' => $request['journal']['credit_amount'],
                'remark' => $request['journal']['remark'],
                'has_multiple_journal' => $request['journal']['has_multiple_journal'],
            ]);
            if ($request['multiple_journals']) {
                foreach ($request['multiple_journals'] as $multiple_journal) {
                    MultipleJournal::create([
                        'company_id' => $multiple_journal['company_id'],
                        'journal_id' => $journal->id,
                        'multiple_journal_index' => $multiple_journal['multiple_journal_index'],
                        'deal_date' => $request['journal']['deal_date'],
                        'debit_account_key' => $multiple_journal['debit_account_key'],
                        'debit_sub_account_key' => $multiple_journal['debit_sub_account_key'],
                        'debit_amount' => $multiple_journal['debit_amount'],
                        'credit_account_key' => $multiple_journal['credit_account_key'],
                        'credit_sub_account_key' => $multiple_journal['credit_sub_account_key'],
                        'credit_amount' => $multiple_journal['credit_amount'],
                        'remark' => $multiple_journal['remark'],
                    ]);
                }
            };
            return response([
            'message' => 'Registered successfully.'
        ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response([
                'message' => 'Internal server error.'
            ], 500);
            ;
        }
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
