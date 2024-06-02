@extends('layouts.site')

@section('title', 'Subscription')

@section('content')
    <div>
        <div class="bg-white border-bottom py-14">
            <div class="container">
                <div class="row my-3">
                    <!-- Subscription Banner -->
                    <div class="col-lg-8">
                        <div class="event-banner">
                            <!-- Title -->
                            <div class="row">
                                <div class="col">
                                    <h1 class="event-title">{{ $subscription->name }}</h1>
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="row">
                                <div class="col">
                                    <p>{!! $subscription->description !!}</p>
                                </div>
                            </div>
                            <!-- Subscription Details -->
                            <div class="row">
                                <div class="col d-flex gap-6">
                                    <div class="event-detail">
                                        <i class="fa fa-calendar-days"></i> {{ count($subscription->events) }} Events
                                    </div>
                                    <div class="event-detail">
                                        <i class="fa fa-map-marker-alt"></i> {{ $subscription->events->pluck('venue')->unique()->count() }} Event Locations                                    </div>
                                    <div class="event-detail">
                                        <i class="fas fa-money-bill"></i> Preis ab €{{ $subscription->price ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Subscription Image -->
                    <div class="col-lg-4">
                        <img src="{{ $subscription->logo_sub_url }}" alt="Subscription Image" class="img-fluid rounded event-image">
                    </div>
                </div>
            </div>

        </div>
        <!-- Events List -->
        <div class="main-bg pt-6 pb-20">
            <div class="col py-6 mb-5 container m-auto gap-2">
                <h2 class="sub-subheadline">Events included in this Subscription:</h2>
                @foreach($subscription->events as $event)
                    <div class="card my-6 rounded-xl overflow-hidden">
                        <div class="d-flex">
                            <div class="col-md-3 p-0">
                                <img src="{{ $event->logo_event_url }}" class="img-fluid event-image" alt="Event Image">
                            </div>
                            <div class="card-body py-6">
                                <h5 class="mb-1 sub-event-title">{{ $event->name }}</h5>
                                <div>
                                    <p class="card-text">{!! $event->description !!}</p>
                                </div>
                                <div class="row mt-3">
                                    <div class="col d-flex gap-6">
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
                    </div>
                @endforeach
            </div>
            <no-seat-plan
                event-id="{{ $event->id }}"
            ></no-seat-plan>

        </div>
    </div>
@endsection
