@extends('layouts.site')

@section('title', 'Checkout 2 Step')

@section('content')
    <!-- Step 2: Pay -->
<div class="py-5" style="background-color: #F1F5F8">
    <div class="container">
        <div class="step-indicator">
            <div class="active">1. Information</div>
            <div class="active">2. Payment</div>
            <div>3. Confirmation</div>
        </div>

        <div class="container card d-flex flex-row p-4">
            <div class="col-md-7">
                <h4 class="checkout-subtitle">Payment method</h4>
                <div class="d-flex payment-method gap-2">
                    <div class="payment-box selected d-flex flex-col justify-content-center align-items-center gap-1">
                        <img class="w-25" src="/img/cc-icon.png"/>
                        <h5 class="text-white">Credit card</h5>
                        <div class="d-flex flex-row justify-content-center">
                            <img src="https://img.icons8.com/color/48/000000/visa.png"/>
                            <img src="https://img.icons8.com/color/48/000000/mastercard.png"/>
                            <img src="https://img.icons8.com/color/48/000000/discover.png"/>
                        </div>
                        
                        <p style="font-size: 14px; line-height: 14px; color: white">Pay via our payment partner Stripe</p>
                    </div>
                    <div class="payment-box disabled">
                        <h5>Cash payment</h5>
                        <p>Tickets are paid for in cash on site</p>
                    </div>
                    <div class="payment-box disabled">
                        <h5>Bankomat</h5>
                        <p>Not available</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="order-summary">
                    <div class="ticket-warning">Tickets are still available for: 09:48 min.</div>
                    <div class="mt-3">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <p class="co-price-text">3 x Flo & Wisch “Humorwürmer”</p>
                                <p class="co-price-details">23.11.2023 | 20:00</p>
                                <p class="co-price-details">Oggau, Burgenland</p>
                                <p class="co-price-details">Category: A | Ticket: Regular</p>  
                            </div>
                          <p>€65,00</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <p class="co-price-text">1 x Flo & Wisch “Humorwürmer</p>
                                <p class="co-price-details">23.11.2023 | 20:00</p>
                                <p class="co-price-details">Oggau, Burgenland</p>  
                                <p class="co-price-details">Category: A | Ticket: Senior</p>  
                            </div>
                          <p>€65,00</p>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex flex-row justify-content-between">
                        <h5 style="font-weight:700">Total:</h5>
                        <h5 style="font-weight:700">€120,00</h5>
                    </div>
                    <form action="{{ route('checkout.step3') }}" method="get">
                    <button type="submit" class="btn btn-continue btn-block mt-3">Buy now</button>
                    </form>
                    <div class="d-flex justify-content-center">
                        <small class="text-secondary">Ticketpreise enthalten 13% Umsatzsteuer</small>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
