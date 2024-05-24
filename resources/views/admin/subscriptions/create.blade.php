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
                            <textarea
                                class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                name="description"
                                placeholder="Enter Subscription Description"
                                id="description">{!! old('description') ?? "" !!}
                            </textarea>
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

                    <!-- subscription-events -->
                    <subscription-events
                        :init-name="'{{ old('name', $subscription?->name ?? null) }}'"
                        :init-price="'{{ old('price', $subscription?->price ?? null) }}'"
                        :init-selected-events="{{ json_encode($selectedEvents ?? []) }}"
{{--                        :init-event-ids="[{{ old('event_ids', $subscription ? $subscription?->events?->pluck('id')?->implode(',') : '') ?? '[]' }}]"--}}
                    ></subscription-events>
                    @error('event_ids')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <!-- subscription-events (END) -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description');
        });

        Dropzone.autoDiscover = false; // Prevent Dropzone from automatically attaching to all elements with the class "dropzone"

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
