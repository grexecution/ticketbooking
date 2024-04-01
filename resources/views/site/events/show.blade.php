@extends('layouts.site')

@section('title', 'Show Event')

@section('content')
    <h1>Show Event # {{ Route::current()->parameter('eventId') }}</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $event?->name ?? '' }}</h5>
            <p class="card-text">{{ $event?->description ?? '' }}</p>
            <!-- Add more details about the event -->
        </div>
    </div>
@endsection
