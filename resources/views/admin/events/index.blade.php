@extends('page')

@section('title', 'Events')
@section('title_header', 'Events')

@section('content')
    <div class="container pt-3">
        @include('messages')

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/course.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
