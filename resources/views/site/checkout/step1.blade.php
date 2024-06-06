@extends('layouts.site')

@section('title', 'Checkout 1 Step')

@section('content')
    <!-- Step 1: Information -->
<div class="py-5" style="background-color: #F1F5F8">
    <div class="container">
        <div class="step-indicator">
            <div class="d-flex justify-content-center align-items-center active">1. Information</div>
            <div class="d-flex justify-content-center align-items-center">2. Payment</div>
            <div class="d-flex justify-content-center align-items-center">3. Confirmation</div>
        </div>

        <div class="container card d-flex flex-col flex-md-row justify-content-between px-2 px-md-4 py-4 py-md-4">
            <div class="col-md-6">
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
                <form id="customer-data-form" action="{{ route('checkout.step2') }}" method="get">
                    <input type="hidden" name="event_id" value="{{ request()->get('event_id') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstName">First name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" value="{{ old('first_name') }}" placeholder="First name">
                            @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Last name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" value="{{ old('last_name') }}" placeholder="Last name">
                            @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Address">
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <label for="zip_code">Zip Code</label>
                            <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="Zip Code">
                            @error('zip_code')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="City">
                            @error('city')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="E-mail address">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone">
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check my-3">
                        <input name="is_subscribed" type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            <p style="font-size: 14px; line-height: 14px">I accept to receive marketing material based on the <a href="#">Terms & Conditions</a> written down here.</p>
                        </label>
                        @error('is_subscribed')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="col-md-5">
                <order-summary
                    :action-url="'{{ route('checkout.step2') }}'"
                    :is-payment-form="false"
                /></order-summary>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
