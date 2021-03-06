<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    $amount = $faker->numberBetween(1000, 200000);
    $defaultAccounts = config('constants.DEFAULT_ACCOUNTS');
    $debitDefaultAccounts = $faker->shuffleArray($defaultAccounts);
    $creditDefaultAccounts = $faker->shuffleArray($defaultAccounts);

    return [
        'company_id'  => 1,
        'deal_date'  => $faker->dateTime,
        'debit_account_key'  => $debitDefaultAccounts[0]['account_key'],
        'debit_sub_account_key'  => $faker->company,
        'debit_amount'  => $amount,
        'credit_account_key'  => $creditDefaultAccounts[0]['account_key'],
        'credit_sub_account_key'  => $faker->company,
        'credit_amount'  => $amount,
        'remark'  => $faker->word,
        'has_multiple_journal'  => false,
    ];
});
