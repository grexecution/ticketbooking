@extends('layouts.site')

@section('title', 'Checkout 1 Step')

@section('content')
    <!-- Step 1: Information -->
<div class="py-5" style="background-color: #F1F5F8">
    <div class="container">
        <div class="step-indicator">
            <div class="active">1. Information</div>
            <div>2. Payment</div>
            <div>3. Confirmation</div>
        </div>

        <div class="container card d-flex flex-row p-4">
            <div class="col-md-7">
                <h4 class="checkout-subtitle">Ticket type</h4>
                <div class="form-check d-flex flex-row align-items-center mt-3">
                    <input class="form-check-input" type="radio" name="ticketType" id="digitalTicket" checked>
                    <div class="d-flex flex-col">
                       <label class="form-check-label" for="digitalTicket">
                        Digital ticket 
                        </label> 
                        <small class="text-muted">Presentation via Smartphone or Print at home</small>
                    </div>
                    
                </div>

                <h4 class="mt-4 checkout-subtitle">Customer data</h4>
                <form action="{{ route('checkout.step2') }}" method="get">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="First name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Last name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Address">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="address">Zip Code</label>
                            <input type="text" class="form-control" id="address" placeholder="Address">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="address">City</label>
                            <input type="text" class="form-control" id="address" placeholder="Address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail address</label>
                        <input type="email" class="form-control" id="email" placeholder="E-mail address">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Phone">
                    </div>
                    <div class="form-check my-3">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            <p style="font-size: 14px; line-height: 14px">I accept to receive marketing material based on the <a href="#">Terms & Conditions</a> written down here.</p>
                        </label>
                    </div>
                </form>
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
                    <form action="{{ route('checkout.step2') }}" method="get">
                    <button type="submit" class="btn btn-continue btn-block mt-3">Select Payment</button>
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

@push('scripts')
    <script>

    </script>
@endpush
