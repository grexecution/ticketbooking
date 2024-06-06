@extends('layouts.site')

@section('title', 'Event List')

@section('content')
    <div class="container-fluid hero-container">
        <div class="text-center">
            <h1 class="font-weight-bold banner-title">Ticketwilli</h1>
            <h4 class="font-weight-bold banner-desc">Die Online-Pudl für Events in 🇦🇹</h4>
            <!--<div class="input-group mt-4">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control search-input" placeholder="Search Events, Categories, Location,...">
            </div>-->
        </div>
    </div>

{{--        <ul class="list-group">--}}
{{--            @foreach($events as $event)--}}
{{--                <li class="list-group-item">{{ $event->name }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}

    <div class="container mt-5">
        <div class="container">
            <div class="d-flex row mb-4">
                @foreach($events as $event)
                    <div class="col-md-6 p-4 rounded-xl" style="background-color:#F1F5F8">
                        <div class="event-item">
                            {{--                        <img src="{{ asset('img/event_card_image_2.png') }}" alt="Event Image">--}}
                            <a href="{{ url('events/' . $event->slug) }}">
                                <img class="img-fluid object-fit-cover mh-100" src="{{ $event->logo_event_url }}" alt="Event Image">
                            </a>
                           <div class="event-label">
                               <i class="fas fa-calendar mr-2"></i>
                               <strong>{{ $event->start_date?->format('d') ?? '' }}</strong>.<strong>{{ strtoupper($event->start_date?->format('M') ?? '') }}</strong>
                           </div>
                            <div class="category-label text-black">Kabarett</div>
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
                                    <p><i class="fas fa-clock"></i> {{ $event->start_date?->format('g:i a') ?? '' }} - {{ $event->start_time?->format('g:i a') ?? '' }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>
                                        <i class="fas fa-money-bill"></i> Tickets ab €{{ $event->price ?? 0 }},-
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- <div class="row see-more-btn mb-5">
            <div class="col">
                <button>See More</button>
            </div>
        </div>
    </div> -->

@endsection
