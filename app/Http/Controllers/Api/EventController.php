<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkin;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Request $request, int $id): JsonResponse
    {
        $event = Event::query()->with(['discounts', 'venue', 'bookings', 'orders'])->findOrFail($id);
        $event->loadSeatPlanWithCategories();

        return response()->json($event);
    }

    public function index(): JsonResponse
    {
        $events = Event::query()->with(['venue'])->get()->map(function ($event) {
            $event->loadSeatPlanWithCategories();
            return $event;
        });

        return response()->json($events);
    }

    public function checkIn(Request $request, int $id, int $ticketId): JsonResponse
    {
        /** @var Event $event */
        $event = Event::with(['venue', 'seatPlanCategories'])->findOrFail($id);
        $ticket = Ticket::findOrFail($ticketId);

        try {
            $checkin = Checkin::create([
                'event_id' => $event->id,
                'ticket_id' => $ticket->id,
                'event_seat_plan_category_id' => $ticket->event_seat_plan_category_id,
                'category' => $ticket->eventSeatPlanCategory->name,
                'seat' => $ticket->seat,
                'row' => $ticket->row,
            ]);

            return response()->json([
                'data' => $checkin,
                'event' => $event,
                'venue' => $event->venue,
                'checkins' => $event->refresh()->checkins->count(),
                'places' => $event->seatPlanCategories->sum('places'),
            ]);

        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error while checkin ticket!']);
        }
    }

}
