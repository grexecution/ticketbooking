@extends('page')

@section('title', 'My Account')
@section('title_header', 'My Account')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <div class="row">
            <!-- Left Column with Vertical Tabs -->

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <div class="col-md-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">Account</a>
                    <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">Payments</a>
                    <button class="btn btn-light btn-block mt-3" style="color: red; border: 1px solid red;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
                </div>
            </div>

            <!-- Right Column with Tab Content -->
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Tab Content for Account -->
                    <div class="tab-pane fade show active" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                        <!-- Card with Personal Information -->
                        <div class="card account-settings">
                            <div class="card-header">
                                <h5 class="card-title m-0">Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <!-- Form with 3 Rows -->
                                <form id="updateAccount" action="{{ route('settings.updateAccount') }}" method="post">
                                    @csrf
                                    <!-- First Row -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" name="first_name" id="firstName" placeholder="Enter First Name" value="{{ old('first_name', $user->first_name) }}">
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Enter Last Name" value="{{ old('last_name', $user->last_name) }}">
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="form-group">
                                        <label for="emailAddress">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="emailAddress" placeholder="Enter Email Address" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Dividing Line -->
                                    <hr>

                                    <!-- Third Row -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <button class="btn btn-primary bg-black border-0" type="button" data-toggle="modal" data-target="#changePasswordModal">
                                                Change Password
                                                <i class="fas fa-lock ml-2"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Footer with Buttons -->
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-secondary mr-2" onclick="resetForm()">Cancel</button>
                                            <button class="btn btn-dark">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <!-- Tab Content for Orders -->
                    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                        <!-- Card with Orders -->
                        <div class="card orders-orders">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Changing Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('settings.updatePassword') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" name="password" class="form-control" id="currentPassword" placeholder="Enter Current Password" required>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Enter New Password" required>
                            </div>
                            <button id="saveNewPassword" type="submit" class="btn btn-primary btn-block">Save Changes</button>
                        </form>
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
        function resetForm() {
            document.getElementById("updateAccount").reset();
        }
    </script>
@stop
