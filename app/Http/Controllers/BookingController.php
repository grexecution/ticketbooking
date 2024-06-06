<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\SeatPlan\EventSeatPlanCategory;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function bookTickets(Request $request, Event $event) : JsonResponse
    {
        $request->validate([
            'tickets' => 'required|array',
            'tickets.*.categoryId' => 'required|exists:event_seat_plan_categories,id',
            'tickets.*.count' => [
                'required',
                'integer',
                'min:1',
                // Custom validation closure for checking available tickets in the category
                function ($attribute, $value, $fail) use ($request, $event) {
                    $index = explode('.', $attribute)[1];
                    $categoryId = $request->input("tickets.$index.categoryId");
                    $category = EventSeatPlanCategory::where('id', $categoryId)
                        ->where('event_id', $event->id)
                        ->first();
                    if (! $category) {
                        $fail('Invalid category.');
                        return;
                    }

                    $bookedTicketsCount = $category->bookings()
                        ->where('expires_at', '>', now())
                        ->count();
                    $availableTickets = $category->places - $bookedTicketsCount;

                    if ($value > $availableTickets) {
                        $fail('The requested number of tickets exceeds the available tickets for "' . $category->name . '" category.');
                    }
                }
            ],
            'tickets.*.seat' => 'sometimes|nullable|int',
            'tickets.*.row' => 'sometimes|nullable|int',
        ]);

        $sessionId = Session::getId();
        // Set session_id cookie
        Cookie::queue(Cookie::make('session_id', $sessionId, 10));

        Booking::query()->where('session_id', $sessionId)->delete();

        $bookings = [];
        foreach ($request->tickets as $ticket) {
            for ($i = 0; $i < $ticket['count']; $i++) {
                $booking = Booking::create([
                    'event_id' => $event->id,
                    'event_seat_plan_category_id' => $ticket['categoryId'],
                    'session_id' => $sessionId,
                    'seat' => $ticket['seat'] ?? null,
                    'row' => $ticket['row'] ?? null,
                    'expires_at' => Carbon::now()->addMinutes(10),
                ]);
                $bookings[] = $booking;
            }
        }

        return response()->json(['bookings' => $bookings, 'session_id' => $sessionId]);
    }

    public function bookSubscriptionTickets(Request $request) : JsonResponse
    {
        $request->validate([
            'tickets' => 'required|array',
            'tickets.*.id' => 'required|exists:event_seat_plan_categories,id',
            'tickets.*.event_id' => 'required|exists:events,id',
            'tickets.*.count' => [
                'required',
                'integer',
                'min:1',
                // Custom validation closure for checking available tickets in the category
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $categoryId = $request->input("tickets.$index.id");
                    $eventId = $request->input("tickets.$index.event_id");
                    $category = EventSeatPlanCategory::query()
                        ->where('id', $categoryId)
                        ->where('event_id', $eventId)
                        ->firstOrFail();

                    $parentCategory = EventSeatPlanCategory::query()
                        ->where('parent_id', $category->parent_id)
                        ->firstOrFail();

                    $bookedTicketsCount = $parentCategory->bookings()
                        ->where('expires_at', '>', now())
                        ->count();

                    $availableTickets = $parentCategory->places - $bookedTicketsCount;

                    if ($value > $availableTickets) {
                        $fail('The requested number of tickets exceeds the available tickets for "' . $category->name . '" category.');
                    }
                }
            ],
        ]);

        $sessionId = Session::getId();
        // Set session_id cookie
        Cookie::queue(Cookie::make('session_id', $sessionId, 10));

        Booking::query()->where('session_id', $sessionId)->delete();

        $bookings = [];
        foreach ($request->tickets as $ticket) {
            for ($i = 0; $i < $ticket['count']; $i++) {
                $booking = Booking::create([
                    'event_id' => $ticket['event_id'],
                    'event_seat_plan_category_id' => $ticket['id'],
                    'session_id' => $sessionId,
                    'seat' => $ticket['seat'] ?? null,
                    'row' => $ticket['row'] ?? null,
                    'expires_at' => Carbon::now()->addMinutes(10),
                ]);
                $bookings[] = $booking;
            }
        }

        return response()->json(['bookings' => $bookings, 'session_id' => $sessionId]);
    }

    public function getBookingStartTime($sessionId) : JsonResponse
    {
        $booking = Booking::where('session_id', $sessionId)->latest()->first();
        if ($booking) {
            return response()->json(['start_time' => $booking->created_at]);
        } else {
            return response()->json(['start_time' => null], 404);
        }
    }

    public function expireBookings($sessionId) : void
    {
        Booking::query()->where('session_id', $sessionId)->delete();
    }
}
