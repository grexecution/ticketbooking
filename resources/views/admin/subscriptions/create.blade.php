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
                <form id="create_tenant" name="create_tenant" action="{{ route('subscriptions.store') }}" method="post" enctype="multipart/form-data">
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
                            <label for="description">Internal description</label>
                            <span class="float-right text-muted">Not visible to customers</span>
                            <input type="text" class="form-control" name="description" id="name" placeholder="Enter Internal description" value="{{ old('description') }}">
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label for="price">Subscription Price</label>
                            <span class="float-right text-muted">Gross</span>
                            <input type="text" class="form-control" name="address" id="price" placeholder="Enter Subscription Price" value="{{ old('price') }}">
                            @error('price')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="form-group col-md-9">
                            <label for="logo">Description text</label>
                            <textarea class="form-control" rows="6" placeholder="Enter Description text"></textarea>
                            @error('website')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="price">Subscription image</label>
                            <div
                                class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                id="subscription_logo">
                            </div>
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
                                            <select class="form-control select2" id="selectEvent" multiple="multiple">
                                                <option value="discount1">Event 1</option>
                                                <option value="discount2">Event 2</option>
                                                <option value="discount3">Event 3</option>
                                            </select>
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
                                            <tr>
                                                <td>
                                                    Orpheum - Flo & Wisch - May 23, 2024
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-dark">
                                                        Category A
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-dark">
                                                        Category VIP
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="percentageInput" placeholder="Enter percentage" aria-describedby="percentageAddon">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="percentageAddon">
                                                                <i class="fas fa-percent"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>= €73.18</td>
                                                <td>
                                                    <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Orpheum - Flo & Wisch - May 24, 2024
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-dark">
                                                        Category VIP
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-dark">
                                                        Category B
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="percentageInput" placeholder="Enter percentage" aria-describedby="percentageAddon">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="percentageAddon">
                                                                <i class="fas fa-percent"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>= €73.18</td>
                                                <td>
                                                    <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

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
        $(document).ready(function() {
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

            let $select2 = $('.select2');
            $select2.select2();
            $select2.on('select2:select', function (e) {
                //Append selected element to the end of the list, otherwise it follows the same order as the dropdown
                var element = e.params.data.element;
                var $element = $(element);
                $(this).append($element);
                $(this).trigger("change");
            })
        });

        let dropzoneLogo = new Dropzone("#subscription_logo", {
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
    </script>
@stop
