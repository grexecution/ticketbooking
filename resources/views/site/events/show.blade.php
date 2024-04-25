@extends('layouts.site')

@section('title', 'Show Event')

@section('content')
{{--    <h1>Show Event # {{ Route::current()->parameter('eventId') }}</h1>--}}
    <div class="container">
        <div class="row mt-5 mb-5">
            <!-- Event Banner -->
            <div class="col-lg-8">
                <div class="event-banner">
                    <!-- Title -->
                    <div class="row">
                        <div class="col">
                            <h1>{{ $event->name }}</h1>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="row">
                        <div class="col">
                            <p>{{ $event->description }}</p>
                        </div>
                    </div>
                    <!-- Event Details -->
                    <div class="row">
                        <div class="col">
                            <div class="event-detail">
                                <i class="fas fa-calendar-alt"></i> {{ $event->start_date?->format('l, d.m.Y') ?? '' }} | {{ $event->start_time?->format('g:i a') ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->venue?->name ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-euro-sign"></i> from €{{ $event->prive ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Event Image -->
            <div class="col-lg-4">
{{--                <img src="{{ asset('img/event_detail.png') }}" alt="Event Image" class="img-fluid rounded">--}}
                <img src="{{ $event->logo_event_url }}" alt="Event Image" class="img-fluid rounded">
            </div>
        </div>

        <!-- Seats and Pricing -->
        <div class="row mt-4">
            <!-- Pricing Blocks -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset('img/seat_A.png') }}" alt="Small Image" class="img-fluid">
                        <div class="pricing-info">
                            <div>Category A</div>
                            <div>€ 28,00</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('img/seat_B.png') }}" alt="Small Image" class="img-fluid">
                        <div class="pricing-info">
                            <div>Category B</div>
                            <div>€ 38,00</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('img/seat_C.png') }}" alt="Small Image" class="img-fluid">
                        <div class="pricing-info">
                            <div>Category C</div>
                            <div>€ 38,00</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('img/seat_D.png') }}" alt="Small Image" class="img-fluid">
                        <div class="pricing-info">
                            <div>Category D</div>
                            <div>€ 8,00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seat Layout -->
        <div class="row mt-4 mb-5">
            <div class="col">
                <div class="text-center mb-2">STAGE</div>
                <div class="seat-layout">
                    <div class="row">
                        <div class="col-1"></div>
                        @for($k = 0; $k < 10; $k++)
                            <div class="col seat-header">{{chr(65 + $k)}}</div>
                        @endfor
                    </div>
                    @for($i = 0; $i < 10; $i++)
                        <div class="row">
                            <div class="col-1">{{$i + 1}}</div>
                            @for($j = 0; $j < 10; $j++)
                                <div class="col seat">
                                    <img src="{{ asset('img/seat_A.png') }}" alt="Specific Seat" class="img-fluid m-1" onclick="openPopup('Row {{ $i + 1 }} - Seat {{ chr(65 + $j) }}', '€ 39,90')">
                                </div>
                            @endfor
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Popup Modal -->
    <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupModalLabel">Your Places</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="ticketList">
                        <!-- Add rows for selected tickets here -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">Row 1 - Seat 1<span class="badge badge-primary badge-pill">€ 39,90</span><span class="remove-icon" onclick="removeTicket(this)">Remove</span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <div>Total</div>
                    <div>€ 45,90</div>
                    <button type="button" class="btn btn-warning" onclick="checkout()">To the checkout</button>
                </div>
            </div>
        </div>
    </div>

{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            <h5 class="card-title">{{ $event?->name ?? '' }}</h5>--}}
{{--            <p class="card-text">{{ $event?->description ?? '' }}</p>--}}
{{--            <!-- Add more details about the event -->--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('styles')
    <style>
        .event-banner {
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .event-detail {
            margin-bottom: 10px;
        }

        .pricing-info {
            padding: 10px;
            text-align: center;
        }

        .seat-layout {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
        }

        .seat {
            width: 41px;
            height: 40px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            margin: 2px;
            position: relative;
        }

        .seat img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .seat-header {
            background-color: #e9ecef;
            text-align: center;
            font-weight: bold;
        }
    </style>
@endsection

@push('scripts')
    <script>
        function openPopup(ticketInfo, price) {
            // Populate ticket information
            var ticketItem = `
                <li class="list-group-item d-flex justify-content-between align-items-center">${ticketInfo}<span class="badge badge-primary badge-pill">${price}</span><span class="remove-icon" onclick="removeTicket(this)">Remove</span></li>
            `;
            // Append ticket item to the ticket list
            document.getElementById('ticketList').innerHTML += ticketItem;
            // Show the popup modal
            $('#popupModal').modal('show');
        }

        // Function to remove a ticket row
        function removeTicket(element) {
            element.parentNode.remove();
        }

        // Function to handle checkout
        function checkout() {
            // Perform checkout operation here
            // For example, redirect to checkout page
            // window.location.href = '/checkout';
        }
    </script>
@endpush
