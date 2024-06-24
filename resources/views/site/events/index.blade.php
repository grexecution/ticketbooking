@extends('layouts.site')

@section('title', __('messages.event_list'))

@section('content')
    <div class="container-fluid hero-container">
        <div class="text-center">
            <h1 class="font-weight-bold banner-title">@lang('messages.ticketwilli')</h1>
            <h4 class="font-weight-bold banner-desc">@lang('messages.online_pudl')</h4>
            <!--<div class="input-group mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control search-input" placeholder="@lang('messages.search_events')">
            </div>-->
        </div>
    </div>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 g-5">
            @foreach($events as $event)
                <div class="col mb-4">
                    <div class="p-3 p-md-4 rounded-xl" style="background-color:#F1F5F8">
                        <div class="event-item">
                            <a href="{{ url('events/' . $event->slug) }}">
                                <img class="img-fluid object-fit-cover mh-100" src="{{ $event->logo_event_url }}" alt="@lang('messages.event_image')">
                            </a>
                            <div class="event-label">
                                <i class="fas fa-calendar mr-2"></i>
                                <strong>{{ $event->start_date?->format('d') ?? '' }}</strong>.<strong>{{ strtoupper($event->start_date?->format('M') ?? '') }}</strong>
                            </div>
                            <div class="category-label text-black">@lang('messages.kabarett')</div>
                        </div>
                        <div class="event-info">
                            <div class="row">
                                <div class="col">
                                    <a href="{{ url('events/' . $event->slug) }}">
                                        <h5 style="font-size:18px;font-weight:600">{{ $event->name }}</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p><i class="fas fa-map-pin"></i> {{ $event->venue?->name }} - {{ $event->venue?->address }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p><i class="fas fa-clock"></i> @lang('messages.start'): {{ $event->start_time?->format('H:i') ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>
                                    <p><i class="fas fa-money-bill"></i> @lang('messages.tickets_from') €{{ number_format($event->price ?? 0, 2, ',', '') }}<small> inkl. MwsT</small></p>                                        </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>

@endsection
