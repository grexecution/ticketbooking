@extends('page')

@section('title', 'Vouchers')
@section('title_header', 'Vouchers')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <!-- Add Voucher Section -->
        <div class="container-fluid card bg-white py-3">
            <div class="row my-2 mx-3">
            <div class="col-md-10">
                    <form action="{{ route('vouchers.index') }}" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control bg-light" placeholder="Voucher Name" value="{{ request()->get('search') }}">
                            </div>
                            <div class="col-md-3">
                                <!-- Search button -->
                                <button class="btn btn-orange text-white btn-block" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    @error('search')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class=""></div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('vouchers.create') }}" class="btn btn-blackish btn-dark"><i class="fas fa-plus"></i> New Voucher</a>
                </div>
            </div>
        </div>
            <!-- Voucher Table -->
        <div class="container-fluid card bg-white py-3">
            <div class="row mx-3">
                <div class="col">
                    <table class="table table-full-width">
                        <thead>
                        <tr>
                            <th class="table-head-single">Coupon</th>
                            <th class="table-head-single">Internal description</th>
                            <th class="table-head-single">Discount</th>
                            <th class="table-head-single text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($vouchers->count())
                                @foreach($vouchers as $voucher)
                                    <tr class="">
                                        <td>
                                            <span>{{ $voucher->name }}</span>
                                        </td>
                                        <td>
                                            <div>{!! $voucher->description !!}</div>
                                        </td>
                                        <td>
                                            <div>{{ $voucher->type === 'fixed' ? "-{$voucher->fixed}Є" : "-{$voucher->percentage}%" }}</div>
                                        </td>
                                        <td class="text-right">
                                            <!-- Edit Voucher Button -->
                                            <a href="{{ route('vouchers.edit', $voucher->id) }}" type="button" class="btn btn-warning text-white mx-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete Voucher Button -->
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
            let deleteRoute = '{{ route('vouchers.destroy', ':id') }}';
            deleteRoute = deleteRoute.replace(':id', recordId);

            // Set the onclick event for the delete button to redirect to the delete route
            deleteButton.click(function () {
                window.location.href = deleteRoute;
            });
        });
    </script>
@stop
