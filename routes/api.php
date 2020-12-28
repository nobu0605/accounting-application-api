<?php
use Illuminate\Http\Request;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'UserController@getUser')
    ->name('user');
    Route::get('/company', 'CompanyController@getCompany')
    ->name('company');
});

Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/register', 'Auth\RegisterController@register')->name('register');
