@extends('page')

@section('title', 'Dashboard')
@section('title_header', 'Dashboard')

@section('content')
    <div class="container pt-3">
        @include('messages')
        <div class="row">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalEvents }}</h3>
                        <p>Total Events</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalSum }},00<sup style="font-size: 20px">€</sup></h3>
                        <p>Total Revenue</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        <div class="card seats-plan">
            <div class="card-body">
                <!-- Search and Sort -->
                    <h3 class="card-title">
                        Newest Orders
                    </h3>
                <!-- Event Table -->
                <div class="row mt-5">
                    <div class="col">
                        <table class="table table-full-width">
                            <thead>
                            <tr class="d-table-row">
                                <th>Id</th>
                                <th>Customer</th>
                                <th>Seats</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders->sortByDesc('created_at') as $order)
                                <tr class="">
                                    <td>
                                        <span>#{{ $order->id }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <div>
                                                {{ $order->first_name }} {{ $order->last_name }}
                                            </div>
                                            <small>{{ $order->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            Free choice of seats
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y') }}
                                        </div>
                                        <div>
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->total) }}</td>
                                    <td>
                                        <a href="#" class="btn btn-dark mx-0">
                                            {{ ucfirst($order->order_status) }}
                                        </a>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning mx-0">
                                            <i class="fas fa-ellipsis-v"></i>
                                            More
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
