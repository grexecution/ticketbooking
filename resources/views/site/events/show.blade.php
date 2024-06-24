@extends('layouts.site')

@section('title', 'Show Event')

@section('content')
{{--    <h1>Show Event # {{ Route::current()->parameter('eventId') }}</h1>--}}
<div class="bg-white border-bottom py-3 py-md-5">
    <div class="container">
        <div class="d-flex flex-col-reverse flex-md-row my-3">
            <!-- Event Banner -->
            <div class="col-lg-7 px-0 px-md-3">
                <div class="event-banner">
                    <!-- Title -->
                    <div class="row">
                        <div class="col">
                            <h1 class="event-title">{{ $isPreview ? __('messages.preview') : '' }}{{ $event->name }}</h1>
                        </div>
                    </div>
                    <!-- Event Details -->
                    <div class="col m-0">
                        <div class="row flex-col flex-md-row d-flex flex-row w-md-100 justify-content-start gap-3">
                            <div class="event-detail">
                                <i class="fas fa-calendar-alt"></i> {{ $event->start_date?->translatedFormat('l, d.m.Y') ?? '' }} | {{ $event->start_time?->format('H:i') ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->venue?->name ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-money-bill"></i> @lang('messages.price_from') €{{ number_format($event->price ?? 0, 2, ',', '') }}
                            </div>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="row">
                        <div class="col">
                            <p>{!! $event->description !!}</p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Event Image -->
            <div class="col-lg-5 mb-3 mb-md-0 px-0 px-md-3">
                <img src="{{ $event->logo_event_url }}" alt="@lang('messages.event_image')" class="img-fluid rounded event-image w-100">
            </div>
        </div>
    </div>
</div>

@if($isUnavailable)
    <div class="main-bg">
        <div class="row py-6 mb-5 container m-auto">
            <div class="col">
                <div class="text-center mb-2 bg-white py-6">@lang('messages.event_not_available')</div>
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
                <div class="container card py-1 py-md-3 px-1" style="background-color: #fff7e161;">
                    <seat-plan
                        event-id="{{ $event->id }}"
                    ></seat-plan>
                </div>
                @php
                    $partners = $event->getMedia('partners');
                @endphp

                @if($partners->isNotEmpty())
                    <div class="container card py-1 py-md-3 px-1 mt-3">
                        <div class="col">
                            <h2 class="event-title text-center mb-4">@lang('messages.sponsors')</h2>
                            <div class="logo-banner d-flex flex-wrap justify-content-between">
                                @foreach($partners as $partner)
                                    <img src="{{ $partner->getUrl() }}" alt="@lang('messages.partner_image')" style="height:150px" class="rounded partner-image">
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endif
            </div>




@endif
@endsection

@section('styles')
    <style>
        .partner-image {
            object-fit: cover;
            margin-right: 10px;
        }
        .logo-banner {
            justify-content: space-between;
        }
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

