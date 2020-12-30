<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Helpers\DefaultAccounts;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function register(Request $request)
    {
        try {
            $company = Company::create([
                'name' => $request['company_name'],
                'industry_class' => $request['industry_class'],
                'number_of_employees' => $request['number_of_employees'],
                'fiscal_start_date' => $request['fiscal_start_date'],
                'fiscal_end_date' => $request['fiscal_end_date'],
                'founded_date' => $request['founded_date'],
            ]);
            User::create([
                'company_id' => $company->id,
                'name' => $request['user_name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            DefaultAccounts::createDefaultAccounts($company->id);

            return response([
                'message' => 'Registered successfully.'
            ], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return response([
                    'message' => 'Duplicate Entry.',
                    'isDuplicate' => true,
                ], 500);
                ;
            }
            return response([
                    'message' => 'Internal server error.'
                ], 500);
            ;
        }
    }
}
