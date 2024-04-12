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
                <form id="create_discount" name="create_discount" action="{{ route('discounts.store') }}" method="post" enctype="multipart/form-data">
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
    <link rel="stylesheet" href="{{ asset('css/discounts.css') }}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // General Select2 plugin settings
            let $select2 = $('.select2');
            $select2.select2();
            $select2.on('select2:select', function (e) {
                //Append selected element to the end of the list, otherwise it follows the same order as the dropdown
                var element = e.params.data.element;
                var $element = $(element);
                $(this).append($element);
                $(this).trigger("change");
            })

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
        });
    </script>
@stop
