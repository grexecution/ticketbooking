@extends('layouts.site')

@section('title', 'Event List')

@section('content')
    <div class="container-fluid hero-container">
        <div class="text-center">
            <h2 class="font-weight-bold banner-title">Don’t miss out!</h2>
            <h4 class="font-weight-bold banner-desc">Explore the vibrant events happening locally and globally.</h4>
            <div class="input-group mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control search-input" placeholder="Search Events, Categories, Location,...">
            </div>
        </div>
    </div>

{{--        <ul class="list-group">--}}
{{--            @foreach($events as $event)--}}
{{--                <li class="list-group-item">{{ $event->name }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}

    <div class="container mt-5">
        <div class="">
            <div class="d-flex flex-row mb-4 gap-6">
                @foreach($events as $event)
                    <div class="col-md-6 p-4 rounded-xl" style="background-color:#F1F5F8">
                        <div class="event-item">
                            {{--                        <img src="{{ asset('img/event_card_image_2.png') }}" alt="Event Image">--}}
                            <a href="{{ url('events/' . $event->slug) }}">
                                <img class="img-fluid object-fit-cover mh-100" src="{{ $event->logo_event_url }}" alt="Event Image">
                            </a>
                            <div class="event-label"><i class="fas fa-star"></i></div>
                            <div class="category-label">Adventure</div>
                        </div>
                        <div class="event-info">
                            <div class="row">
                                <div class="col">
                                    <strong>{{ strtoupper($event->start_date?->format('M') ?? '') }}</strong>
                                </div>
                                <div class="col">
                                    <strong>{{ $event->start_date?->format('d') ?? '' }}</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ url('events/' . $event->slug) }}">
                                        <h5>{{ $event->name }}</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>{{ $event->venue?->name }} - {{ $event->venue?->address }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>{{ $event->start_date?->format('g:i a') ?? '' }} - {{ $event->start_time?->format('g:i a') ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>
                                        <i class="fas fa-ticket-alt"></i> INR 1,400 <span>&bull;</span>
                                        <i class="fas fa-star"></i> 14 interested
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row see-more-btn mb-5">
            <div class="col">
                <button>See More</button>
            </div>
        </div>
    </div>

@endsection
