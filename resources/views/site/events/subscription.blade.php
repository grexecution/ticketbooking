@extends('layouts.site')

@section('title', __('site.subscription'))

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
                                        <i class="fa fa-calendar-days"></i> {{ count($subscription->events) }} @lang('site.events')
                                    </div>
                                    <div class="event-detail">
                                        <i class="fa fa-map-marker-alt"></i> {{ $subscription->events->pluck('venue')->unique()->count() }} @lang('site.event_locations')
                                    </div>
                                    <div class="event-detail">
                                        <i class="fas fa-money-bill"></i> @lang('site.price_from') €{{ $subscription->price ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Subscription Image -->
                    <div class="col-lg-4">
                        <img src="{{ $subscription->logo_sub_url }}" alt="@lang('site.subscription_image')" class="img-fluid rounded event-image">
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
