<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorVerificationMail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;

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
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->google2fa_enable) {
            $google2fa = new Google2FA();

            if ($request->session()->has('2fa_passed')) {
                $request->session()->forget('2fa_passed');
            }

            $request->session()->put('2fa:user:id', $user->id);
            $request->session()->put('2fa:auth:attempt', true);
            $request->session()->put('2fa:auth:remember', $request->has('remember'));

            $otp_secret = $user->google2fa_secret;
            $one_time_password = $google2fa->getCurrentOtp($otp_secret);
            $user->update(['google2fa_authenticated' => false]);

            Mail::to($user->email)->send(new TwoFactorVerificationMail($user, $one_time_password));

            return redirect()->route('2fa')->with('one_time_password', $one_time_password);
        }

        return redirect()->route('dashboard');
    }


    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // Remove the session variable to prevent skipping 2FA for subsequent requests
        $request->session()->forget('skip2fa');

        return redirect()->route('login');
    }

}
