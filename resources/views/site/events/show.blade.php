@extends('layouts.site')

@section('title', 'Show Event')

@section('content')
{{--    <h1>Show Event # {{ Route::current()->parameter('eventId') }}</h1>--}}
<div class="bg-white border-bottom">
    <div class="container">
        <div class="row mt-5 mb-5">
            <!-- Event Banner -->
            <div class="col-lg-8">
                <div class="event-banner">
                    <!-- Title -->
                    <div class="row">
                        <div class="col">
                            <h1 class="event-title">{{ $isPreview ? 'Preview: ' : '' }}{{ $event->name }}</h1>
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="row">
                        <div class="col">
                            <p>{!! $event->description !!}</p>
                        </div>
                    </div>
                    <!-- Event Details -->
                    <div class="row">
                        <div class="col d-flex gap-6">
                            <div class="event-detail">
                                <i class="fas fa-calendar-alt"></i> {{ $event->start_date?->format('l, d.m.Y') ?? '' }} | {{ $event->start_time?->format('g:i a') ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-map-marker-alt"></i> {{ $event->venue?->name ?? '' }}
                            </div>
                            <div class="event-detail">
                                <i class="fas fa-money-bill"></i> Preis ab €{{ $event->price ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Event Image -->
            <div class="col-lg-4">
{{--                <img src="{{ asset('img/event_detail.png') }}" alt="Event Image" class="img-fluid rounded">--}}
                <img src="{{ $event->logo_event_url }}" alt="Event Image" class="img-fluid rounded event-image">
            </div>
        </div>

        <!-- Seats and Pricing -->
{{--        <div class="row">--}}
{{--            <h1>Seat Plan Canvas</h1>--}}
{{--            <div class="seats_container"></div>--}}
{{--        </div>--}}
{{--        <div class="row mt-4">--}}
{{--            <!-- Pricing Blocks -->--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-md-3">--}}
{{--                        <img src="{{ asset('img/seat_A.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                        <div class="pricing-info">--}}
{{--                            <div>Category A</div>--}}
{{--                            <div>€ 28,00</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3">--}}
{{--                        <img src="{{ asset('img/seat_B.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                        <div class="pricing-info">--}}
{{--                            <div>Category B</div>--}}
{{--                            <div>€ 38,00</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3">--}}
{{--                        <img src="{{ asset('img/seat_C.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                        <div class="pricing-info">--}}
{{--                            <div>Category C</div>--}}
{{--                            <div>€ 38,00</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-3">--}}
{{--                        <img src="{{ asset('img/seat_D.png') }}" alt="Small Image" class="img-fluid">--}}
{{--                        <div class="pricing-info">--}}
{{--                            <div>Category D</div>--}}
{{--                            <div>€ 8,00</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Seat Layout -->

    </div>
</div>
<div class="main-bg">
    <div class="row py-6 mb-5 container m-auto">
            <div class="col">
                <div class="text-center mb-2 bg-white py-6">STAGE</div>
{{--                <div class="seat-layout">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-1"></div>--}}
{{--                        @for($k = 0; $k < 10; $k++)--}}
{{--                            <div class="col seat-header">{{chr(65 + $k)}}</div>--}}
{{--                        @endfor--}}
{{--                    </div>--}}
{{--                    @for($i = 0; $i < 10; $i++)--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-1">{{$i + 1}}</div>--}}
{{--                            @for($j = 0; $j < 10; $j++)--}}
{{--                                <div class="col seat">--}}
{{--                                    <img src="{{ asset('img/seat_A.png') }}" alt="Specific Seat" class="img-fluid m-1" onclick="openPopup('Row {{ $i + 1 }} - Seat {{ chr(65 + $j) }}', '€ 39,90')">--}}
{{--                                </div>--}}
{{--                            @endfor--}}
{{--                        </div>--}}
{{--                    @endfor--}}
{{--                </div>--}}
            </div>
        </div>
</div>


    <div class="absolute flex flex-col h-screen w-100">
        {{--    <div class="bg-[#ab1f34] flex justify-center border-b border-[#d05063]">--}}
        {{--        <img class="h-11 py-1" src="logo_small.jpg">--}}
        {{--        <div class="absolute h-12 right-3 flex flex-row gap-3 items-center content-center">--}}
        {{--            <a class="github-button" href="https://github.com/alisaitteke/seatmap-canvas/subscription"--}}
        {{--               data-icon="octicon-eye" aria-label="Watch alisaitteke/seatmap-canvas on GitHub">Watch</a>--}}
        {{--            <a class="github-button" href="https://github.com/alisaitteke" aria-label="Follow @alisaitteke on GitHub">Follow--}}
        {{--                @alisaitteke</a>--}}
        {{--            <a class="github-button" href="https://github.com/alisaitteke/seatmap-canvas/fork"--}}
        {{--               data-icon="octicon-repo-forked" aria-label="Fork alisaitteke/seatmap-canvas on GitHub">Fork</a></div>--}}
        {{--    </div>--}}
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
{{--                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1 px-3 rounded-md hover:bg-slate-200 zoom-to-block"--}}
{{--                            data-block-id="block-0">--}}
{{--                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>--}}
{{--                        Zoom Block 1--}}
{{--                    </button>--}}
                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1  px-3 rounded-md hover:bg-slate-200 zoom-to-block"
                            data-block-id="block-1">
                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>
                        Zoom Block 2
                    </button>
{{--                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1  px-3 rounded-md hover:bg-slate-200 zoom-to-block"--}}
{{--                            data-block-id="block-2">--}}
{{--                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>--}}
{{--                        Zoom Block 3--}}
{{--                    </button>--}}
{{--                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1  px-3 rounded-md hover:bg-slate-200 zoom-to-block"--}}
{{--                            data-block-id="block-3">--}}
{{--                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>--}}
{{--                        Zoom Block 4--}}
{{--                    </button>--}}
{{--                    <button class="border text-left border-slate-500 bg-slate-100 text-slate-800 py-1  px-3 rounded-md hover:bg-slate-200"--}}
{{--                            id="randomize-btn"--}}
{{--                            data-block-id="block-2">--}}
{{--                        <i class="fa-solid fa-magnifying-glass-plus mr-2"></i>--}}
{{--                        Randomize--}}
{{--                    </button>--}}
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

    <!-- Popup Modal -->
{{--    <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="popupModalLabel">Your Places</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <ul class="list-group" id="ticketList">--}}
{{--                        <!-- Add rows for selected tickets here -->--}}
{{--                        <li class="list-group-item d-flex justify-content-between align-items-center">Row 1 - Seat 1<span class="badge badge-primary badge-pill">€ 39,90</span><span class="remove-icon" onclick="removeTicket(this)">Remove</span></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <div>Total</div>--}}
{{--                    <div>€ 45,90</div>--}}
{{--                    <button type="button" class="btn btn-warning" onclick="checkout()">To the checkout</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            <h5 class="card-title">{{ $event?->name ?? '' }}</h5>--}}
{{--            <p class="card-text">{{ $event?->description ?? '' }}</p>--}}
{{--            <!-- Add more details about the event -->--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('styles')
    <style>
        .event-banner {
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .event-detail {
            margin-bottom: 10px;
        }

        .pricing-info {
            padding: 10px;
            text-align: center;
        }

        .seat-layout {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
        }

        .seat {
            width: 41px;
            height: 40px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            margin: 2px;
            position: relative;
        }

        .seat img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .seat-header {
            background-color: #e9ecef;
            text-align: center;
            font-weight: bold;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // function openPopup(ticketInfo, price) {
        //     // Populate ticket information
        //     var ticketItem = `
        //         <li class="list-group-item d-flex justify-content-between align-items-center">${ticketInfo}<span class="badge badge-primary badge-pill">${price}</span><span class="remove-icon" onclick="removeTicket(this)">Remove</span></li>
        //     `;
        //     // Append ticket item to the ticket list
        //     document.getElementById('ticketList').innerHTML += ticketItem;
        //     // Show the popup modal
        //     $('#popupModal').modal('show');
        // }
        //
        // // Function to remove a ticket row
        // function removeTicket(element) {
        //     element.parentNode.remove();
        // }
        //
        // // Function to handle checkout
        // function checkout() {
        //     // Perform checkout operation here
        //     // For example, redirect to checkout page
        //     // window.location.href = '/checkout';
        // }

        $(document).ready(function () {
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
@endpush
