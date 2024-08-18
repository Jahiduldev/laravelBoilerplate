<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;

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
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $url = '';
        if($request->user()->user_type === UserTypeEnum::ADMIN->value){
            $url = 'admin/dashboard';
        }elseif($request->user()->user_type === UserTypeEnum::VENDOR->value){
            $url = 'vendor/dashboard';
        }elseif($request->user()->user_type === UserTypeEnum::CUSTOMER->value){
            $url = '/dashboard';
        }
        $notification = array(
            'message' => 'Login Successfully done!.',
            'alert-type' => 'success',
        );
        return redirect()->intended($url)->with($notification);
    }
}
