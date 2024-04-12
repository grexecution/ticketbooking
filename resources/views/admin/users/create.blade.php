@extends('page')

@section('title', 'Users')
@section('title_header', 'Users')

@section('content')
    <div class="container pt-3">
        @include('messages')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">New User</h5>
                </div>
                <div class="card-body">
                    <form id="create_user" name="create_user" action="{{ route('users.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" value="{{ old('first_name') }}">
                                @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter First Name" value="{{ old('last_name') }}">
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="{{ old('password') }}">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selectTenant">Tenant</label>
                                    <select class="form-control select2" id="selectTenant" name="tenant_id">
                                        <option value="0" disabled selected>Select tenant</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tenant_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="google2fa_enable">Enable 2FA</label>
                                <select class="form-control" name="google2fa_enable">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('google2fa_enable')
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
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#selectTenant').select2();
        });
    </script>
@stop
