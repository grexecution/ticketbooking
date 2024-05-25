@extends('layouts.site')

@section('title', 'Checkout 2 Step')

@section('content')
    <!-- Step 2: Pay -->
    <div class="container mt-5">
        <div class="step-indicator">
            <div class="active">1. Information</div>
            <div class="active">2. Pay</div>
            <div>3. Confirmation</div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <h4>Payment method</h4>
                <div class="payment-method">
                    <div class="selected">
                        <h5>Credit card</h5>
                        <img src="https://img.icons8.com/color/48/000000/visa.png"/>
                        <img src="https://img.icons8.com/color/48/000000/mastercard.png"/>
                        <img src="https://img.icons8.com/color/48/000000/discover.png"/>
                        <p>Pay via our payment partner Stripe</p>
                    </div>
                    <div>
                        <h5>Cash payment</h5>
                        <p>Tickets are paid for in cash on site</p>
                    </div>
                    <div class="disabled">
                        <h5>Bankomat</h5>
                        <p>Not available</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="order-summary">
                    <div class="ticket-warning">Your tickets are still available for: 09:48 min.</div>
                    <div class="mt-3">
                        <p>3 x Flo & Wipe “Humor Worms”</p>
                        <p>23.11.2023 | 20:00</p>
                        <p>Oggau, Burgenland</p>
                        <p>€65,00</p>
                    </div>
                    <hr>
                    <h5>In total: €120,00</h5>
                </div>
                <form action="{{ route('checkout.step3') }}" method="get">
                    <button type="submit" class="btn btn-buy">Buy now</button>
                </form>
            </div>
        </div>
    </div>
@endsection
