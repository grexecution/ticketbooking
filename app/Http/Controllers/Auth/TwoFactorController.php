<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorVerificationMail;
use App\Models\User\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    use RedirectsUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        if (auth()->user()->google2fa_authenticated) {
            return redirect()->route('dashboard');
        }
        return view('auth.2fa');
    }

    /**
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     * @throws ValidationException
     * @throws SecretKeyTooShortException
     */
    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|string',
        ]);

        $user_id = $request->session()->get('2fa:user:id');
        $remember = $request->session()->get('2fa:auth:remember', false);
        $attempt = $request->session()->get('2fa:auth:attempt', false);
        if (!$user_id || !$attempt) {
            return redirect()->route('login');
        }

        $user = User::find($user_id);
        if (!$user || !$user->google2fa_enable) {
            return redirect()->route('login');
        }

        $google2fa = new Google2FA();
        $otp_secret = $user->google2fa_secret;

        if (!$google2fa->verifyKey($otp_secret, $request->one_time_password)) {
            throw ValidationException::withMessages([
                'one_time_password' => [__('The one time password is invalid.')],
            ]);
        }

        $request->session()->remove('2fa:user:id');
        $request->session()->remove('2fa:auth:remember');
        $request->session()->remove('2fa:auth:attempt');

        $user->update(['google2fa_authenticated' => true]);

        return redirect()->route('dashboard');
    }

    public function resendCode(Request $request) {
        $user = auth()->user();

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

            return redirect()->route('2fa')->with('resent', true);
        }

        return redirect()->route('dashboard');
    }

}
