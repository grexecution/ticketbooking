@extends('page')

@section('title', 'Events')
@section('title_header', 'Events')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <!-- Search and Add Event Section -->
        <div class="container-fluid bg-white py-3">
            <div class="row m-3">
                <div class="col-md-8">
                    <form action="{{ route('tenants.index') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control bg-light mb-2" placeholder="Event name" value="{{ request()->get('search') }}">
                            </div>
                            <div class="col-md-3">
                                <!-- Search select input -->
                                <select class="custom-select mb-2" name="statuc">
                                    <option value="">Select status</option>
                                    <option value="category1">Status 1</option>
                                    <option value="category2">Status 2</option>
                                    <option value="category3">Status 3</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <!-- Search button -->
                                <button class="btn btn-warning text-white btn-block" type="submit">Search</button>
                            </div>
                        </div>
                        @error('search')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </form>

                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('events.create') }}" class="btn btn-dark"><i class="fas fa-plus"></i> New Event</a>
                </div>
            </div>

            <!-- Event Table -->
            <div class="row mt-5 mx-3">
                <div class="col">
                    <table class="table table-full-width">
                        <thead>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Bookings</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="">
                            <td>
                                <img src="{{ asset('img/event_demo.png') }}" alt="Event img" />
                                <span>This is an event title for a test event</span>
                            </td>
                            <td>
                                <div>
                                    Sunday, June 30, 2024
                                </div>
                                <div>
                                    Start: 8:00 p.m
                                </div>
                            </td>
                            <td>
                                <div>166 / 200</div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span class="sr-only">60% Complete (warning)</span>
                                    </div>
                                </div>
                            </td>
                            <td>live</td>
                            <td class="text-right">
                                <!-- View Event Button -->
                                <a href="{{ route('site.event', 1) }}" target="_blank" type="button" class="btn btn-dark text-white mx-2">
                                    <i class="fas fa-link"></i>
                                </a>
                                <!-- Edit Event Button -->
                                <a href="{{ route('events.create') }}" type="button" class="btn btn-warning text-white mx-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete Event Button -->
                                <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
{{--                        @if($events->count())--}}
{{--                            @foreach($events as $event)--}}
{{--                                <tr class="">--}}
{{--                                    <td>{{ $event->name }}</td>--}}
{{--                                    <td>2</td>--}}
{{--                                    <td>5</td>--}}
{{--                                    <td>20</td>--}}
{{--                                    <td>€ 365,90</td>--}}
{{--                                    <td class="text-right">--}}
{{--                                        <!-- Edit Event Button -->--}}
{{--                                        <a href="{{ route('tenants.edit', $event->id) }}" type="button"--}}
{{--                                           class="btn btn-warning text-white mx-2">--}}
{{--                                            <i class="fas fa-edit"></i>--}}
{{--                                        </a>--}}
{{--                                        <!-- Delete Event Button -->--}}
{{--                                        <a href="#" class="btn btn-danger mx-2 delete-record"--}}
{{--                                           data-record-id="{{ $event->id }}" data-toggle="modal"--}}
{{--                                           data-target="#confirmModal">--}}
{{--                                            <i class="fas fa-trash"></i>--}}
{{--                                        </a>--}}
{{--                                        <!-- Admin Login Button -->--}}
{{--                                        <form method="post" action="{{ route('tenants.adminLogin') }}"--}}
{{--                                              class="d-inline-block">--}}
{{--                                            @csrf--}}
{{--                                            <input type="hidden" name="tenant_id" value="{{ $event->id }}">--}}
{{--                                            <button type="submit" class="btn btn-dark ml-2">Admin Login</button>--}}
{{--                                        </form>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <tr class="text-center">--}}
{{--                                <td colspan="6">Records not found</td>--}}
{{--                            </tr>--}}
{{--                        @endif--}}
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
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
@stop

@section('js')
    <script>
        $('#confirmModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button that triggered the modal
            const recordId = button.data('record-id'); // Extract record ID from data attribute
            const deleteButton = $(this).find('#confirmDelete'); // Find the delete button in the modal

            // Set the route path for deleting the record
            let deleteRoute = '{{ route('tenants.destroy', ':id') }}';
            deleteRoute = deleteRoute.replace(':id', 100);

            // Set the onclick event for the delete button to redirect to the delete route
            deleteButton.click(function () {
                window.location.href = deleteRoute;
            });
        });
    </script>
@stop
