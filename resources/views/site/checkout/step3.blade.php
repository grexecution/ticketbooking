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
            <p>Order number: #22322</p>
            <p>Program: Flo & Wisch “Humor Worms”</p>
            <p>Venue: Orpheum Wien</p>
            <p>Date: November 23rd, 2023 at 8:00 p.m</p>
            <p>Total: €120</p>
            <p>Number of tickets: 3</p>
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
            <button type="button" class="btn btn-dark btn-continue">← Back to the admin area</button>
        </div>
    </div>
@endsection
