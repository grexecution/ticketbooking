@extends('layouts.site')

@section('title', 'Subscription')

@section('content')
    <div>
        <!--Subscription Banner-->
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
            <subscription
                :subscription-id="'{{ $subscription->id }}'"
            ></subscription>
        </div>
    </div>
@endsection
