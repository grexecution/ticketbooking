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
                    <a class="nav-link active" id="v-pills-info-tab" data-toggle="pill" href="#v-pills-info" role="tab" aria-controls="v-pills-info" aria-selected="true">Basic info</a>
                    <a class="nav-link" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="true">User</a>
                    <a class="nav-link" id="v-pills-finances-tab" data-toggle="pill" href="#v-pills-finances" role="tab" aria-controls="v-pills-finances" aria-selected="false">Finances</a>
                    <button class="btn btn-light btn-block mt-3" style="color: red; border: 1px solid red;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
                </div>
            </div>

            <!-- Right Column with Tab Content -->
            <div class="col-md-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Tab Content for Personal Info -->
                    <div class="tab-pane fade show active" id="v-pills-info" role="tabpanel" aria-labelledby="v-pills-info-tab">
                        <!-- Card with Personal Info -->
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
                                            <label for="tenantName">Tenant Name</label>
                                            <input type="text" class="form-control" name="tenant_name" id="tenantName" placeholder="Enter First Name" value="{{ old('tenant_name', $user?->tenant?->name) }}">
                                            @error('tenant_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="companyName">Company Name</label>
                                            <input type="text" class="form-control" name="company_name" id="companyName" placeholder="Enter Company Name" value="{{ old('company_name', $user?->tenant?->company) }}">
                                            @error('company_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Dividing Line -->
                                    <hr>

                                    <!-- Third Row -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="fileInput">Tenant Logo</label>
                                            <input type="file" class="form-control-file" id="fileInput">
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

                    <!-- Tab Content for Account -->
                    <div class="tab-pane fade show" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                        <!-- Card with User Information -->
                        <div class="card account-settings">
                            <div class="card-header">
                                <h5 class="card-title m-0">User</h5>
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
                                            <button class="btn btn-dark">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Content for Payment connection via Stripe -->
                    <div class="tab-pane fade" id="v-pills-finances" role="tabpanel" aria-labelledby="v-pills-finances-tab">
                        <!-- Card with Payment connection via Stripe -->
                        <div class="card orders-orders">
                            <div class="card-header">
                                <h5 class="card-title m-0">Finances</h5>
                            </div>
                            <div class="card-body">
                                <h4>Payment connection via Stripe</h4>
                                <!-- Form with 3 Rows -->
                                <form id="updateAccount" action="{{ route('settings.updateAccount') }}" method="post">
                                    @csrf
                                    <!-- First Row -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="stripe_key">Stripe Key</label>
                                            <input type="password" class="form-control" name="stripe_key" id="stripe_key" placeholder="Enter First Name" {{--value="{{ old('stripe_key', $user?->tenant?->stripe_key) }}"--}} value="password">
                                            @error('stripe_key')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="stripe_secret">Stripe Secret</label>
                                            <input type="password" class="form-control" name="stripe_secret" id="stripe_secret" placeholder="Enter Stripe Secret" {{--value="{{ old('stripe_secret', $user?->tenant?->stripe_secret) }}"--}} value="password">
                                            @error('stripe_secret')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="form-group">
                                        <a href="#" target="_blank" class="btn btn-dark">
                                            <i class="fas fa-plug ml-2"></i>
                                            Check connection
                                        </a>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <br>
                                    <br>

                                    <h4>Platform fees</h4>
                                    <!-- Dividing Line -->
                                    <hr>

                                    <div class="mb-3">Our platform fees are automatically deducted from ticket purchases. See more information about fees here.</div>

                                    <div class="form-group">
                                        <a href="#" target="_blank" class="btn btn-dark">
                                            <i class="fas fa-dollar-sign ml-2"></i>
                                            Platform fees
                                        </a>
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
