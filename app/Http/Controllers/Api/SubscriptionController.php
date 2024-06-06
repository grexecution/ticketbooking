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
            ->whereHas('events', function ($query) {
                $query->where('status', Event::STATUS_LIVE);
            })
            ->findOrFail($id);

        collect($subscription->events)->each(function (Event $event) {
            $event->loadSeatPlanWithCategoriesForSubscriptions();
        });

        return response()->json($subscription);
    }
}
