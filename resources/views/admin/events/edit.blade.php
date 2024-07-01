@extends('page')

@section('title', 'Events')
@section('title_header', 'Events')

@section('content')
    <div class="container py-3">
        @include('messages')

        <div class="container card px-4">
            <!-- First block -->
            <div class="row py-3 align-items-center">
                <!-- First column with event details -->
                <div class="col-md-8">
                    <div class="row gap-4">
                        <div class="bg-light p-3 rounded">
                            <p class="text-xl font-weight-bold">{{ $event->start_date?->format('M d') }}</p>
                            <p class="font-weight-bold text-secondary">{{ $event->start_date?->format('Y') }}</p>
                            <p>{{ $event->start_date?->format('D') }} - {{ $event->start_time?->format('g:i a') }}</p>
                        </div>
                        <div class="d-flex flex-col align-items-start justify-center">
                            @if($event->venue)
                                <p><i class="fas fa-map-marker-alt"></i> {{ $event->venue->name }}</p>
                                <h1 class="text-xl font-weight-bold">{{ $event->name }}</h1>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Second column with buttons -->
                <div class="col-md-4 d-flex justify-end">
                    <div class="row gap-2">
                        <div class="">
                            <button class="btn btn-orange btn-warning text-white" style="width: 50px;" id="qrCodeButton" data-toggle="modal" data-target="#qrCodeModal">
                                <i class="fas fa-qrcode"></i>
                            </button>
                        </div>
                        <div class="">
                            <button class="btn btn-blackish btn-dark" style="width: 50px;" onclick="printHtmlContent()"><i class="fas fa-print"></i></button>
                        </div>
                        @if($event->status !== \App\Models\Event::STATUS_HIDDEN)
                            <div class="">
                                <a href="{{ route('site.event', $event->id) }}?preview=1" target="_blank" type="button" style="width: 50px;" class="btn btn-greyish btn-secondary">
                                    <i class="fas fa-link"></i>
                                </a>
                            </div>
                        @endif
                        <div class="">
                            <div class="dropdown">
                                @php
                                $btnClass = match($event->status) {
                                    'live' => 'btn-success',
                                    'hidden' => 'btn-secondary',
                                    'preview' => 'btn-warning',
                                    'ended' => 'btn-dark',
                                }
                                @endphp
                                <button class="btn {{ $btnClass }} dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status: {{ ucfirst($event->status) }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                    <a class="dropdown-item" href="{{ route('events.status', [$event->id , 'live']) }}" {{ $event->status == "live" ? 'selected' : '' }}>Live</a>
                                    <a class="dropdown-item" href="{{ route('events.status', [$event->id , 'hidden']) }}" {{ $event->status == "hidden" ? 'selected' : '' }}>Hidden</a>
                                    <a class="dropdown-item" href="{{ route('events.status', [$event->id , 'preview']) }}" {{ $event->status == "preview" ? 'selected' : '' }}>Preview</a>
                                    <a class="dropdown-item" href="{{ route('events.status', [$event->id , 'ended']) }}" {{ $event->status == "ended" ? 'selected' : '' }}>Ended</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Separated line -->
            <hr>
            <!-- Second block -->
            <div class="row py-3">
                <div class="bg-light rounded w-100 d-flex p-4">
                    <div class="col-md-4 d-flex flex-row justify-center align-items-center gap-2">
                        <img src="{{ asset('img/sales.png') }}" alt="Sales Image" width="91" height="70">
                        <div class="d-flex flex-col">
                            <div class="font-weight-bold">Sales Volume</div>
                            <div>€3.450</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-row justify-center align-items-center gap-2">
                        <img src="{{ asset('img/booking.png') }}" alt="Bookings Image" width="91" height="70">
                        <div class="d-flex flex-col">
                            <div class="font-weight-bold">Bookings</div>
                            <div>{{ $event->active_bookings }} / {{ $event->total_tickets }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-row justify-center align-items-center gap-2">
                        <img src="{{ asset('img/checkin.png') }}" alt="Check-ins Image" width="91" height="70">
                        <div class="d-flex flex-col">
                            <div class="font-weight-bold">Check-ins</div>
                            <div>{{ $event->checkins->count() }} / {{ $event->seatPlanCategories->sum('places') }}</div>
                        </div>

                        <div class="text-right text-secondary absolute right-5 top-5">
                            @if($event->status === \App\Models\Event::STATUS_LIVE)
                                <span style="color: #28a745">Live</span>
                            @else
                                <span style="color: #dc3545">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container p-0 mt-12">
            <!-- Horizontal tabs -->
            <ul class="nav nav-tabs mt-3 border-0" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link px-20 tab-text active" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="true">Event</a>
                </li>
                @if($event->seat_type === 'seat_plan')
                    <li class="nav-item">
                        <a class="nav-link px-20 tab-text" id="seating-tab" data-toggle="tab" href="#seating" role="tab" aria-controls="seating" aria-selected="false">Seating Plan</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link px-20 tab-text" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab" aria-controls="bookings" aria-selected="false">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-20 tab-text" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="myTabContent">
                @if($event->seat_type === 'seat_plan')
                    <div class="tab-pane fade bg-white rounded" id="seating" role="tabpanel" aria-labelledby="seating-tab">
                        <div class="card seats-plan">
                            <div class="card-body">
                                <seat-plan-book
                                    event-id="{{ $event->id }}"
                                ></seat-plan-book>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="tab-pane fade bg-white rounded" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                    <!-- Bookings content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <!-- Search and Sort -->
                            <div class="row mt-3">
                                <div class="col">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                </div>
                                <div class="col">

                                </div>
                            </div>
                            <!-- Event Table -->
                            <div class="row mt-5 mx-3">
                                <div class="col">
                                    <table class="table table-full-width">
                                        <thead>
                                        <tr class="d-table-row">
                                            <th>Id</th>
                                            <th>Customer</th>
                                            <th>Seats</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($event->orders->sortByDesc('created_at') as $order)
                                            <tr class="">
                                                <td>
                                                    <span>#{{ $order->id }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <div>
                                                            {{ $order->first_name }} {{ $order->last_name }}
                                                        </div>
                                                        <small>{{ $order->email }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        @if($event->seat_type === 'no_seat_plan')
                                                            Free choice of seats
                                                        @else
                                                            ...
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        {{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y') }}
                                                    </div>
                                                    <div>
                                                        {{ \Carbon\Carbon::parse($order->order_date)->format('H:i') }}
                                                    </div>
                                                </td>
                                                <td>{{ \App\Helpers\PriceHelper::fromFloatToStr($order->total) }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-dark mx-0">
                                                        {{ ucfirst($order->order_status) }}
                                                    </a>
                                                </td>
                                                <td class="text-right">
                                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning mx-0">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                        More
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade bg-white rounded" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                    <!-- Invoice content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <h2>COMING SOON</h2>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active bg-white rounded" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <!-- Settings content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <form id="update_event" action="{{ route('events.update', $event->id) }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="{{ $event->id }}" />
                                @method('PUT')
                                @csrf
                                <div class="row mt-4">
                                    <!-- Basic Information -->
                                    <div class="col-md-12 mb-4">
                                        <h3 class="settings-title">Basic Information</h3>
                                        <hr>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="form-group d-flex flex-col">
                                                    <label for="selectArtist">Artist</label>
                                                    <select class="form-control select2" id="selectArtist" name="artist_ids[]" multiple="multiple" {{ $isEnded ? 'disabled' : '' }}>
                                                        @foreach($artists as $artist)
                                                            <option value="{{ $artist->id }}" {{ in_array($artist->id, old('artist_ids', $event->artists->pluck('id')->toArray()) ?? []) ? 'selected' : '' }}>{{ $artist->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('artist_ids')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group d-flex flex-col">
                                                    <label for="selectProgram">Program / Event Series</label>
                                                    <select class="form-control select2" id="selectProgram" name="program_id" {{ $isEnded ? 'disabled' : '' }}>
                                                        @foreach($programs as $program)
                                                            <option value="{{ $program->id }}" {{ $program->id == old('program_id', $event->program_id) ? 'selected' : '' }}>{{ $program->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('program_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Second Row -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="event_name">Event Name</label>
                                                <!-- Text input for Event Name -->
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $event->name) }}" placeholder="Enter Event Name" {{ $isEnded ? 'disabled' : '' }}>
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="venue">Venue</label>
                                                <!-- Select input for Venue -->
                                                <select class="form-control" id="venue" name="venue_id" {{ $isEnded ? 'disabled' : '' }}>
                                                    @foreach($venues as $venue)
                                                        <option value="{{ $venue->id }}" {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }} {{ $isEnded ? 'disabled' : '' }}>{{ $venue->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('venue_id')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Third Row -->
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <label for="start_date">Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control date" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date) }}" {{ $isEnded ? 'disabled' : '' }}>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                    @error('start_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="start_time">Event Start</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control timepicker" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time?->format('H:i:s')) }}" {{ $isEnded ? 'disabled' : '' }}>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                    @error('start_time')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="doors_open_time">Doors Open</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control timepicker" id="doors_open_time" name="doors_open_time" value="{{ old('doors_open_time', $event->doors_open_time?->format('H:i:s')) }}" {{ $isEnded ? 'disabled' : '' }}>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                    @error('doors_open_time')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="price">Ticket Price</label>
                                                <span class="float-right text-muted">Gross</span>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">€</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="price" name="price" value="{{ old('price', str_replace('.', ',', $event->price)) }}" {{ $isEnded ? 'disabled' : '' }}>
                                                    @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detailed Information -->
                                <div class="row mt-4">
                                    <div class="col-md-12 mb-4">
                                        <h3 class="settings-title">Detailed Information</h3>
                                        <hr>
                                        <!-- Detailed Information -->
                                        <div class="row mt-4">
                                            <div class="col-md-8">
                                                <label for="logo">Short Description</label>
                                                <textarea name="short_desc" class="form-control" rows="5" placeholder="Enter Short Description" {{ $isEnded ? 'disabled' : '' }}>{{ old('short_desc', $event->short_desc) }}</textarea>
                                                @error('short_desc')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="logo">Event Picture</label>
                                                <div
                                                    class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                                    id="logo">
                                                </div>
                                                @error('logo')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="form-group col-md-12">
                                                <label for="logo">Event description</label>
                                                <textarea
                                                    class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                                    name="description"
                                                    placeholder="Enter Event Description"
                                                    id="description">{!! old('description', $event->description) ?? "" !!}
                                                    {{ $isEnded ? 'disabled' : '' }}
                                                </textarea>
                                            </div>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <seat-plan
                                    :init-seat-type="'{{ old('seat_type', $event->seat_type) }}'"
                                    :status="'{{ $event->status }}'"
                                    :event-id="'{{ $event->id }}'"
                                    :has-bought-tickets="{{ $event->has_bought_tickets ? 'true' : 'false' }}"
                                ></seat-plan>
                                <!-- Discounts -->
                                <div class="row mt-4">
                                    <div class="col-md-12 mb-4">
                                        <div class="d-flex flex-row justify-between">
                                           <h3 class="settings-title">Discounts</h3>

                                            <div style="padding-bottom: 4px">
                                                <span class="btn btn-info btn-xs select-all-discount" style="border-radius: 0">{{ __('Select All') }}</span>
                                                <span class="btn btn-info btn-xs deselect-all-discount" style="border-radius: 0">{{ __('Deselect All') }}</span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label for="selectDiscount">Select Discount</label>
                                            <select name="discount_ids[]" class="form-control select2" id="selectDiscount" multiple="multiple" {{ $isEnded ? 'disabled' : '' }}>
                                                @foreach($discounts as $discount)
                                                    <option value="{{ $discount->id }}" {{ in_array($discount->id, old('discount_ids', $event->discounts->pluck('id')->toArray()) ?? []) ? 'selected' : '' }}>{{ $discount->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('discount_ids')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Event Sponsors -->
                                <div class="row mt-4">
                                    <div class="col-md-12 mb-4">
                                        <h3 class="settings-title">Event Sponsors</h3>
                                        <hr>
                                        <div class="form-group">
                                            <p>Auf den Tickets sowie auf der Eventseite haben Sie die Möglichkeit Ihre Sponsoren hervorzuheben.
                                                Minimum 400 X 400 Pixelbreite. Erlaubte Dateiformate: PNG, JPG, SVG</p>
                                        </div>
                                        <div class="form-group">
                                            <div
                                                class="dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
                                                id="partners">
                                            </div>
                                            @error('partners')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Save Button -->
                                <div class="row justify-content-end mt-4">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-dark btn-block" {{ $isEnded ? 'disabled' : '' }}>Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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

    <!-- Modal QR-code -->
    <div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="qrCodeInput" readonly value="{{ route('site.scanner') }}" {{ $isEnded ? 'disabled' : '' }}>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="copyButton"><i class="fas fa-copy"></i> Copy</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script>
        Dropzone.autoDiscover = false; // Prevent Dropzone from automatically attaching to all elements with the class "dropzone"

        function printHtmlContent() {
            // Get the HTML content of the specified element
            var htmlContent = document.getElementById('seats_container').innerHTML;

            // Create a new window to print the HTML content
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Print</title>');

            // Include the stylesheets from the parent window
            var stylesheets = document.querySelectorAll('link[rel="stylesheet"]');
            var loadedCount = 0;
            stylesheets.forEach(function(stylesheet) {
                var link = document.createElement('link');
                link.setAttribute('rel', 'stylesheet');
                link.setAttribute('type', 'text/css');
                link.setAttribute('href', stylesheet.href);
                link.onload = function() {
                    loadedCount++;
                    if (loadedCount === stylesheets.length) {
                        printContent();
                    }
                };
                printWindow.document.head.appendChild(link);
            });

            function printContent() {
                printWindow.document.write('</head><body>');
                printWindow.document.write(htmlContent);
                printWindow.document.write('</body></html>');

                // Print the content
                printWindow.print();
            }
        }

        $(document).ready(function() {
            const editor = CKEDITOR.replace('description', {
                basicEntities: false,
                entities_additional: 'lt,gt,amp,apos,quot'
            });
            @if($isEnded)
                // Set CKEditor to read-only mode
                editor.on('instanceReady', function() {
                    editor.setReadOnly(true);
                });
            @endif

            $('#price').inputmask({
                'alias': 'numeric',
                'groupSeparator': '.',
                'radixPoint': ',',
                'autoGroup': true,
                'digits': 2,
                'digitsOptional': false,
                'placeholder': '0'
            });

            // General Select2 plugin settings
            let $select2 = $('.select2');
            $select2.select2();
            $select2.on('select2:select', function (e) {
                //Append selected element to the end of the list, otherwise it follows the same order as the dropdown
                var element = e.params.data.element;
                var $element = $(element);
                $(this).append($element);
                $(this).trigger("change");
            })

            $('#selectDiscount').select2();
            $('#selectProgram').select2({
                tags: true,
                tokenSeparators: [','],
            });
            $('#selectArtist').select2({
                tags: true,
                tokenSeparators: [','],
            });

            // Add event listener for "Select All" Discounts button
            $('.select-all-discount').on('click', function() {
                $('#selectDiscount').find('option').prop('selected', true); // Select all options
                $('#selectDiscount').trigger('change'); // Trigger change event for Select2
            });
            // Add event listener for "Deselect All" Discounts button
            $('.deselect-all-discount').on('click', function() {
                $('#selectDiscount').find('option').prop('selected', false); // Deselect all options
                $('#selectDiscount').trigger('change'); // Trigger change event for Select2
            });

            // Add event listener for "Select All" Program button
            $('.select-all-program').on('click', function() {
                $('#selectProgram').find('option').prop('selected', true); // Select all options
                $('#selectProgram').trigger('change'); // Trigger change event for Select2
            });
            // Add event listener for "Deselect All" Program button
            $('.deselect-all-program').on('click', function() {
                $('#selectProgram').find('option').prop('selected', false); // Deselect all options
                $('#selectProgram').trigger('change'); // Trigger change event for Select2
            });

            let dropzoneSponsors = new Dropzone("#partners", {
                url: '{{ route('media.upload_file') }}',
                maxFilesize: 50, // MB
                maxFiles: 20,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    size: 50
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                success: function (file, response) {
                    $('#update_event').append('<input type="hidden" name="partners[]" value="' + response.name + '">')
                    $('#update_event').append('<input type="hidden" name="partners_origin_names[' + response.name + ']" value="' + response.original_name + '">')
                    $('#update_event').append('<input type="hidden" name="partners_sizes[' + response.name + ']" value="' + response.size + '">')
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    if (file.status !== 'error') {
                        $('#update_event').find('input[name="partners[]"]').remove()
                        this.options.maxFiles = this.options.maxFiles + 1
                    }
                },
                init: function () {
                    @php $mediaList = $event->getMedia('partners'); @endphp
                    @if($mediaList)
                    @foreach($mediaList as $media)
                    var file = {!! json_encode($media) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, '{{ $media->getFullUrl('thumb-edit') }}')
                    file.previewElement.classList.add('dz-complete')
                    $(file.previewElement.querySelector('[class="dz-filename"]')).find('span').text('{{ $media->filename }}');
                    $('#update_event').append('<input type="hidden" name="partners[]" value="' + file.name + '" \'{{ $isEnded ? 'disabled' : '' }}\'>')
                    this.options.maxFiles = this.options.maxFiles - 1
                    @endforeach
                    @endif
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
                    $('#update_event').append('<input type="hidden" name="logo" value="' + response.name + '">')
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    if (file.status !== 'error') {
                        $('#update_event').find('input[name="logo"]').remove()
                        this.options.maxFiles = 1
                    }
                },
                init: function () {
                    @php
                        $media = $event?->getFirstMedia('logo') ?? null;
                    @endphp
                    @if($media)
                    let file = {!! json_encode($media) !!}
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, '{{ $event->logo_thumb_edit_url }}')
                    file.previewElement.classList.add('dz-complete')
                    $(file.previewElement.querySelector('[class="dz-filename"]')).find('span').text('{{ $media->filename }}');
                    $('#update_event').append('<input type="hidden" name="logo" value="' + file.name + '">')
                    this.options.maxFiles = 0;
                    @endif
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

            @if($isEnded)
                dropzoneSponsors.disable();
                dropzoneLogo.disable();
            @endif

            $('#confirmModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const recordId = button.data('record-id'); // Extract record ID from data attribute
                const deleteButton = $(this).find('#confirmDelete'); // Find the delete button in the modal

                // Set the route path for deleting the record
                let deleteRoute = '{{ route('tenants.destroy', ':id') }}';
                deleteRoute = deleteRoute.replace(':id', recordId);

                // Set the onclick event for the delete button to redirect to the delete route
                deleteButton.click(function() {
                    window.location.href = deleteRoute;
                });
            });

            // QR-code modal
            // Add click event listener to copy button
            document.getElementById('copyButton').addEventListener('click', function() {
                var input = document.getElementById('qrCodeInput');
                input.select();
                input.setSelectionRange(0, 99999); // For mobile devices

                document.execCommand('copy');
                // Show message that text was copied
                alert('Text copied!');
            });

            // Todo move to JS file


            $("#randomize-btn").on("click", function (a) {
                // generateRandomBlocks()
            });
        });
        $(document).ready(function() {
            // Search functionality
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#bookings tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@stop
