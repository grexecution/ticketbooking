<?php

namespace App\Services;

use App\Models\User\User;
use Stripe\Collection;
use Stripe\StripeClient;

class StripeConnectApi
{
    protected StripeClient $stripe;

    public function __construct()
    {
        $secret = config('services.stripe_connect.secret');
        $this->stripe = new StripeClient($secret);
    }

    public function checkConnection(string $accountId) : bool
    {
        try {
            $this->stripe->accounts->retrieve($accountId);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function listAccounts() : Collection
    {
        return $this->stripe->accounts->all();
    }

    public function createAccount(User $user) : string
    {
        $account = $this->stripe->accounts->create([
            'type' => 'standard',
            'country' => 'US',
            'email' => $user->email,
        ]);

        $user->tenant()->update(['stripe_account_id' => $account->id]);

        return $account->id;
    }

    public function listAccountLinks() : Collection
    {
        return $this->stripe->accountLinks->all();
    }

    public function createAccountLink(string $accountId) : string
    {
        $accountLink = $this->stripe->accountLinks->create([
            'account' => $accountId,
            'refresh_url' => route('settings') . '?error=stripe_refresh',  // critical error
            'return_url' => route('settings') . '?error=stripe_return',    // unfinished flow
            'type' => 'account_onboarding',
        ]);

        return $accountLink->url;
    }

}
