@extends('layouts.site')

@section('title', __('site.checkout_3_step'))

@section('content')
    <!-- Step 3: Confirmation -->
    <div class="container mt-5">
        <div class="step-indicator">
            <div class="d-flex justify-content-center align-items-center active">@lang('messages.information')</div>
            <div class="d-flex justify-content-center align-items-center active">@lang('messages.payment')</div>
            <div class="d-flex justify-content-center align-items-center active">@lang('messages.confirmation')</div>
        </div>

        <div class="confirmation">
            @if(request()->get('canceled'))
                <h4 style="color: red;">@lang('messages.order_cancelled')</h4>
            @else
                <h4 style="color: green;">@lang('messages.order_successful')</h4>
            @endif
            <p>@lang('messages.order_number'): #{{ $order->id }}</p>
            <p>@lang('messages.program'): {{ $order->event->name }}</p>
            <p>@lang('messages.venue'): {{ $order->event->venue->address }}</p>
            <p>@lang('messages.date'): {{ \Carbon\Carbon::parse($order->event->start_date)->format('F jS, Y') }} @lang('messages.at') {{ \Carbon\Carbon::parse($order->event->start_time)->format('g:i a') }}</p>
            <p>@lang('messages.total'): €{{ $order->total }}</p>
            <p>@lang('messages.number_of_tickets'): {{ $order->tickets->count() }}</p>
            <p>@lang('messages.email'): @lang('messages.delivered')</p>
            @if($order->status === 'succeeded')
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="window.open('{{ route('showTickets', $order->id) }}', '_blank')">
                        <i class="fa-solid fa-ticket"></i>
                        @lang('messages.view_tickets')
                    </button>
                    <button type="button" class="btn btn-primary" onclick="window.open('{{ route('showInvoice', $order->id) }}', '_blank')">
                        <i class="fa-solid fa-ticket"></i>
                        @lang('messages.view_invoice')
                    </button>
                </div>
            @endif
            <a href="{{ route('site.event', $order->event->id) }}" type="button" class="btn btn-dark btn-continue">@lang('messages.back_to_event')</a>
        </div>
    </div>
@endsection
