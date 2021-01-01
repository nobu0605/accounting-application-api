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
    Route::get('accounts/{company_id}', 'AccountController@getAllAccounts')
    ->name('accounts');
});

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/register', 'Auth\RegisterController@register')->name('register');
