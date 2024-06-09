<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\SeatPlan\EventSeatPlanCategory;
use App\Models\Ticket;

class BookingService
{

    public function findAvailableTicketsByCategory(EventSeatPlanCategory $category, int $count) : array
    {
        // init all rows
        $rows = [];
        for ($i = 0; $i < $category->rows; $i++) {
            $rows[] = [];
            for ($k = 0; $k < $category->seats; $k++) {
                $rows[$i] = range(1, $category->seats);
            }
        }

        // fill bought seats
        $reserved = [];
        Ticket::query()->where('event_seat_plan_category_id', $category->id)->get()->each(function (Ticket $ticket) use (&$reserved) {
            $rowIndex = $ticket->row - 1;
            $reserved[$rowIndex][] = $ticket->seat;
        });
        if ($category->parent_id) {
            Ticket::query()->where('event_seat_plan_category_id', $category->parent_id)->get()->each(function (Ticket $ticket) use (&$reserved) {
                $rowIndex = $ticket->row - 1;
                $reserved[$rowIndex][] = $ticket->seat;
            });
        }

        // fill booked seats
        $category->bookings->each(function (Booking $booking) use (&$reserved) {
            $rowIndex = $booking->row - 1;
            $reserved[$rowIndex][] = $booking->seat;
        });
        if ($category->parent_id) {
            $category->load('parent.bookings');
            $category->parent->bookings->each(function (Booking $booking) use (&$reserved) {
                $rowIndex = $booking->row - 1;
                $reserved[$rowIndex][] = $booking->seat;
            });
        }

        $return = [];
        $currRowIndex = 0;
        // try to find places near each other
        for ($i = 0; $i < count($rows); $i++) {
            for ($r = 0; $r < count($rows[$i]); $r++) {
                if ($currRowIndex !== $i) {
                    $return = [];
                }
                if (! in_array($rows[$i][$r], $reserved[$i] ?? [])) {
                    $foundRow = $i + 1;
                    $return[] = [$foundRow => $rows[$i][$r]];
                } else {
                    $return = [];
                }
                if (count($return) === $count) {
//                    dump('Row: ' . $i + 1 . ' Seats: ' . implode(',', $return));
                    return [$return, true];
                }
                $currRowIndex = $i;
            }
        }

        // if not find try to find any places
        for ($i = 0; $i < count($rows); $i++) {
            for ($r = 0; $r < count($rows[$i]); $r++) {
                if (! in_array($rows[$i][$r], $reserved[$i] ?? [])) {
                    $foundRow = $i + 1;
                    $return[] = [$foundRow => $rows[$i][$r]];
                }
                if (count($return) === $count) {
//                    dump('Row: ' . $i + 1 . ' Seats: ' . implode(',', $return));
                    return [$return, false];
                }
            }
        }

        return [[], false];
    }

}
