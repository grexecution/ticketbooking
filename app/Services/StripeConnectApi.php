<?php

namespace App\Services;

use App\Models\User\User;
use Stripe\Collection;
use Stripe\PaymentIntent;
use Stripe\StripeClient;

class StripeConnectApi
{
    protected StripeClient $stripe;

    public function getStripeClient(): StripeClient
    {
        return $this->stripe;
    }

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

    public function handlePayment(string $accountId, float $amount, string $paymentMethodId) : PaymentIntent
    {
        // Amount in cents
        $amount = $amount * 100;
        // Calculate 2% application fee
        $applicationFeeAmount = round($amount * 0.02);

        $data = [
            'amount' => $amount,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
            'application_fee_amount' => $applicationFeeAmount,
            'confirmation_method' => 'automatic',
            'payment_method' => $paymentMethodId,
            'confirm' => true,
            'transfer_data' => [
                'destination' => $accountId,
            ],
        ];

        return $this->stripe->paymentIntents->create($data);
//        return $this->stripe->paymentIntents->retrieve($paymentIntent->id);
    }

}
