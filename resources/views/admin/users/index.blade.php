@extends('page')

@section('title', 'Users')
@section('title_header', 'Users')

@section('content')
    <div class="container pt-3">
        <!-- Include Messages -->
        @include('messages')

        <!-- Search and Add User Section -->
        <div class="container-fluid bg-white py-3">
            <div class="row m-3">
                <div class="col-md-4">
                    <form action="{{ route('users.index') }}" method="GET">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light" placeholder="Search for users..." value="{{ request()->get('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-warning text-white" type="submit">Search</button>
                            </div>
                            @error('search')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-dark"><i class="fas fa-plus"></i> New User</a>
                </div>
            </div>

            <!-- User Table -->
            <div class="row mt-5 mx-3">
                <div class="col">
                    <table class="table table-full-width">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Tenant</th>
                            <th>Email</th>
                            <th>2FA enabled</th>
                            <th>Created At</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($users->count())
                            @foreach($users as $user)
                                <tr class="">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->tenant?->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->google2fa_enable ? 'yes' : 'no' }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td class="text-right">
                                        <!-- Edit User Button -->
                                        <a href="{{ route('users.edit', $user->id) }}" type="button" class="btn btn-warning text-white mx-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Delete User Button -->
                                        <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="{{ $user->id }}" data-toggle="modal" data-target="#confirmModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="6">Records not found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
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
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
@stop

@section('js')
    <script>
        $('#confirmModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button that triggered the modal
            const recordId = button.data('record-id'); // Extract record ID from data attribute
            const deleteButton = $(this).find('#confirmDelete'); // Find the delete button in the modal

            // Set the route path for deleting the record
            let deleteRoute = '{{ route('users.destroy', ':id') }}';
            deleteRoute = deleteRoute.replace(':id', recordId);

            // Set the onclick event for the delete button to redirect to the delete route
            deleteButton.click(function() {
                window.location.href = deleteRoute;
            });
        });
    </script>
@stop
