<?php

namespace App\Services;

use App\Models\StripeCallback;
use App\Models\Tenant;
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
            $account = $this->stripe->accounts->retrieve($accountId);

            StripeCallback::query()->create([
                'user_id' => auth()?->id(),
                'endpoint' => '/v1/accounts/' . $accountId,
                'payload' => $accountId,
                'response' => $account,
            ]);

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
        $payload = [
            'type' => 'standard',
            'country' => 'AT',  // Austria country code
            'email' => $user->email,
        ];

        $account = $this->stripe->accounts->create($payload);

        StripeCallback::query()->create([
            'user_id' => auth()?->id(),
            'endpoint' => '/v1/accounts',
            'payload' => $payload,
            'response' => $account,
        ]);

        $user->tenant()->update(['stripe_account_id' => $account->id]);

        return $account->id;
    }

    public function listAccountLinks() : Collection
    {
        return $this->stripe->accountLinks->all();
    }

    public function createAccountLink(string $accountId, ?Tenant $tenant = null) : string
    {
        $refreshRoute = $tenant ? route('tenants.edit', $tenant->id) : route('settings');
        $returnRoute = $tenant ? route('tenants.edit', $tenant->id) : route('settings');

        $payload = [
            'account' => $accountId,
            'refresh_url' => $refreshRoute . '?error=stripe_refresh',  // critical error
            'return_url' => $returnRoute . '?error=stripe_return',     // unfinished flow
            'type' => 'account_onboarding',
        ];

        $accountLink = $this->stripe->accountLinks->create($payload);

        StripeCallback::query()->create([
            'user_id' => auth()?->id(),
            'endpoint' => '/v1/account_links',
            'payload' => $payload,
            'response' => $accountLink,
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

    /**
     * @throws \Exception
     */
    public function refundPayment(string $paymentIntentId): \Stripe\Refund
    {
        try {
            $refund = $this->stripe->refunds->create([
                'payment_intent' => $paymentIntentId,
            ]);

            StripeCallback::query()->create([
                'user_id' => auth()?->id(),
                'endpoint' => '/v1/refunds',
                'payload' => ['payment_intent' => $paymentIntentId],
                'response' => $refund,
            ]);

            return $refund;
        } catch (\Exception $e) {
            throw new \Exception('Refund failed: ' . $e->getMessage());
        }
    }
}
