@extends('page')

@section('title', 'Venues')
@section('title_header', 'Venues')

@section('content')
    <div class="container pt-3">
        @include('messages')
        <div class="card orders-orders">
            <div class="card-header">
                <h5 class="card-title m-0">New Venue</h5>
            </div>
            <div class="card-body">
                <form id="create_tenant" name="create_tenant" action="{{ route('venues.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div
                                class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                id="venue_logo">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Venue Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Venue Name" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Venue Address</label>
                                    <input type="text" class="form-control" name="address" id="name" placeholder="Enter Venue Address" value="{{ old('address') }}">
                                    @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="zipcode">Zipcode</label>
                                    <input type="text" class="form-control" name="zipcode" id="name" placeholder="Enter Zipcode" value="{{ old('zipcode') }}">
                                    @error('zipcode')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city">Address</label>
                                    <input type="text" class="form-control" name="city" id="name" placeholder="Enter Address" value="{{ old('city') }}">
                                    @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" name="country" id="name" placeholder="Enter Country" value="{{ old('country') }}">
                                    @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" id="name" placeholder="Enter Email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="name" placeholder="Enter Phone" value="{{ old('phone') }}">
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" name="website" id="name" placeholder="Enter Website" value="{{ old('website') }}">
                                    @error('website')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="form-group col-md-12">
                            <label for="logo">Description text</label>
                            <textarea class="form-control" rows="6" placeholder="Enter Description text"></textarea>
                        </div>
                    </div>

                    <h4>Seating plan</h4>
                    <!-- Dividing Line -->
                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            We create seating plans tailored to your location. Please contact us here to have a new seating plan created.
                        </div>
                    </div>

                    <div class="form-row mt-2">
                        <div class="form-group col-md-6">
                            <button class="btn btn-primary bg-black border-0" type="button" data-toggle="modal" data-target="#requestSettingPlanModal">
                                <i class="fas fa-comment-alt ml-2"></i>
                                 &nbsp;Request seating plan
                            </button>
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

    <!-- Modal for Changing Password -->
    <div class="modal fade" id="requestSettingPlanModal" tabindex="-1" role="dialog" aria-labelledby="requestSettingPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="requestSettingPlanModalLabel">Request seating plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="subject">Seating Plan</label>
                            <select class="form-control" id="seating" name="seating" required>
                                <option value="">Select a type of Seating Plan</option>
                                <option value="type1">Seating Plan 1</option>
                                <option value="type2">Seating Plan 2</option>
                                <option value="type3">Seating Plan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Type your message. Please be sure to be as specific as possible." required></textarea>
                        </div>

                        <button id="saveNewPassword" type="submit" class="btn btn-primary btn-block">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/venues.css') }}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        let dropzoneLogo = new Dropzone("#venue_logo", {
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
