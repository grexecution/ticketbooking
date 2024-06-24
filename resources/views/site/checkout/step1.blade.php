@extends('layouts.site')

@section('title', __('site.checkout_1_step'))

@section('content')
    <!-- Step 1: Information -->
    <div class="py-5" style="background-color: #F1F5F8">
        <div class="container">
            <div class="step-indicator">
                <div class="d-flex justify-content-center align-items-center active">@lang('messages.information')</div>
                <div class="d-flex justify-content-center align-items-center">@lang('messages.payment')</div>
                <div class="d-flex justify-content-center align-items-center">@lang('messages.confirmation')</div>
            </div>

            <div class="container card d-flex flex-col flex-md-row justify-content-between px-2 px-md-4 py-4 py-md-4">
                <div class="col-md-6">
                    <h4 class="checkout-subtitle">@lang('messages.ticket_type')</h4>
                    <div class="form-check d-flex flex-row align-items-center mt-3">
                        <input class="form-check-input" type="radio" name="ticketType" id="digitalTicket" checked>
                        <div class="d-flex flex-col">
                            <label class="form-check-label" for="digitalTicket">
                                @lang('messages.digital_ticket')
                            </label>
                            <small class="text-muted">@lang('messages.presentation_via_smartphone')</small>
                        </div>

                    </div>

                    <h4 class="mt-4 checkout-subtitle">@lang('messages.customer_data')</h4>
                    <form id="customer-data-form" action="{{ route('checkout.step2') }}" method="get">
                        <input type="hidden" name="event_id" value="{{ request()->get('event_id') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-6 col-md-6">
                                <label for="firstName">@lang('messages.first_name')</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" value="{{ old('first_name') }}" placeholder="@lang('messages.first_name')">
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-6 col-md-6">
                                <label for="lastName">@lang('messages.last_name')</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" value="{{ old('last_name') }}" placeholder="@lang('messages.last_name')">
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="address">@lang('messages.address')</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="@lang('messages.address')">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-6 col-md-2">
                                <label for="zip_code">@lang('messages.zip_code')</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="@lang('messages.zip_code')">
                                @error('zip_code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-6 col-md-4">
                                <label for="city">@lang('messages.city')</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="@lang('messages.city')">
                                @error('city')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">@lang('messages.email_address')</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="@lang('messages.email_address')">
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">@lang('messages.phone')</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="@lang('messages.phone')">
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check my-3">
                            <input name="is_subscribed" type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">
                                <p style="font-size: 14px; line-height: 14px">@lang('messages.accept_to_receive')</p>
                            </label>
                            @error('is_subscribed')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>

                <div class="col-md-5">
                    <order-summary
                        :action-url="'{{ route('checkout.step2') }}'"
                        :is-payment-form="false"
                    /></order-summary>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
