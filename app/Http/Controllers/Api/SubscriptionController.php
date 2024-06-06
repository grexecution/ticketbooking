<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function show(Request $request, int $id): JsonResponse
    {
        $subscription = Subscription::query()
            ->with(['events.seatPlanCategoriesForSubscriptions', 'events.venue'])
            ->findOrFail($id);

        $events = collect($subscription->events)->filter(function (Event $event) {
            return $event->status === Event::STATUS_LIVE;
        })->each(function (Event $event) {
            $event->loadSeatPlanWithCategoriesForSubscriptions();
        });

        $subscription->events = $events;
        
        return response()->json($subscription);
    }
}
