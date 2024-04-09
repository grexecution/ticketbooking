@extends('page')

@section('title', 'Vouchers')
@section('title_header', 'Vouchers')

@section('content')
    <div class="container pt-3">
        @include('messages')
        <div class="card orders-orders">
            <div class="card-header">
                <h5 class="card-title m-0">New Discount</h5>
            </div>
            <div class="card-body">
                <form id="create_discount" name="create_discount" action="{{ route('discounts.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="name">Voucher Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Voucher Name" value="{{ old('name') }}">
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
                            <label for="artist">Type of discount</label>
                            <select class="form-control" id="type" name="type">
                                <option value="1">Percentage (%)</option>
                                <option value="2">Fixed (Є)</option>
                            </select>
                            @error('type')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="discount">Discount</label>
                            <input type="text" class="form-control" name="discount" id="discount" placeholder="Enter Discount" value="{{ old('discount') }}">
                            @error('discount')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h4 class="mt-4">Limitations</h4>
                    <!-- Dividing Line -->
                    <hr>

                    <div class="row mt-2">
                        <div class="form-group col-md-3">
                            <label for="discount">Maximum usage</label>
                            <input type="number" class="form-control" name="max_usage" id="max_usage" min="1" placeholder="0 = no limit" value="{{ old('max_usage') }}">
                            @error('max_usage')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="expire_date">Expiry Date</label>
                            <span class="float-right text-muted">Ends at 11:59 p.m</span>
                            <div class="input-group">
                                <input type="text" class="form-control date" id="expire_date" name="expire_date">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                @error('expire_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 mb-4">
                            <h4>Events</h4>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ __('Select All') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ __('Deselect All') }}</span>
                                <span class="float-right text-muted">Leave blank to select all</span>
                            </div>
                            <div class="form-group">
                                <select class="form-control select2" id="selectEvent" multiple="multiple">
                                    <option value="discount1">Event 1</option>
                                    <option value="discount2">Event 2</option>
                                    <option value="discount3">Event 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12 mb-4">
                            <h4>Exclude events</h4>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-exclude-all" style="border-radius: 0">{{ __('Select All') }}</span>
                                <span class="btn btn-info btn-xs deselect-exclude-all" style="border-radius: 0">{{ __('Deselect All') }}</span>
                                <span class="float-right text-muted">Leave blank to select all</span>
                            </div>
                            <div class="form-group">
                                <select class="form-control select2" id="selectExcludeEvent" multiple="multiple">
                                    <option value="discount1">Event 1</option>
                                    <option value="discount2">Event 2</option>
                                    <option value="discount3">Event 3</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
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
    <link rel="stylesheet" href="{{ asset('css/discounts.css') }}">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Include events select
            $('#selectEvent').select2();
            // Add event listener for "Select All" button
            $('.select-all').on('click', function() {
                $('#selectEvent').find('option').prop('selected', true); // Select all options
                $('#selectEvent').trigger('change'); // Trigger change event for Select2
            });
            // Add event listener for "Deselect All" button
            $('.deselect-all').on('click', function() {
                $('#selectEvent').find('option').prop('selected', false); // Deselect all options
                $('#selectEvent').trigger('change'); // Trigger change event for Select2
            });

            // Exclude events select
            $('#selectExcludeEvent').select2();
            // Add event listener for "Select All" button
            $('.select-exclude-all').on('click', function() {
                $('#selectExcludeEvent').find('option').prop('selected', true); // Select all options
                $('#selectExcludeEvent').trigger('change'); // Trigger change event for Select2
            });
            // Add event listener for "Deselect All" button
            $('.deselect-exclude-all').on('click', function() {
                $('#selectExcludeEvent').find('option').prop('selected', false); // Deselect all options
                $('#selectExcludeEvent').trigger('change'); // Trigger change event for Select2
            });
        });
    </script>
@stop
