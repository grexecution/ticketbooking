@extends('page')

@section('title', 'New Event')
@section('title_header', 'New Event')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">New Event</h5>
            </div>
            <div class="card-body">
                <form id="create_event" action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-4">
                        <!-- Basic Information -->
                        <div class="col-md-12 mb-4">
                            <h4>Basic Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="padding-bottom: 4px">
                                        <span class="btn btn-info btn-xs select-all-artists" style="border-radius: 0">{{ __('Select All') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all-artists" style="border-radius: 0">{{ __('Deselect All') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="selectArtist">Artist</label>
                                        <select class="form-control select2" id="selectArtist" name="artist_ids[]" multiple="multiple">
                                            @foreach($artists as $artist)
                                                <option value="{{ $artist->id }}" {{ in_array($artist->id, old('artist_ids') ?? []) ? 'selected' : '' }}>{{ $artist->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('artist_ids')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="selectProgram">Program / Event Series</label>
                                        <select class="form-control select2" id="selectProgram" name="program_id">
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" {{ $program->id == old('program_id') ? 'selected' : '' }}>{{ $program->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('program_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Second Row -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="event_name">Event Name</label>
                                    <!-- Text input for Event Name -->
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Event Name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="venue">Venue</label>
                                    <!-- Select input for Venue -->
                                    <select class="form-control" id="venue" name="venue_id">
                                        @foreach($venues as $venue)
                                            <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('venue_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Third Row -->
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="start_date">Date</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control date" id="start_date" name="start_date" value="{{ old('start_date') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="start_time">Event Start</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" id="start_time" name="start_time" value="{{ old('start_time') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        @error('start_time')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="doors_open_time">Doors Open</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control timepicker" id="doors_open_time" name="doors_open_time" value="{{ old('doors_open_time') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                        </div>
                                        @error('doors_open_time')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="price">Ticket Price</label>
                                    <span class="float-right text-muted">Gross</span>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">€</span>
                                        </div>
                                        <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
                                        @error('price')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
                                        id="logo">
                                    </div>
                                    @error('logo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="form-group col-md-12">
                                    <label for="description">Event description</label>
                                    <textarea name="description" class="form-control" rows="12" placeholder="Enter Event Description">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                <select name="discount_ids[]" class="form-control select2" id="selectDiscount" multiple="multiple">
                                    @foreach($discounts as $discount)
                                        <option value="{{ $discount->id }}" {{ in_array($discount->id, old('discount_ids') ?? []) ? 'selected' : '' }}>{{ $discount->name }}</option>
                                    @endforeach
                                </select>
                                @error('discount_ids')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                    id="partners">
                                </div>
                                @error('partners')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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
            $('#selectProgram').select2({
                tags: true,
                tokenSeparators: [','],
            });
            $('#selectArtist').select2({
                tags: true,
                tokenSeparators: [','],
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

            // Add event listener for "Select All" Artist button
            $('.select-all-artists').on('click', function() {
                $('#selectArtist').find('option').prop('selected', true); // Select all options
                $('#selectArtist').trigger('change'); // Trigger change event for Select2
            });
            // Add event listener for "Deselect All" Artist button
            $('.deselect-all-artists').on('click', function() {
                $('#selectArtist').find('option').prop('selected', false); // Deselect all options
                $('#selectArtist').trigger('change'); // Trigger change event for Select2
            });

            let dropzoneSponsors = new Dropzone("#partners", {
                url: '{{ route('media.upload_file') }}',
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
                    $('#create_event').append('<input type="hidden" name="partners[]" value="' + response.name + '">')
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    if (file.status !== 'error') {
                        $('#create_event').find('input[name="partners[]"]').remove()
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

            let dropzoneLogo = new Dropzone("#logo", {
                url: '{{ route('media.upload_file') }}',
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
                    $('#create_event').append('<input type="hidden" name="logo" value="' + response.name + '">')
                    $('#create_event').append('<input type="hidden" name="logo_origin_names[' + response.name + ']" value="' + response.original_name + '">')
                    $('#create_event').append('<input type="hidden" name="logo_sizes[' + response.name + ']" value="' + response.size + '">')
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    if (file.status !== 'error') {
                        $('#create_event').find('input[name="logo"]').remove()
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
