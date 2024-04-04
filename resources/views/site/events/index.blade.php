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
        <h1 class="mb-4">Popular Events</h1>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="event-item">
                    <img src="{{ asset('img/event_card_image_2.png') }}" alt="Event Image">
                    <div class="event-label"><i class="fas fa-star"></i></div>
                    <div class="category-label">Adventure</div>
                </div>
                <div class="event-info">
                    <div class="row">
                        <div class="col">
                            <strong>NOV</strong>
                        </div>
                        <div class="col">
                            <strong>25 - 26</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('site.event', 1) }}">
                                <h5>Lakeside Camping at Pawna</h5>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>Adventure Geek - Explore the Unexplored, Mumbai</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>8:30 AM - 7:30 PM</p>
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
            <div class="col-md-6">
                <div class="event-item">
                    <img src="{{ asset('img/event_card_image.png') }}" alt="Event Image">
                    <div class="event-label event-favorite"><i class="fas fa-star"></i></div>
                    <div class="category-label">Adventure</div>
                </div>
                <div class="event-info">
                    <div class="row">
                        <div class="col">
                            <strong>NOV</strong>
                        </div>
                        <div class="col">
                            <strong>25 - 26</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('site.event', 1) }}">
                                <h5>Lakeside Camping at Pawna</h5>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>Adventure Geek - Explore the Unexplored, Mumbai</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>8:30 AM - 7:30 PM</p>
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
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="event-item">
                    <img src="{{ asset('img/event_card_image.png') }}" alt="Event Image">
                    <div class="event-label"><i class="fas fa-star"></i></div>
                    <div class="category-label">Adventure</div>
                </div>
                <div class="event-info">
                    <div class="row">
                        <div class="col">
                            <strong>NOV</strong>
                        </div>
                        <div class="col">
                            <strong>25 - 26</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('site.event', 1) }}">
                                <h5>Lakeside Camping at Pawna</h5>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>Adventure Geek - Explore the Unexplored, Mumbai</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>8:30 AM - 7:30 PM</p>
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
            <div class="col-md-6">
                <div class="event-item">
                    <img src="{{ asset('img/event_card_image_2.png') }}" alt="Event Image">
                    <div class="event-label event-favorite"><i class="fas fa-star"></i></div>
                    <div class="category-label">Adventure</div>
                </div>
                <div class="event-info">
                    <div class="row">
                        <div class="col">
                            <strong>NOV</strong>
                        </div>
                        <div class="col">
                            <strong>25 - 26</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('site.event', 1) }}">
                                <h5>Lakeside Camping at Pawna</h5>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>Adventure Geek - Explore the Unexplored, Mumbai</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p>8:30 AM - 7:30 PM</p>
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
        </div>
        <div class="row see-more-btn mb-5">
            <div class="col">
                <button>See More</button>
            </div>
        </div>
    </div>

@endsection
