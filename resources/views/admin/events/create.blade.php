@extends('page')

@section('title', 'Events')
@section('title_header', 'Events')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <div class="container bg-white">
            <!-- First block -->
            <div class="row py-3">
                <!-- First column with event details -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-2">
                            <p>FEB 12</p>
                            <p>2024</p>
                            <p>Sat - 8:15 p.m</p>
                        </div>
                        <div class="col-md-10">
                            <p><i class="fas fa-map-marker-alt"></i> Orpheum Vienna</p>
                            <h2>Flo & Wisch - Bauchgefühle</h2>
                        </div>
                    </div>
                </div>
                <!-- Second column with buttons -->
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-warning text-white"><i class="fas fa-qrcode"></i></button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-dark"><i class="fas fa-print"></i></button>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-secondary"><i class="fas fa-link"></i></button>
                        </div>
                        <div class="col-md-3">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status: Live
                                </button>
                                <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                    <a class="dropdown-item" href="#">Live</a>
                                    <a class="dropdown-item" href="#">Scheduled</a>
                                    <a class="dropdown-item" href="#">Cancelled</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Separated line -->
            <hr>
            <!-- Second block -->
            <div class="row py-3">
                <div class="col-md-4">
                    <img src="{{ asset('img/sales.png') }}" alt="Sales Image" width="91" height="70">
                    <div>Sales Volume</div>
                    <div>€3.450</div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('img/booking.png') }}" alt="Bookings Image" width="91" height="70">
                    <div>Bookings</div>
                    <div>166 / 200</div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('img/checkin.png') }}" alt="Check-ins Image" width="91" height="70">
                    <div>Check-ins</div>
                    <div>0 / 200</div>
                    <div class="text-right text-secondary">Inactive</div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Existing content here -->

            <!-- Horizontal tabs -->
            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="seating-tab" data-toggle="tab" href="#seating" role="tab" aria-controls="seating" aria-selected="true">Seating Plan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab" aria-controls="bookings" aria-selected="false">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active bg-white" id="seating" role="tabpanel" aria-labelledby="seating-tab">
                    <!-- Seats and Pricing Content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <!-- Seats and Pricing -->
                            <div class="row mt-4">
                                <!-- Pricing Blocks -->
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="{{ asset('img/seat_A.png') }}" alt="Small Image" class="img-fluid">
                                            <div class="pricing-info">
                                                <div>Category A</div>
                                                <div>€ 28,00</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ asset('img/seat_B.png') }}" alt="Small Image" class="img-fluid">
                                            <div class="pricing-info">
                                                <div>Category B</div>
                                                <div>€ 38,00</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ asset('img/seat_C.png') }}" alt="Small Image" class="img-fluid">
                                            <div class="pricing-info">
                                                <div>Category C</div>
                                                <div>€ 38,00</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ asset('img/seat_D.png') }}" alt="Small Image" class="img-fluid">
                                            <div class="pricing-info">
                                                <div>Category D</div>
                                                <div>€ 8,00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Seat Layout -->
                            <div class="row mt-4 mb-5">
                                <div class="col">
                                    <div class="text-center mb-2">STAGE</div>
                                    <div class="seat-layout">
                                        <div class="row">
                                            <div class="col-1"></div>
                                            @for($k = 0; $k < 10; $k++)
                                                <div class="col seat-header">{{chr(65 + $k)}}</div>
                                            @endfor
                                        </div>
                                        @for($i = 0; $i < 10; $i++)
                                            <div class="row">
                                                <div class="col-1">{{$i + 1}}</div>
                                                @for($j = 0; $j < 10; $j++)
                                                    <div class="col seat">
                                                        <img src="{{ asset('img/seat_A.png') }}" alt="Specific Seat" class="img-fluid m-1" onclick="openPopup('Row {{ $i + 1 }} - Seat {{ chr(65 + $j) }}', '€ 39,90')">
                                                    </div>
                                                @endfor
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade bg-white" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                    <!-- Bookings content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <!-- Event Table -->
                            <div class="row mt-5 mx-3">
                                <div class="col">
                                    <table class="table table-full-width">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Customer</th>
                                            <th>Places</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="">
                                            <td>
                                                <span>#22398</span>
                                            </td>
                                            <td>
                                                <div>
                                                    Gregor Wallner
                                                </div>
                                            </td>
                                            <td>
                                                <div>A1, A2, A3, A5, D6</div>
                                            </td>
                                            <td>
                                                <div>
                                                    30.06.2024
                                                </div>
                                                <div>
                                                    16:31
                                                </div>
                                            </td>
                                            <td>€ 133,00</td>
                                            <td>
                                                <a href="#" class="btn btn-dark mx-2">Completed</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-warning mx-2">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                    More
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade bg-white" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                    <!-- Invoice content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <h2>COMING SOON</h2>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade bg-white" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <!-- Settings content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <div class="row mt-4">
                                    <!-- Basic Information -->
                                    <div class="col-md-12 mb-4">
                                        <h4>Basic Information</h4>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div style="padding-bottom: 4px">
                                                    <span class="btn btn-info btn-xs select-all-artist" style="border-radius: 0">{{ __('Select All') }}</span>
                                                    <span class="btn btn-info btn-xs deselect-all-artist" style="border-radius: 0">{{ __('Deselect All') }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="selectArtist">Artist</label>
                                                    <select class="form-control select2" id="selectArtist" name="selectArtist" multiple="multiple">
                                                        <option value="discount1">Artist 1</option>
                                                        <option value="discount2">Artist 2</option>
                                                        <option value="discount3">Artist 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="selectProgram">Program / Event Series</label>
                                                    <select class="form-control select2" id="selectProgram" name="selectProgram">
                                                        <option value="discount1">Program 1</option>
                                                        <option value="discount2">Program 2</option>
                                                        <option value="discount3">Program 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Second Row -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="event_name">Event Name</label>
                                                <!-- Text input for Event Name -->
                                                <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Enter Event Name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="venue">Venue</label>
                                                <!-- Select input for Venue -->
                                                <select class="form-control" id="venue" name="venue">
                                                    <option value="1">Venue 1</option>
                                                    <option value="2">Venue 2</option>
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Third Row -->
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <label for="event_date">Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control date" id="event_date" name="event_date">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="event_start">Event Start</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control timepicker" id="event_start" name="event_start">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="doors_open">Doors Open</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control timepicker" id="doors_open" name="doors_open">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="ticket_price">Ticket Price</label>
                                                <span class="float-right text-muted">Gross</span>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">€</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="ticket_price" name="ticket_price">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detailed Information -->
                                <div class="row mt-4">
                                    <div class="col-md-12 mb-4">
                                        <h4>Detailed Information</h4>
                                        <!-- Detailed Information -->
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label for="logo">Short Description</label>
                                                <textarea class="form-control" rows="4" placeholder="Enter Short Description"></textarea>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="logo">Event Picture</label>
                                                <div
                                                    class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                                    id="event_logo">
                                                </div>
                                                @error('logo')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="form-group col-md-12">
                                                <label for="logo">Event description</label>
                                                <textarea class="form-control" rows="12" placeholder="Enter Event Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Prices -->
                                <div class="row mt-4">
                                    <div class="col-md-12 mb-4">
                                        <h4>Prices</h4>
                                        <!-- First Row - Seating Options -->
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="seating">Seating</label>
                                                    <span class="float-right text-muted">Price type can no longer be changed</span>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="seatingOption" id="seatplan" value="seatplan" checked>
                                                        <label class="form-check-label" for="seatplan">
                                                            Seatplan Selection
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="seatingOption" id="no_seatplan" value="no_seatplan">
                                                        <label class="form-check-label" for="no_seatplan">
                                                            No Seat Selection
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="seating">Seating plan</label>
                                                    <span class="float-right text-muted">Seating plan can no longer be changed</span>
                                                    <select class="form-control" id="seating">
                                                        <option value="seatplan">Orpheum Vienna Medium (320 seats)</option>
                                                        <option value="no_seatplan">Orpheum Vienna Small (150 seats)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Second Row - Pricing Table -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Description</th>
                                                        <th>Places</th>
                                                        <th>Price (€)</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="text" class="form-control" value="Category A"></td>
                                                        <td><input type="text" class="form-control" placeholder="Enter description text"></td>
                                                        <td><input type="number" class="form-control" value="10"></td>
                                                        <td><input type="number" class="form-control" value="28"></td>
                                                        <td>
                                                            <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <!-- Add more rows as needed -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Discounts -->
                                <div class="row mt-4">
                                    <div class="col-md-12 mb-4">
                                        <h4>Discounts</h4>
                                        <div style="padding-bottom: 4px">
                                            <span class="btn btn-info btn-xs select-all-discount" style="border-radius: 0">{{ __('Select All') }}</span>
                                            <span class="btn btn-info btn-xs deselect-all-discount" style="border-radius: 0">{{ __('Deselect All') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="selectDiscount">Select Discount</label>
                                            <select class="form-control select2" id="selectDiscount" multiple="multiple">
                                                <option value="discount1">Discount 1</option>
                                                <option value="discount2">Discount 2</option>
                                                <option value="discount3">Discount 3</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Event Sponsors -->
                                <div class="row mt-4">
                                    <div class="col-md-12 mb-4">
                                        <h4>Event Sponsors</h4>
                                        <div class="form-group">
                                            <p>Auf den Tickets sowie auf der Eventseite haben Sie die Möglichkeit Ihre Sponsoren hervorzuheben.
                                                Minimum 400 X 400 Pixelbreite. Erlaubte Dateiformate: PNG, JPG, SVG</p>
                                        </div>
                                        <div class="form-group">
                                            <div
                                                class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                                id="sponsors_media">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Save Button -->
                                <div class="row justify-content-end mt-4">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-dark btn-block">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmModalLabel">Confirm Action</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-light" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        Dropzone.autoDiscover = false; // Prevent Dropzone from automatically attaching to all elements with the class "dropzone"

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

            $('#selectDiscount').select2();
            $('#selectProgram').select2();
            $('#selectArtist').select2({
                tags: true,
                tokenSeparators: [',', ' '],
            });

            // Add event listener for "Select All" Discounts button
            $('.select-all-discount').on('click', function() {
                $('#selectDiscount').find('option').prop('selected', true); // Select all options
                $('#selectDiscount').trigger('change'); // Trigger change event for Select2
            });
            // Add event listener for "Deselect All" Discounts button
            $('.deselect-all-discount').on('click', function() {
                $('#selectDiscount').find('option').prop('selected', false); // Deselect all options
                $('#selectDiscount').trigger('change'); // Trigger change event for Select2
            });

            // Add event listener for "Select All" Program button
            $('.select-all-program').on('click', function() {
                $('#selectProgram').find('option').prop('selected', true); // Select all options
                $('#selectProgram').trigger('change'); // Trigger change event for Select2
            });
            // Add event listener for "Deselect All" Program button
            $('.deselect-all-program').on('click', function() {
                $('#selectProgram').find('option').prop('selected', false); // Deselect all options
                $('#selectProgram').trigger('change'); // Trigger change event for Select2
            });

            let dropzoneSponsors = new Dropzone("#sponsors_media", {
                url: 'admin/media/upload',
                maxFilesize: 50, // MB
                maxFiles: 20,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 50
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="sponsors_media[]" value="' + response.name + '">')
                    $('form').append('<input type="hidden" name="sponsors_media_origin_names[' + response.name + ']" value="' + response.original_name + '">')
                    $('form').append('<input type="hidden" name="sponsors_media_sizes[' + response.name + ']" value="' + response.size + '">')
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    if (file.status !== 'error') {
                        $('form').find('input[name="sponsors_media[]"]').remove()
                        this.options.maxFiles = this.options.maxFiles + 1
                    }
                },
                init: function () {
                    // Auto-dismiss notifications after 5 seconds (5000 milliseconds)
                    setTimeout(function() {
                        $('.alert-hide').alert('close');
                    }, 5000);
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        let message = response // dropzone sends it's own error messages in string
                    } else {
                        let message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            let dropzoneLogo = new Dropzone("#event_logo", {
                url: 'admin/media/upload',
                maxFilesize: 50, // MB
                maxFiles: 1,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 50
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="event_logo" value="' + response.name + '">')
                    $('form').append('<input type="hidden" name="event_logo_origin_names[' + response.name + ']" value="' + response.original_name + '">')
                    $('form').append('<input type="hidden" name="event_logo_sizes[' + response.name + ']" value="' + response.size + '">')
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    if (file.status !== 'error') {
                        $('form').find('input[name="event_logo"]').remove()
                        this.options.maxFiles = this.options.maxFiles + 1
                    }
                },
                init: function () {
                    // Auto-dismiss notifications after 5 seconds (5000 milliseconds)
                    setTimeout(function() {
                        $('.alert-hide').alert('close');
                    }, 5000);
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        let message = response // dropzone sends it's own error messages in string
                    } else {
                        let message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

            $('#confirmModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const recordId = button.data('record-id'); // Extract record ID from data attribute
                const deleteButton = $(this).find('#confirmDelete'); // Find the delete button in the modal

                // Set the route path for deleting the record
                let deleteRoute = '{{ route('tenants.destroy', ':id') }}';
                deleteRoute = deleteRoute.replace(':id', recordId);

                // Set the onclick event for the delete button to redirect to the delete route
                deleteButton.click(function() {
                    window.location.href = deleteRoute;
                });
            });
        });
    </script>
@stop
