@extends('page')

@section('title', 'Tenants')
@section('title_header', 'Tenants')

@section('content')
    <div class="container pt-3">
        @include('messages')
            <div class="card orders-orders">
                <div class="card-header">
                    <h5 class="card-title m-0">New Tenant</h5>
                </div>
                <div class="card-body">
                    <form id="create_tenant" name="create_tenant" action="{{ route('tenants.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="name">Tenant Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Tenant Name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="company">Tenant Company Name</label>
                                    <span class="text-muted">Not visible to customers</span>
                                </div>
                                <input type="text" class="form-control" name="company" id="company" placeholder="Enter Tenant Name" value="{{ old('company') }}">
                                @error('company')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="logo">Tenant Logo</label>
                                <div
                                    class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                    id="logo">
                                </div>
                                @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

{{--                        <h4 class="mt-5">Payment connection via Stripe</h4>--}}
{{--                        <!-- Dividing Line -->--}}
{{--                        <hr>--}}

{{--                        <div class="form-row">--}}
{{--                            <div class="form-group col-md-6">--}}
{{--                                <label for="stripe_key">Stripe Key</label>--}}
{{--                                <input type="password" class="form-control" name="stripe_key" id="stripe_key" placeholder="Enter First Name" value="{{ old('stripe_key') }}">--}}
{{--                                @error('stripe_key')--}}
{{--                                <span class="text-danger">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="form-group col-md-6">--}}
{{--                                <label for="stripe_secret">Stripe Secret</label>--}}
{{--                                <input type="password" class="form-control" name="stripe_secret" id="stripe_secret" placeholder="Enter Stripe Secret" value="{{ old('stripe_secret') }}">--}}
{{--                                @error('stripe_secret')--}}
{{--                                <span class="text-danger">{{ $message }}</span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <a href="#" target="_blank" class="btn btn-dark">--}}
{{--                                <i class="fas fa-plug ml-2"></i>--}}
{{--                                Check connection--}}
{{--                            </a>--}}
{{--                            @error('check_connection')--}}
{{--                            <span class="text-danger">{{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}

                        <br>
                        <br>

                        <h4>Platform fees</h4>
                        <!-- Dividing Line -->
                        <hr>

                        <div class="form-group">
                            <div class="form-group col-md-4">
                                <label for="stripe_fee">Platform fees</label>
                                <input type="number" min="0" class="form-control" name="stripe_fee" id="stripe_fee" placeholder="Enter Platform Fee" value="{{ old('stripe_fee') }}">
                                @error('stripe_fee')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false; // Prevent Dropzone from automatically attaching to all elements with the class "dropzone"

        $(document).ready(function() {
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
                    $('#create_tenant').append('<input type="hidden" name="logo" value="' + response.name + '">')
                    $('#create_tenant').append('<input type="hidden" name="logo_origin_names[' + response.name + ']" value="' + response.original_name + '">')
                    $('#create_tenant').append('<input type="hidden" name="logo_sizes[' + response.name + ']" value="' + response.size + '">')
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    if (file.status !== 'error') {
                        $('#create_tenant').find('input[name="logo"]').remove()
                        this.options.maxFiles = 1
                    }
                },
                init: function () {
                    //
                },
                error: function (file, response) {
                    let message = $.type(response) === 'string' ? response : response.errors.file;
                    file.previewElement.classList.add('dz-error');
                    let _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]');
                    _ref.forEach(node => {
                        node.textContent = message;
                    });
                }
            });
        });
    </script>
@stop
