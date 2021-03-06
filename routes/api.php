<?php
use Illuminate\Http\Request;

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'UserController@getUser')
    ->name('user');
    Route::get('company', 'CompanyController@getCompany')
    ->name('company');
    Route::get('journals/{company_id}', 'JournalController@getAllJournals')
    ->name('journals');
    Route::post('journals/new', 'JournalController@registerJournal')
    ->name('journals/new');
    Route::delete('journals/{id}', 'JournalController@deleteJournal')
    ->name('journals');
    Route::get('accounts/{company_id}', 'AccountController@getAllAccounts')
    ->name('accounts');
    Route::post('accounts/new', 'AccountController@registerAccount')
    ->name('accounts/new');
    Route::delete('accounts/{id}', 'AccountController@deleteAccount')
    ->name('accounts');
    Route::get('report/{company_id}', 'ReportController@getFinancialStatementRatios')
    ->name('report');
    Route::get('financial-statement/{company_id}', 'FinancialStatementController@getFinancialStatement')
    ->name('financial-statement');
    Route::get('home/{company_id}', 'HomeController@getCashEquivalentAccounts')
    ->name('home');
});

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/register', 'Auth\RegisterController@register')->name('register');
