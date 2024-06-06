@extends('layouts.site')

@section('title', 'Show Event')

@section('content')
{{--    <h1>Show Event # {{ Route::current()->parameter('eventId') }}</h1>--}}
<div class="bg-white border-bottom py-4 my-md-4">
    <div class="container">
        <div class="d-flex flex-col-reverse flex-md-row my-3">
            <!-- Event Banner -->
            <div class="col-lg-8">
                <div class="event-banner">
                    <!-- Title -->
                    <div class="row">
                        <div class="col">
                            <h1 class="event-title">{{ $isPreview ? 'Preview: ' : '' }}{{ $event->name }}</h1>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="row">
                        <div class="col">
                            <p>{!! $event->description !!}</p>
                        </div>
                    </div>
                    <!-- Event Details -->
                    <div class="row m-0">
                        <div class="d-flex gap-0 flex-col flex-md-row gap-1 gap-md-6">
                            <div class="event-detail">
                                <i class="fas fa-calendar-alt"></i> {{ $event->start_date?->format('l, d.m.Y') ?? '' }} | {{ $event->start_time?->format('g:i a') ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->venue?->name ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-money-bill"></i> Preis ab €{{ $event->price ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Event Image -->
            <div class="col-lg-4 mb-3 mb-md-0">
{{--                <img src="{{ asset('img/event_detail.png') }}" alt="Event Image" class="img-fluid rounded">--}}
                <img src="{{ $event->logo_event_url }}" alt="Event Image" class="img-fluid rounded event-image w-100">
            </div>
        </div>
    </div>
</div>

@if($isUnavailable)
    <div class="main-bg">
        <div class="row py-6 mb-5 container m-auto">
            <div class="col">
                <div class="text-center mb-2 bg-white py-6">This Event is not available</div>
            </div>
        </div>
    </div>

@elseif($event->seat_type === 'no_seat_plan' )<div class="pt-5 pb-20" style="background: #F1F5F8">
    <no-seat-plan
        event-id="{{ $event->id }}"
    ></no-seat-plan>
@else
    <div class="main-bg py-6">
        <div class="row py-6 mb-5 container m-auto">
            <div class="container card py-6">
                <seat-plan
                    event-id="{{ $event->id }}"
                ></seat-plan>
{{--                <seat-plan :event-id="{{ $event->id }}"></seat-plan>--}}
            </div>
        </div>
    </div>


        <!-- Popup Modal -->
    {{--    <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel" aria-hidden="true">--}}
    {{--        <div class="modal-dialog modal-dialog-centered" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="popupModalLabel">Your Places</h5>--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                        <span aria-hidden="true">&times;</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    <ul class="list-group" id="ticketList">--}}
    {{--                        <!-- Add rows for selected tickets here -->--}}
    {{--                        <li class="list-group-item d-flex justify-content-between align-items-center">Row 1 - Seat 1<span class="badge badge-primary badge-pill">€ 39,90</span><span class="remove-icon" onclick="removeTicket(this)">Remove</span></li>--}}
    {{--                    </ul>--}}
    {{--                </div>--}}
    {{--                <div class="modal-footer">--}}
    {{--                    <div>Total</div>--}}
    {{--                    <div>€ 45,90</div>--}}
    {{--                    <button type="button" class="btn btn-warning" onclick="checkout()">To the checkout</button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <div class="card">--}}
    {{--        <div class="card-body">--}}
    {{--            <h5 class="card-title">{{ $event?->name ?? '' }}</h5>--}}
    {{--            <p class="card-text">{{ $event?->description ?? '' }}</p>--}}
    {{--            <!-- Add more details about the event -->--}}
    {{--        </div>--}}
    {{--    </div>--}}
@endif
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

