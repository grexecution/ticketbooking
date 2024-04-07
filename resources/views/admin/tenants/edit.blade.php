@extends('page')

@section('title', 'My Account')
@section('title_header', 'My Account')

@section('content')
    <div class="container pt-3">
        @include('messages')
        <div class="card orders-orders">
            <div class="card-header">
                <h5 class="card-title m-0">Edit Tenant</h5>
            </div>
            <div class="card-body">
                <form id="update_tenant" name="update_tenant" action="{{ route('tenants.update', $tenant->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input name="id" type="hidden" value="{{ $tenant->id }}" />
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name">Tenant Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Tenant Name" value="{{ old('name', $tenant->name) }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="company">Tenant Company Name</label>
                                <span class="text-muted">Not visible to customers</span>
                            </div>
                            <input type="text" class="form-control" name="company" id="company" placeholder="Enter Tenant Name" value="{{ old('company', $tenant->company) }}">
                            @error('company')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="logo">Tenant Logo</label>
                            <input type="file" name="logo" class="form-control-file" id="logo">
                            @error('logo')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <h4 class="mt-5">Payment connection via Stripe</h4>
                    <!-- Dividing Line -->
                    <hr>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="stripe_key">Stripe Key</label>
                            <input type="password" class="form-control" name="stripe_key" id="stripe_key" placeholder="Enter First Name" value="{{ old('stripe_key', $tenant->stripe_key) }}">
                            @error('stripe_key')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stripe_secret">Stripe Secret</label>
                            <input type="password" class="form-control" name="stripe_secret" id="stripe_secret" placeholder="Enter Stripe Secret" value="{{ old('stripe_secret', $tenant->stripe_secret) }}">
                            @error('stripe_secret')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="#" target="_blank" class="btn btn-dark">
                            <i class="fas fa-plug ml-2"></i>
                            Check connection
                        </a>
                        @error('check_connection')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <br>
                    <br>

                    <h4>Platform fees</h4>
                    <!-- Dividing Line -->
                    <hr>

                    <div class="form-group">
                        <div class="form-group col-md-4">
                            <label for="stripe_fee">Platform fees</label>
                            <input type="number" min="0" class="form-control" name="stripe_fee" id="stripe_fee" placeholder="Enter Platform Fee" value="{{ old('stripe_fee', $tenant->stripe_fee) }}">
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
    <link rel="stylesheet" href="{{ asset('css/account.css') }}">
@stop

@section('js')
    <script>

    </script>
@stop
