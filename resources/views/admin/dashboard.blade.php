@extends('page')

@section('title', 'Dashboard')
@section('title_header', 'Dashboard')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <div class="row mt-4">

        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
