<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Services\StripeConnectApi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StripeConnectController extends Controller
{
    protected StripeConnectApi $api;

    public function __construct(StripeConnectApi $api)
    {
        $this->api = $api;
        $this->middleware(['auth', '2fa']);
    }

    public function connectAccount(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $accountId = $user->tenants?->stripe_account_id ?: $this->api->createAccount($user);
        $url = $this->api->createAccountLink($accountId);

        return redirect($url);
    }

    public function checkConnection(Request $request) : RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $connected = $this->api->checkConnection($user->tenant?->stripe_account_id);

        if (! $connected) {
            $user->tenant()->update(['stripe_connected' => false]);
            return redirect()->back()->with('error', 'Stripe is not connected!');
        }

        $user->tenant()->update(['stripe_connected' => true]);

        return redirect()->back()->with('success', 'Stripe successfully connected!');
    }

}
