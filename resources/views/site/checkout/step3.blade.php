@extends('layouts.site')

@section('title', __('site.checkout_3_step'))

@section('content')
    <!-- Step 3: Confirmation -->
    <div class="container mt-5">
        <div class="step-indicator">
            <div class="d-flex justify-content-center align-items-center active">@lang('site.information')</div>
            <div class="d-flex justify-content-center align-items-center active">@lang('site.payment')</div>
            <div class="d-flex justify-content-center align-items-center active">@lang('site.confirmation')</div>
        </div>

        <div class="confirmation">
            @if(request()->get('canceled'))
                <h4 style="color: red;">@lang('site.order_cancelled')</h4>
            @else
                <h4 style="color: green;">@lang('site.order_successful')</h4>
            @endif
            <p>@lang('site.order_number'): #{{ $order->id }}</p>
            <p>@lang('site.program'): {{ $order->event->name }}</p>
            <p>@lang('site.venue'): {{ $order->event->venue->address }}</p>
            <p>@lang('site.date'): {{ \Carbon\Carbon::parse($order->event->start_date)->format('F jS, Y') }} @lang('site.at') {{ \Carbon\Carbon::parse($order->event->start_time)->format('g:i a') }}</p>
            <p>@lang('site.total'): €{{ $order->total }}</p>
            <p>@lang('site.number_of_tickets'): {{ $order->tickets->count() }}</p>
            <p>@lang('site.email'): @lang('site.delivered')</p>
            @if($order->status === 'succeeded')
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="window.open('{{ route('showTickets', $order->id) }}', '_blank')">
                        <i class="fa-solid fa-ticket"></i>
                        @lang('site.view_tickets')
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.open('{{ route('showInvoice', $order->id) }}', '_blank')">
                        <i class="fa-solid fa-ticket"></i>
                        @lang('site.view_invoice')
                    </button>
                </div>
            @endif
            <a href="{{ route('site.event', $order->event->id) }}" type="button" class="btn btn-dark btn-continue">@lang('site.back_to_event')</a>
        </div>
    </div>
@endsection
