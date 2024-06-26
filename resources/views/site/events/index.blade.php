@extends('layouts.site')

@section('title', __('messages.event_list'))

@section('content')
    <header>

        <!-- This div is  intentionally blank. It creates the transparent black overlay over the video which you can modify in the CSS -->
        <div class="overlay"></div>

        <!-- The HTML5 video element that will create the background video on the header -->
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="https://player.vimeo.com/progressive_redirect/playback/969180664/rendition/720p/file.mp4?loc=external&log_user=0&signature=d86d7f6e384797160903f81be3c61a0abced9d12b6298c58b76b455694e8b205" type="video/mp4">
        </video>


        <!-- The header content -->
        <div class="container h-100">
            <div class="d-flex h-100 text-center align-items-center">
                <div class="w-100 text-white mx-auto d-flex flex-column align-items-center gap-2">
                    <img src="{{ asset('img/ticketwilli_text.png') }}" alt="@lang('messages.ticket_icon')" class="" style="width: 300px">
                    <h4 class="font-weight-bold banner-desc">@lang('messages.online_pudl')</h4>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-2 g-5 mb-4">
            @foreach($events as $event)
                <div class="col mb-4">
                    <div class="p-3 p-md-4 rounded-xl" style="background-color:#F1F5F8">
                        <div class="event-item">
                            <a href="{{ url('events/' . $event->slug) }}">
                                <img class="img-fluid object-fit-cover mh-100" src="{{ $event->logo_event_url }}" alt="@lang('messages.event_image')">
                            </a>
                            <div class="event-label">
                                <i class="fas fa-calendar mr-2"></i>
                                <strong>{{ $event->start_date?->translatedFormat('d') ?? '' }}</strong>.<strong>{{ strtoupper($event->start_date?->translatedFormat('M') ?? '') }}</strong>
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
                        <a href="{{ url('events/' . $event->slug) }}">
                            <button type="button" class="btn btn-orange checkout-btn w-100 mt-2">Tickets kaufen</button>
                        </a>

                    </div>

                </div>
            @endforeach
        </div>
    </div>

@endsection
