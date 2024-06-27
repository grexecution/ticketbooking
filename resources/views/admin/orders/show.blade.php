@extends('page')

@section('title', 'Order')
@section('title_header', 'Order')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <div class="container-fluid bg-white py-3">
            <div class="order-header">
                <div>
                    <h5>Customer Information</h5>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-wrap">Surname:</p>
                            <p class="text-wrap">Email:</p>
                            <p class="text-wrap">Order date:</p>
                            <p class="text-wrap">Order status:</p>
                        </div>
                        <div class="col-6">
                            <p class="text-wrap"><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                            <p class="text-wrap"><strong>{{ $order->email ?: '---' }}</strong></p>
                            <p class="text-wrap"><strong>{{ \Carbon\Carbon::parse($order->order_date)->format('m/d/Y') }} | {{ \Carbon\Carbon::parse($order->order_date)->format('H:i') }}</strong></p>
                            <p class="text-wrap"><strong class="text-success">{{ ucfirst($order->order_status) }}</strong></p>
                        </div>
                    </div>
                </div>
                <div>
                    <h5>Billing Details</h5>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-wrap">Address:</p>
                            <p class="text-wrap">Order type:</p>
                            <p class="text-wrap">Payment method:</p>
{{--                            <p class="text-wrap">Stripe link:</p>--}}
                        </div>
                        <div class="col-6">
                            <p class="text-wrap"><strong>{{ $order->address }}, {{ $order->zip_code }} {{ $order->city }}</strong></p>
                            <p class="text-wrap"><strong>{{ ucfirst($order->order_type) }} order</strong></p>
                            <p class="text-wrap"><strong>{{ ucfirst($order->payment_method) }}</strong></p>
{{--                            <p class="text-wrap"><a href="https://stripe.com/booking...">https://stripe.com/booking...</a></p>--}}
                        </div>
                    </div>
                </div>
                <div>
                    <h5>Booking Information</h5>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-wrap">Event:</p>
                            <p class="text-wrap">Date:</p>
                        </div>
                        <div class="col-6">
                            <p class="text-wrap"><strong>{{ $order->event->name }}</strong></p>
                            <p class="text-wrap"><strong>{{ \Carbon\Carbon::parse($order->event->start_date)->format('d.m.Y') }}</strong></p>
                        </div>
                    </div>
                    <div class="order-actions">
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-light btn-header">
                                    <i class="fa-brands fa-telegram"></i> Send invoice
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{ route('showInvoice', $order->id) }}" target="_blank" class="btn btn-dark btn-header">
                                    <i class="fa-solid fa-print"></i> View invoice
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a class="btn btn-light btn-header">
                                    <i class="fa-brands fa-telegram"></i> Send tickets
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{ route('showTickets', $order->id) }}" target="_blank" class="btn btn-dark btn-header">
                                    <i class="fa-solid fa-print"></i> View tickets
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <table class="table order-table">
                <thead>
                <tr>
                    <th># ID</th>
                    <th>Ticket</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->name }}</td>
                        <td>{{ \App\Helpers\PriceHelper::fromFloatToStr($ticket->price) }}</td>
                        <td>{{ $ticket->discount > 0 ? \App\Helpers\PriceHelper::fromFloatToStr($ticket->discount) : '---' }}</td>
                        <td>{{ \App\Helpers\PriceHelper::fromFloatToStr($ticket->total) }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="cancelDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ...
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cancelDropdown">
                                    <button class="dropdown-item" type="button">Cancel with refund</button>
                                    <button class="dropdown-item" type="button">Cancel without refund</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="order-footer">
                <div>
                    <p>Subtotal: <strong>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->subtotal) }}</strong></p>
                    <p>Discount: <strong>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->discount) }}</strong></p>
                    <p>VAT: <strong>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->vat) }}</strong></p>
                    <p>Total: <strong>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->total) }}</strong></p>
                </div>
            </div>

            <button class="btn btn-dark">
                <i class="fas fa-arrow-left"></i> Cancel & Refund Order
            </button>
        </div>
    </div>
@stop

@section('css')
    <style>
        .order-summary {
            margin-top: 20px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .order-header > div {
            flex: 1;
            padding: 10px;
        }
        .order-header > div:not(:last-child) {
            border-right: 1px solid #ddd;
        }
        .order-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }
        .order-actions a {
            margin-left: 10px;
        }
        .flex-row {
            display: flex;
            flex-direction: row !important;
            margin-bottom: 10px;
        }
        .order-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .order-footer {
            display: flex;
            justify-content: flex-end;
        }
        .order-footer div {
            text-align: right;
            margin-left: 20px;
        }
        .btn-header {
            margin-bottom: 10px;
        }
    </style>
@stop

@section('js')
    <script>

    </script>
@stop
