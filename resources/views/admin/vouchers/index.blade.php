@extends('page')

@section('title', 'Vouchers')
@section('title_header', 'Vouchers')

@section('content')
    <div class="container pt-3">
        @include('messages')

        <!-- Add Voucher Section -->
        <div class="container-fluid bg-white py-3">
            <div class="row m-3">
                <div class="col-md-10"></div>
                <div class="col-md-2 text-right">
                    <a href="{{ route('vouchers.create') }}" class="btn btn-dark"><i class="fas fa-plus"></i> New Voucher</a>
                </div>
            </div>

            <!-- Voucher Table -->
            <div class="row mt-5 mx-3">
                <div class="col">
                    <table class="table table-full-width">
                        <thead>
                        <tr>
                            <th>Coupon</th>
                            <th>Internal description</th>
                            <th>Discount</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="">
                            <td>
                                <span>A8dJJ8</span>
                            </td>
                            <td>
                                <div>Orpheum Email Newsletter</div>
                            </td>
                            <td>
                                <div>-30%</div>
                            </td>
                            <td class="text-right">
                                <!-- Edit Voucher Button -->
                                <a href="{{ route('vouchers.create') }}" type="button" class="btn btn-warning text-white mx-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete Voucher Button -->
                                <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr class="">
                            <td>
                                <span>MEGA SALES</span>
                            </td>
                            <td>
                                <div>Black Friday voucher</div>
                            </td>
                            <td>
                                <div>-40%</div>
                            </td>
                            <td class="text-right">
                                <!-- Edit Voucher Button -->
                                <a href="{{ route('vouchers.create') }}" type="button" class="btn btn-warning text-white mx-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Delete Voucher Button -->
                                <a href="#" class="btn btn-danger mx-2 delete-record" data-record-id="1" data-toggle="modal" data-target="#confirmModal">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
{{--                        @if($vouchers->count())--}}
{{--                            @foreach($vouchers as $voucher)--}}
{{--                                <tr class="">--}}
{{--                                    <td>{{ $voucher->name }}</td>--}}
{{--                                    <td>2</td>--}}
{{--                                    <td>5</td>--}}
{{--                                    <td>20</td>--}}
{{--                                    <td>€ 365,90</td>--}}
{{--                                    <td class="text-right">--}}
{{--                                        <!-- Edit Voucher Button -->--}}
{{--                                        <a href="{{ route('vouchers.edit', $voucher->id) }}" type="button"--}}
{{--                                           class="btn btn-warning text-white mx-2">--}}
{{--                                            <i class="fas fa-edit"></i>--}}
{{--                                        </a>--}}
{{--                                        <!-- Delete Voucher Button -->--}}
{{--                                        <a href="#" class="btn btn-danger mx-2 delete-record"--}}
{{--                                           data-record-id="{{ $voucher->id }}" data-toggle="modal"--}}
{{--                                           data-target="#confirmModal">--}}
{{--                                            <i class="fas fa-trash"></i>--}}
{{--                                        </a>--}}
{{--                                        <!-- Admin Login Button -->--}}
{{--                                        <form method="post" action="{{ route('vouchers.adminLogin') }}"--}}
{{--                                              class="d-inline-block">--}}
{{--                                            @csrf--}}
{{--                                            <input type="hidden" name="tenant_id" value="{{ $voucher->id }}">--}}
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
    <link rel="stylesheet" href="{{ asset('css/vouchers.css') }}">
@stop

@section('js')
    <script>
        $('#confirmModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Button that triggered the modal
            const recordId = button.data('record-id'); // Extract record ID from data attribute
            const deleteButton = $(this).find('#confirmDelete'); // Find the delete button in the modal

            // Set the route path for deleting the record
            let deleteRoute = '{{ route('vouchers.destroy', ':id') }}';
            deleteRoute = deleteRoute.replace(':id', 100);

            // Set the onclick event for the delete button to redirect to the delete route
            deleteButton.click(function () {
                window.location.href = deleteRoute;
            });
        });
    </script>
@stop