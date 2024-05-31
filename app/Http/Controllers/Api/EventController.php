<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventController extends Controller
{
    public function show(Request $request, int $id): JsonResponse
    {
        $event = Event::query()->with(['discounts', 'venue'])->findOrFail($id);
        $event->loadSeatPlanWithCategories();

        return response()->json($event);
    }

    public function index(): JsonResource
    {
        return EventResource::collection(Event::all());
    }
}
