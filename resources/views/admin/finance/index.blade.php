@extends('page')

@section('title', 'Finance')
@section('title_header', 'Finance')

@section('content')
    <div class="container pt-3">
        @include('messages')

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/finance.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
