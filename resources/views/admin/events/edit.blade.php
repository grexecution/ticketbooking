@extends('page')

@section('title', 'Events')
@section('title_header', 'Events')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <div class="container bg-white px-4 rounded">
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
                    <div class="row">
                        <div class="col-md-2">
                            <button class="btn btn-warning text-white" id="qrCodeButton" data-toggle="modal" data-target="#qrCodeModal">
                                <i class="fas fa-qrcode"></i>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-dark" onclick="printHtmlContent()"><i class="fas fa-print"></i></button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('site.event', $event->id) }}?preview=1" target="_blank" type="button" class="btn btn-secondary">
                                <i class="fas fa-link"></i>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" id="statusDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status: {{ ucfirst($event->status) }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                    <a class="dropdown-item" href="{{ route('events.status', [$event->id , 'live']) }}" {{ $event->status == "live" ? 'selected' : '' }}>Live</a>
                                    <a class="dropdown-item" href="{{ route('events.status', [$event->id , 'hidden']) }}" {{ $event->status == "hidden" ? 'selected' : '' }}>Hidden</a>
                                    <a class="dropdown-item" href="{{ route('events.status', [$event->id , 'preview']) }}" {{ $event->status == "preview" ? 'selected' : '' }}>Preview</a>
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
                            <div>166 / 200</div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex flex-row justify-center align-items-center gap-2">
                        <img src="{{ asset('img/checkin.png') }}" alt="Check-ins Image" width="91" height="70">
                        <div class="d-flex flex-col">
                            <div class="font-weight-bold">Check-ins</div>
                            <div>0 / 200</div>
                        </div>

                        <div class="text-right text-secondary absolute right-5 top-5">{{ $event->status === \App\Models\Event::STATUS_LIVE ? 'Live' : 'Inactive' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Horizontal tabs -->
            <ul class="nav nav-tabs mt-3 border-0" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link tab-text active" id="seating-tab" data-toggle="tab" href="#seating" role="tab" aria-controls="seating" aria-selected="true">Seating Plan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-text" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab" aria-controls="bookings" aria-selected="false">Bookings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-text" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-text" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active bg-white rounded" id="seating" role="tabpanel" aria-labelledby="seating-tab">
                    <!-- Seats and Pricing Content -->
{{--                    <div class="card seats-plan">--}}
{{--                        <div class="card-body">--}}
{{--                            <!-- Seats and Pricing -->--}}
{{--                            <div class="row mt-4">--}}
{{--                                <!-- Pricing Blocks -->--}}
{{--                                <div class="col-md-8">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <img src="{{ asset('img/seat_A.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                                            <div class="pricing-info">--}}
{{--                                                <div>Category A</div>--}}
{{--                                                <div>€ 28,00</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <img src="{{ asset('img/seat_B.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                                            <div class="pricing-info">--}}
{{--                                                <div>Category B</div>--}}
{{--                                                <div>€ 38,00</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <img src="{{ asset('img/seat_C.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                                            <div class="pricing-info">--}}
{{--                                                <div>Category C</div>--}}
{{--                                                <div>€ 38,00</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-3">--}}
{{--                                            <img src="{{ asset('img/seat_D.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                                            <div class="pricing-info">--}}
{{--                                                <div>Category D</div>--}}
{{--                                                <div>€ 8,00</div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Seat Layout -->--}}
{{--                            <div class="row mt-4 mb-5">--}}
{{--                                <div class="col">--}}
{{--                                    <div class="text-center mb-2">STAGE</div>--}}
{{--                                    <div class="seat-layout">--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-1"></div>--}}
{{--                                            @for($k = 0; $k < 10; $k++)--}}
{{--                                                <div class="col seat-header">{{chr(65 + $k)}}</div>--}}
{{--                                            @endfor--}}
{{--                                        </div>--}}
{{--                                        @for($i = 0; $i < 10; $i++)--}}
{{--                                            <div class="row">--}}
{{--                                                <div class="col-1">{{$i + 1}}</div>--}}
{{--                                                @for($j = 0; $j < 10; $j++)--}}
{{--                                                    <div class="col seat">--}}
{{--                                                        <img src="{{ asset('img/seat_A.png') }}" alt="Specific Seat" class="img-fluid m-1" onclick="openPopup('Row {{ $i + 1 }} - Seat {{ chr(65 + $j) }}', '€ 39,90')">--}}
{{--                                                    </div>--}}
{{--                                                @endfor--}}
{{--                                            </div>--}}
{{--                                        @endfor--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div id="printContent"  class="flex flex-col h-screen w-100">
                        <div class="flex flex-row h-full">
                            <div class="w-48 bg-gray-100 hidden md:block border-r border-r-gray-300 shadow-lg">
                                <div class="flex flex-col gap-3 p-1.5 text-xs">
                                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1 px-3 rounded-md hover:bg-slate-200"
                                            id="zoomout-button">
                                        <i class="fa-solid fa-magnifying-glass-minus mr-2"></i>
                                        All Blocks
                                    </button>
                                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1 px-3 rounded-md hover:bg-slate-200"
                                            id="get-selected-seats">
                                        <i class="fa-solid fa-code mr-2"></i>
                                        Get Json
                                    </button>
                                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1  px-3 rounded-md hover:bg-slate-200 zoom-to-block"
                                            data-block-id="block-1">
                                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>
                                        Zoom Block 2
                                    </button>
                                </div>
                            </div>
                            <div id="seats_container" class="w-full flex-1 h-full"></div>

                            <div class="flex flex-col w-52 flex-0 border-l">
                                <div class="text-center w-full text-sm p-2 bg-gray-100 border-b">Selected Seats</div>
                                <table class="table-auto text-sm">
                                    <tbody id="selected-seats">

                                    </tbody>
                                </table>
                                <button id="checkout" class="btn btn-primary">Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade bg-white rounded" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                    <!-- Bookings content -->
                    <div class="card seats-plan">
                        <div class="card-body">
                            <!-- Event Table -->
                            <div class="row mt-5 mx-3">
                                <div class="col">
                                    <table class="table table-full-width">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Customer</th>
                                            <th>Places</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="">
                                            <td>
                                                <span>#22398</span>
                                            </td>
                                            <td>
                                                <div>
                                                    Gregor Wallner
                                                </div>
                                            </td>
                                            <td>
                                                <div>A1, A2, A3, A5, D6</div>
                                            </td>
                                            <td>
                                                <div>
                                                    30.06.2024
                                                </div>
                                                <div>
                                                    16:31
                                                </div>
                                            </td>
                                            <td>€ 133,00</td>
                                            <td>
                                                <a href="#" class="btn btn-dark mx-2">Completed</a>
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('orders.show', 1) }}" class="btn btn-warning mx-2">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                    More
                                                </a>
                                            </td>
                                        </tr>
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
                <div class="tab-pane fade bg-white rounded" id="settings" role="tabpanel" aria-labelledby="settings-tab">
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
                                                    <select class="form-control select2" id="selectArtist" name="artist_ids[]" multiple="multiple">
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
                                                    <select class="form-control select2" id="selectProgram" name="program_id">
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
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $event->name) }}" placeholder="Enter Event Name">
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="venue">Venue</label>
                                                <!-- Select input for Venue -->
                                                <select class="form-control" id="venue" name="venue_id">
                                                    @foreach($venues as $venue)
                                                        <option value="{{ $venue->id }}" {{ old('venue_id', $event->venue_id) == $event->venue_id ? 'selected' : '' }}>{{ $venue->name }}</option>
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
                                                    <input type="text" class="form-control date" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date) }}">
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
                                                    <input type="text" class="form-control timepicker" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time?->format('H:i:s')) }}">
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
                                                    <input type="text" class="form-control timepicker" id="doors_open_time" name="doors_open_time" value="{{ old('doors_open_time', $event->doors_open_time?->format('H:i:s')) }}">
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
                                                    <input type="text" class="form-control" id="price" name="price" value="{{ old('price', str_replace('.', ',', $event->price)) }}">
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
                                                <textarea name="short_desc" class="form-control" rows="5" placeholder="Enter Short Description">{{ old('short_desc', $event->short_desc) }}</textarea>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="logo">Event Picture</label>
                                                <div
                                                    class="p-0 border-0 rounded dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}"
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
                                                    class="form-control tinymceTextarea {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                                    name="description"
                                                    placeholder="Enter Event Description"
                                                    id="description">{!! old('description', $event->description) ?? "" !!}
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
                                    :init-seat-amount="'{{ old('seat_amount', $event->seat_amount) }}'"
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
                                            <select name="discount_ids[]" class="form-control select2" id="selectDiscount" multiple="multiple">
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
                                        <button type="submit" class="btn btn-dark btn-block">Save</button>
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
                        <input type="text" class="form-control" id="qrCodeInput" readonly value="{{ route('site.scanner') }}">
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
                    $('#update_event').append('<input type="hidden" name="partners[]" value="' + file.name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
                    @endforeach
                    @endif
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        let message = response // dropzone sends it's own error messages in string
                    } else {
                        let message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
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
                        this.options.maxFiles = this.options.maxFiles + 1
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
                    this.options.maxFiles = this.options.maxFiles - 1
                    @endif
                },
                error: function (file, response) {
                    if ($.type(response) === 'string') {
                        let message = response // dropzone sends it's own error messages in string
                    } else {
                        let message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            });

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

            let seatmap = new SeatMapCanvas("#seats_container", {
                legend: true,
                style: {
                    seat: {
                        hover: '#8fe100',
                        color: '#f0f7fa',
                        selected: '#8fe100',
                        check_icon_color: '#fff',
                        not_salable: '#0088d3',
                        focus: '#8fe100',
                    },
                    legend: {
                        font_color: '#3b3b3b',
                        show: false
                    },
                    block: {
                        title_color: '#fff'
                    }
                }
            });


            seatmap.eventManager.addEventListener("SEAT.CLICK", (seat) => {
                if (!seat.isSelected() && seat.item.salable === true) {
                    seat.select()
                } else {
                    seat.unSelect()
                }

                updateSelectedSeats()
            });


            // FOR DEMO
            const generateSingleBlock = function () {
                let block_colors = ["#01a5ff"]; // Using only one color for the block
                let blocks = [];
                let seats = [];
                let blockTitle = `Block 1`; // Set the block title

                // Loop to generate seats
                for (let row = 0; row < 15; row++) {
                    for (let col = 0; col < 30; col++) {
                        let x = col * 33;
                        let y = row * 30;
                        let salable = Math.ceil(Math.random() * 10) > 3;
                        let randomPrice = (Math.floor(Math.random() * (10 - 1 + 1)) + 1) * 10;

                        let seat = {
                            id: `s-${row}-${col}`,
                            x: x,
                            y: y,
                            color: block_colors[0], // Use the first color from the block colors array
                            salable: salable,
                            custom_data: {
                                any: "things",
                                price: randomPrice,
                                basket_name: `${blockTitle} - ${row + 1} ${col + 1}`
                            },
                            note: "note test",
                            tags: {},
                            title: `${blockTitle}\n${row + 1} ${col + 1}`
                        };

                        seats.push(seat);
                    }
                }

                // Create the block object
                let block = {
                    "id": "block-1",
                    "title": blockTitle,
                    "labels": [],
                    "color": block_colors[0], // Use the first color from the block colors array
                    "seats": seats
                };

                blocks.push(block);

                // Replace the data with the generated block
                seatmap.data.replaceData(blocks);
            };

            const generateTwoBlocks = function () {
                let block_colors = ["#01a5ff", "#fccf4e"]; // Colors for the two blocks
                let blocks = [];

                for (let blockIndex = 0; blockIndex < 2; blockIndex++) { // Loop for two blocks
                    let blockTitle = `Block ${blockIndex + 1}`;
                    let seats = [];

                    for (let row = 0; row < 25; row++) { // Loop for rows
                        for (let col = 0; col < 20; col++) { // Loop for seats in a row
                            let x = col * 33;
                            let y = row * 30;
                            let salable = Math.ceil(Math.random() * 10) > 3;
                            let randomPrice = (Math.floor(Math.random() * (10 - 1 + 1)) + 1) * 10;

                            let seat = {
                                id: `s-${blockIndex}-${row}-${col}`,
                                x: x,
                                y: y,
                                color: block_colors[blockIndex], // Use color corresponding to the block
                                salable: salable,
                                custom_data: {
                                    any: "things",
                                    price: randomPrice,
                                    basket_name: `${blockTitle} - Row ${row + 1} Seat ${col + 1}`
                                },
                                note: "note test",
                                tags: {},
                                title: `${blockTitle}\nRow ${row + 1} Seat ${col + 1}`
                            };

                            seats.push(seat);
                        }
                    }

                    // Create the block object
                    let block = {
                        "id": `block-${blockIndex + 1}`,
                        "title": blockTitle,
                        "labels": [],
                        "color": block_colors[blockIndex], // Use color corresponding to the block
                        "seats": seats
                    };

                    blocks.push(block);
                }

                // Replace the data with the generated blocks
                seatmap.data.replaceData(blocks);
            };

            const generateRandomBlocks = function () {
                let block_colors = ["#01a5ff", "#fccf4e", "#01a5ff", "#01a5ff"];
                let blocks = []
                let last_x = 0;
                for (let j = 0; j < 4; j++) { // blocks

                    let color = block_colors[j];

                    let seats = []
                    let cell_count = 0;
                    let row_count = 0;
                    let block_final_x = 0;
                    let randomSeatCount = Math.round((Math.random() * (Math.abs(400 - 200))) + 200)
                    let randomCell = Math.round((Math.random() * (Math.abs(28 - 12))) + 12)
                    let blockTitle = `Block ${j + 1}`;

                    for (let k = 0; k < randomSeatCount; k++) { // row
                        if (k % randomCell === 0) {
                            cell_count = 1;
                            row_count++;
                        }

                        let x = (cell_count * 33) + last_x;
                        let y = row_count * 30;

                        if (block_final_x < x) block_final_x = x;
                        let salable = Math.ceil(Math.random() * 10) > 3;
                        let randomPrice = (Math.floor(Math.random() * (10 - 1 + 1)) + 1) * 10

                        let seat = {
                            id: `s-${k}`,
                            x: x,
                            y: y,
                            color: color, // can use item.color from json data
                            salable: salable,
                            custom_data: {
                                any: "things",
                                price: randomPrice,
                                basket_name: `${blockTitle} - ${cell_count} ${row_count}`
                            },
                            note: "note test",
                            tags: {},
                            title: `${blockTitle}\n${cell_count} ${row_count}`
                        }
                        cell_count++;
                        seats.push(seat)
                    }

                    last_x = block_final_x + 100;

                    let block = {
                        "id": `block-${j}`,
                        "title": blockTitle,
                        "labels": [],
                        "color": color,
                        "seats": seats
                    };

                    blocks.push(block);
                }

                seatmap.data.replaceData(blocks);
            }

            const unselectSeat = function () {
                let seatId = $(this).attr('seat-id');
                let blockId = $(this).attr('block-id');
                let seat = seatmap.data.getSeat(seatId, blockId);
                seat.svg.unSelect()
                updateSelectedSeats()
            }

            const updateSelectedSeats = function () {
                let selectedSeats = seatmap.data.getSelectedSeats();

                let seatsTemplateHtml = ``

                if (selectedSeats.length === 0) {
                    seatsTemplateHtml = `
                    <tr class="text-center py-2 px-2 flex flex-col">
                        <td class="text-lg text-gray-400"><i class="fa-regular fa-face-rolling-eyes"></i></td>
                        <td class="text-gray-400">No selected seat</td>
                    </tr>
                `
                }

                for (let i = 0; i < selectedSeats.length; i++) {
                    let selectedSeat = selectedSeats[i];

                    let priceFormatted = selectedSeat.custom_data.price.toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    })

                    let html = `<tr class="w-full h-8 hover:bg-blue-100 py-1 px-2 items-center">
                    <td class="w-6">
                        <div class="inline-block w-3 h-3 bg-[#8fe100] rounded-lg ml-1"></div>
                    </td>
                    <td class="flex-0">${selectedSeat.custom_data.basket_name}</td>
                    <td class="text-right font-bold">${priceFormatted}</td>
                    <td class="w-6 unselect-seat text-center cursor-pointer text-red-200 hover:text-red-500" seat-id="${selectedSeat.id}" block-id="${selectedSeat.block.id}">
                        <i class="fa-solid fa-xmark text-md "></i>
                    </td>
                </tr>`

                    seatsTemplateHtml += html;
                }

                if (selectedSeats.length > 0) {
                    let totalPrice = selectedSeats.reduce((accumulator, currentValue) => accumulator + currentValue.custom_data.price,0)
                    let priceFormatted = totalPrice.toLocaleString('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    })
                    seatsTemplateHtml += `
                    <tr class="border-t h-6 text-center bg-gray-200">
                        <td colspan="4" class="py-1">Total: <strong>${priceFormatted}</strong> for ${selectedSeats.length} seats </td>
                    </tr>
                `
                }

                $('#selected-seats').html(seatsTemplateHtml)

                $(".unselect-seat").on('click', unselectSeat)
            }

            // generateRandomBlocks()
            generateSingleBlock()
            // generateTwoBlocks()
            updateSelectedSeats()


            $("#zoomout-button").on("click", function () {
                seatmap.zoomManager.zoomToVenue();
            });

            $(".zoom-to-block").on("click", function (a) {
                let blockId = $(this).attr('data-block-id');
                seatmap.zoomManager.zoomToBlock(blockId);
            });
            $("#get-selected-seats").on("click", function (a) {
                let selectedSeats = seatmap.data.getSelectedSeats();
                console.log(selectedSeats)
            });
            $("#checkout").on("click", function (a) {
                let selectedSeats = seatmap.data.getSelectedSeats();
                const seats = selectedSeats.map(seat => seat.id)
                alert('Selected seats: ' + seats)
            });

            // $(".unselect-seat").on("click", function (a) {
            //
            // });

            $("#randomize-btn").on("click", function (a) {
                // generateRandomBlocks()
            });
        });
    </script>
@stop
