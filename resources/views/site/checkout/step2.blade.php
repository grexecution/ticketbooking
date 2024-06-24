@extends('layouts.site')

@section('title', __('site.checkout_2_step'))

@section('content')
    <!-- Step 2: Pay -->
    <div class="py-5" style="background-color: #F1F5F8">
        <div class="container">
            <div class="step-indicator">
                <div class="d-flex justify-content-center align-items-center active">@lang('messages.information')</div>
                <div class="d-flex justify-content-center align-items-center active">@lang('messages.payment')</div>
                <div class="d-flex justify-content-center align-items-center">@lang('messages.confirmation')</div>
            </div>

            <div class="container card d-flex flex-col flex-md-row justify-content-between px-2 px-md-4 py-4 py-md-4">
                <div class="col-md-7">
                    <h4 class="checkout-subtitle">@lang('messages.payment_method')</h4>
                    <div class="d-flex payment-method gap-2">
                        <div class="payment-box selected d-flex flex-col justify-content-center align-items-center gap-1">
                            <img class="w-10 w-md-25" src="/img/cc-icon.png"/>
                            <h5 class="text-white">@lang('messages.credit_card')</h5>
                            <div class="d-flex flex-row justify-content-center">
                                <img src="https://img.icons8.com/color/48/000000/visa.png"/>
                                <img src="https://img.icons8.com/color/48/000000/mastercard.png"/>
                                <img src="https://img.icons8.com/color/48/000000/discover.png"/>
                            </div>

                            <p style="font-size: 14px; line-height: 14px; color: white">@lang('messages.pay_via_stripe')</p>
                        </div>
                        <div class="payment-box disabled">
                            <h5>@lang('messages.cash_payment')</h5>
                            <p>@lang('messages.not_available')</p>
                        </div>
                        <div class="payment-box disabled">
                            <h5>@lang('messages.bankomat')</h5>
                            <p>@lang('messages.not_available')</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 mt-4">
                    <order-summary
                        :action-url="'{{ route('checkout.step3') }}'"
                        :stripe-public-key="'{{ config('services.stripe_connect.key') }}'"
                        :is-payment-form="true"
                    /></order-summary>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
