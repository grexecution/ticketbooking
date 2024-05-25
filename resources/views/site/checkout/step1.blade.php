@extends('layouts.site')

@section('title', 'Checkout 1 Step')

@section('content')
    <!-- Step 1: Information -->
    <div class="container mt-5">
        <div class="step-indicator">
            <div class="active">1. Information</div>
            <div>2. Pay</div>
            <div>3. Confirmation</div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <h4>Ticket type</h4>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ticketType" id="digitalTicket" checked>
                    <label class="form-check-label" for="digitalTicket">
                        Digital ticket <small class="text-muted">Presentation via smartphone or printout</small>
                    </label>
                </div>

                <h4 class="mt-4">Customer data</h4>
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
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail address</label>
                        <input type="email" class="form-control" id="email" placeholder="E-mail address">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" placeholder="Phone">
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="order-summary">
                    <div class="ticket-warning">Tickets are still available for: 09:48 min.</div>
                    <div class="mt-3">
                        <p>3 x Flo & Wipe “Humor Worms”</p>
                        <p>23.11.2023 | 20:00</p>
                        <p>Oggau, Burgenland</p>
                        <p>€65,00</p>
                    </div>
                    <hr>
                    <h5>In total: €120,00</h5>
                </div>
                <form action="{{ route('checkout.step2') }}" method="get">
                    <button type="submit" class="btn btn-primary btn-block mt-3">Further</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
