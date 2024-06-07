@extends('page')

@section('title', 'Events')
@section('title_header', 'Events')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <!-- Search and Add Event Section -->
        <div class="container-fluid card bg-white py-3">
            <div class="row my-2 mx-3">
                <div class="col-md-9">
                    <form action="{{ route('events.index') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control bg-light" placeholder="Event name" value="{{ request()->get('search') }}">
                            </div>
                            <div class="col-md-3">
                                <!-- Search select input -->
                                <select class="custom-select" name="status">
                                    <option value="">Filter by status</option>
                                    <option value="live" {{ old('status', request()->get('status')) == "live" ? 'selected' : '' }}>Live</option>
                                    <option value="hidden" {{ old('status', request()->get('status')) == "hidden" ? 'selected' : '' }}>Hidden</option>
                                    <option value="preview" {{ old('status', request()->get('status')) == "preview" ? 'selected' : '' }}>Preview</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <!-- Search button -->
                                <button class="btn btn-orange text-white btn-block" type="submit">Search</button>
                            </div>
                        </div>
                        @error('search')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </form>

                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('events.create') }}" class="btn btn-blackish btn-dark"><i class="fas fa-plus"></i> New Event</a>
                </div>
            </div>
    </div>

            <!-- Event Table -->
    <div class="container-fluid card bg-white py-3">
            <div class="row mx-3">
                <div class="col">
                    <table class="table table-full-width">
                        <thead>
                        <tr>
                            <th class="table-head-single">Event</th>
                            <th class="table-head-single">Date</th>
                            <th class="table-head-single">Bookings</th>
                            <th class="table-head-single">Status</th>
                            <th class="table-head-single text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($events->count())
                                @foreach($events as $event)
                                    <tr class="">
                                        <td style="border-top: 1px solid #dee2e6;">
                                            <div class="d-flex align-items-center">
                                                @if($event->logo_thumb_index_url)
                                                    <img class="h-100 img-fluid img-thumbnail" src="{{ asset($event->logo_thumb_index_url) }}" alt="Tenant img" />
                                                @endif
                                                <div class="d-flex flex-col ml-2 align-items-start">
                                                    <p class="font-weight-bold">{{ $event->name }}</p>
                                                    <span>{{ $event->short_desc }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-md-2 event-body">
                                            <div>
                                                {{ $event->start_date?->format('l, F j, Y') ?? '' }}
                                            </div>
                                            <div>
                                                Start: {{ $event->start_time?->format('H:i') ?? '' }}
                                            </div>
                                        </td>
                                        <td class="col-md-1 event-body text-center">
                                            <?php
                                                $activeBookings = $event->active_bookings;
                                                $totalTickets = $event->total_tickets;
                                                $percentage = ($totalTickets > 0) ? ($activeBookings / $totalTickets) * 100 : 0;
                                            ?>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percentage }}%">
                                                    <span class="sr-only">{{ $percentage }}% Complete (warning)</span>
                                                </div>
                                            </div>
                                            <small>{{ $activeBookings }} / {{ $totalTickets }}</small>
                                        </td>
                                        @php
                                        $btnClass = match($event->status) {
                                                'live' => 'btn-success',
                                                'hidden' => 'btn-secondary',
                                                'preview' => 'btn-warning',
                                                'ended' => 'btn-dark',
                                            }
                                        @endphp
                                        <td class="event-body {{ $btnClass }} text-center">
                                            {{ ucfirst($event->status) }}
                                        </td>
                                        <td class="text-right col-md-2 event-body">
                                            <div class="d-flex justify-content-end gap-1">
                                                <!-- View Event Button -->
                                                <a href="{{ route('site.event', $event->slug) }}" target="_blank" type="button" class="btn btn-dark text-white">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                                <!-- Edit Event Button -->
                                                <a href="{{ route('events.edit', $event->id) }}" type="button" class="btn btn-warning text-white">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <!-- Delete Event Button -->
                                                <a href="#" class="btn btn-danger delete-record" data-record-id="{{ $event->id }}" data-toggle="modal" data-target="#confirmModal">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
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
            let deleteRoute = '{{ route('events.destroy', ':id') }}';
            deleteRoute = deleteRoute.replace(':id', recordId);

            // Set the onclick event for the delete button to redirect to the delete route
            deleteButton.click(function () {
                window.location.href = deleteRoute;
            });
        });
    </script>
@stop
