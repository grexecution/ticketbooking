@extends('page')

@section('title', 'Discounts')
@section('title_header', 'Discounts')

@section('content')
    <div class="container pt-3">
        @include('messages')
        <div class="card orders-orders">
            <div class="card-header">
                <h5 class="card-title m-0">New Discount</h5>
            </div>
            <div class="card-body">
                <form id="create_discount" name="create_discount" action="{{ route('discounts.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="name">Discounts Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Discounts Name" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Internal description</label>
                            <span class="float-right text-muted">Not visible to customers</span>
                            <input type="text" class="form-control" name="description" id="name" placeholder="Enter Internal description" value="{{ old('description') }}">
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="row mt-4">
                        <div class="form-group col-md-3">
                            <label for="type">Type of discount</label>
                            <select class="form-control" id="type" name="type">
                                <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed (Є)</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="discount">Discount</label>
                            <input type="number" step="0.1" min="0" class="form-control" name="discount" id="discount" placeholder="Enter Discount" value="{{ old('discount') }}">
                            @error('discount')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h4 class="mt-5">Danger</h4>
                    <!-- Dividing Line -->
                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-12 text-muted">
                            Customers can choose their own discounts. The organizer is responsible for checking upon entry!
                        </div>
                    </div>

                    <!-- Footer with Buttons -->
                    <div class="row mt-3">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-dark">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@stop
