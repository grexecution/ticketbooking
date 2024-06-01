@extends('layouts.site')

@section('title', 'Checkout 3 Step')

@section('content')
    <!-- Step 3: Confirmation -->
    <div class="container mt-5">
        <div class="step-indicator">
            <div class="active">1. Information</div>
            <div class="active">2. Payment</div>
            <div class="active">3. Confirmation</div>
        </div>

        <div class="confirmation">
            @if(request()->get('canceled'))
                <h4 style="color: red;">Order cancelled</h4>
            @else
                <h4 style="color: green;">Order successful</h4>
            @endif
            <p>Order number: #{{ $order->id }}</p>
            <p>Program: {{ $order->event->name }}</p>
            <p>Venue: {{ $order->event->venue->address }}</p>
            <p>Date: {{ \Carbon\Carbon::parse($order->event->start_date)->format('F jS, Y') }} at {{ \Carbon\Carbon::parse($order->event->start_time)->format('g:i a') }}</p>
            <p>Total: €{{ $order->total }}</p>
            <p>Number of tickets: {{ $order->tickets->count() }}</p>
            <p>Email: delivered</p>
            <div class="btn-group">
                <button type="button" class="btn btn-primary">
                    <i class="fa-solid fa-ticket"></i>
                    View tickets
                </button>
                <button type="button" class="btn btn-primary">
                    <i class="fa-solid fa-ticket"></i>
                    View invoice
                </button>
            </div>
            <a href="{{ route('site.event', $order->event->id) }}" type="button" class="btn btn-dark btn-continue">← Back to the event</a>
        </div>
    </div>
@endsection
