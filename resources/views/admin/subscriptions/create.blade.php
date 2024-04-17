@extends('page')

@section('title', 'Subscription')
@section('title_header', 'Subscription')

@section('content')
    <div class="container pt-3">
        @include('messages')
        <div class="card orders-orders">
            <div class="card-header">
                <h5 class="card-title m-0">New Subscription</h5>
            </div>
            <div class="card-body">
                <form id="create_subscription" name="create_subscription" action="{{ route('subscriptions.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="name">Subscription Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Subscription Name" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="short_desc">Internal description</label>
                            <span class="float-right text-muted">Not visible to customers</span>
                            <input type="text" class="form-control" name="short_desc" id="short_desc" placeholder="Enter Internal description" value="{{ old('short_desc') }}">
                            @error('short_desc')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="price">Subscription Price</label>
                            <span class="float-right text-muted">Gross</span>
                            <input type="number" min="0" step="0.1" class="form-control" name="price" id="price" placeholder="Enter Subscription Price" value="{{ old('price') }}">
                            @error('price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="form-group col-md-9">
                            <label for="description">Description text</label>
                            <textarea name="description" class="form-control" rows="6" placeholder="Enter Description text">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="logo">Subscription image</label>
                            <div
                                class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                id="logo">
                            </div>
                            @error('logo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Prices -->
                    <div class="row mt-4">
                        <div class="col-md-12 mb-4">
                            <div class="row">
                                <div class="col-md-2">
                                    <div>Add events</div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-right" style="padding-bottom: 4px">
                                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ __('Select All') }}</span>
                                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ __('Deselect All') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <select name="event_ids[]" class="form-control select2" id="selectEvent" multiple="multiple">
                                                @foreach($events as $event)
                                                    <option value="{{ $event->id }}" {{ in_array($event->id, old('event_ids') ?? []) ? 'selected' : '' }}>{{ $event->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('event_ids')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Event Name</th>
                                            <th>Seat Category</th>
                                            <th>Sales volume</th>
                                            <th></th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Bottom row here -->
                                            <tr>
                                                <td class="font-weight-bold" colspan="2">Subscription: Flo & Wisch - All shows</td>
                                                <td class="font-weight-bold" colspan="2">Number of shows: 5</td>
                                                <td class="font-weight-bold">Total: 365.90</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    <link rel="stylesheet" href="{{ asset('css/subscriptions.css') }}">
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

            // Function to add a new row to the table
            function addNewRow(eventId) {
                // Make an AJAX call to the API endpoint to fetch data for the new row
                let getDataRoute = '{{ route('events.getData', ':id') }}';
                getDataRoute = getDataRoute.replace(':id', eventId);
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: getDataRoute,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
                    },
                    success: function(response) {
                        // Create a new row element
                        const newRow = '<tr>' +
                            '<td>' + response.name + '</td>' +
                            '<td>' +
                                `<button type="button" class="btn btn-dark">
                                    Category A
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-dark">
                                    Category VIP
                                    <i class="fas fa-times"></i>
                                </button>
                                ` +
                            '</td>' +
                            '<td>' +
                                `<div class="input-group">
                                    <input type="text" class="form-control" id="percentageInput" placeholder="Enter percentage" aria-describedby="percentageAddon">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="percentageAddon">
                                            <i class="fas fa-percent"></i>
                                        </span>
                                    </div>
                                </div>` +
                            '</td>' +
                            '<td>= €73.18</td>' +
                            '<td>' +
                            '<button type="button" class="btn btn-danger mx-2 delete-record" data-record-id="' + response.id + '" data-toggle="modal" data-target="#confirmModal">' +
                            '<i class="fas fa-trash"></i>' +
                            '</button>' +
                            '</td>' +
                            '</tr>';

                        // Append the new row to the table body
                        $('table tbody').append(newRow);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(error);
                    }
                });
            }

            // Event listener for select2 select event
            $('#selectEvent').on('select2:select', function (e) {
                // Get the selected event ID
                var eventId = e.params.data.id;

                // Add a new row to the table with data for the selected event
                addNewRow(eventId);
            });
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
                $('#create_subscription').append('<input type="hidden" name="logo" value="' + response.name + '">')
                $('#create_subscription').append('<input type="hidden" name="logo_origin_names[' + response.name + ']" value="' + response.original_name + '">')
                $('#create_subscription').append('<input type="hidden" name="logo_sizes[' + response.name + ']" value="' + response.size + '">')
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.status !== 'error') {
                    $('#create_subscription').find('input[name="logo"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
                }
            },
            init: function () {
                //
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
    </script>
@stop
