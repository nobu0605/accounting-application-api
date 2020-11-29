<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Auth\AuthManager;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    private $authManager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
        $this->middleware('guest')->except('logout');
    }

    protected function index(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken("Token User ID $user->id")->accessToken;
            return ['token' => $token];
        }

        return response([
            'message' => 'Unauthenticated.'
        ], 401);
    }
}
