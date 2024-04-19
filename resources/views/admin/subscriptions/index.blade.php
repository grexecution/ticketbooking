@extends('page')

@section('title', 'Subscriptions')
@section('title_header', 'Subscriptions')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <!-- Search and Add Subscription Section -->
        <div class="container-fluid bg-white py-3">
            <div class="row m-3">
                <div class="col-md-8">
                    <form action="{{ route('subscriptions.index') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control bg-light mb-2" placeholder="Subscription name" value="{{ request()->get('search') }}">
                            </div>
                            <div class="col-md-3">
                                <!-- Search button -->
                                <button class="btn btn-warning text-white btn-block" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    @error('search')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('subscriptions.create') }}" class="btn btn-dark"><i class="fas fa-plus"></i> New Subscription</a>
                </div>
            </div>

            <!-- Subscription Table -->
            <div class="row mt-5 mx-3">
                <div class="col">
                    <table class="table table-full-width">
                        <thead>
                        <tr>
                            <th>Subscription</th>
                            <th>Internal description</th>
                            <th>Events</th>
                            <th>Price</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($subscriptions->count())
                                @foreach($subscriptions as $subscription)
                                    <tr class="">
                                        <td>
                                            @if($subscription->logo_thumb_index_url)
                                                <img src="{{ asset($subscription->logo_thumb_index_url) }}" alt="Tenant img" />
                                            @endif
                                            {{ $subscription->name }}
                                        </td>
                                        <td>
                                            <div>{{ $subscription->short_desc }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $subscription->events->count() }}</div>
                                        </td>
                                        <td>
                                            <div>€ {{ $subscription->price }}</div>
                                        </td>
                                        <td class="text-right">
                                            <!-- View Subscription Button -->
                                            <a href="#" target="_blank" type="button" class="btn btn-dark text-white mx-2">
                                                <i class="fas fa-link"></i>
                                            </a>
                                            <!-- Edit Subscription Button -->
                                            <a href="{{ route('subscriptions.edit', $subscription->id) }}" type="button" class="btn btn-warning text-white mx-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete Subscription Button -->
                                            <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
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
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
         aria-hidden="true">
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
@stop

@section('js')
    <script>
        $('#confirmModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button that triggered the modal
            const recordId = button.data('record-id'); // Extract record ID from data attribute
            const deleteButton = $(this).find('#confirmDelete'); // Find the delete button in the modal

            // Set the route path for deleting the record
            let deleteRoute = '{{ route('subscriptions.destroy', ':id') }}';
            deleteRoute = deleteRoute.replace(':id', 100);

            // Set the onclick event for the delete button to redirect to the delete route
            deleteButton.click(function () {
                window.location.href = deleteRoute;
            });
        });
    </script>
@stop
