@extends('layouts.site')

@section('title', 'Event List')

@section('content')
    <h1>Event List</h1>
    <ul class="list-group">
        @foreach($events as $event)
            <li class="list-group-item">{{ $event->name }}</li>
        @endforeach
    </ul>
@endsection
