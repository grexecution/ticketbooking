<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index(Request $request) : Renderable
    {
        $events = Event::where('status', Event::STATUS_LIVE)->get();
        return view('site.events.index', compact('events'));
    }

    public function show(string $id) : Renderable
    {
        $event = Event::findOrFail($id);
        if ($event->status !== Event::STATUS_LIVE) {
            abort(404);
        }
        return view('site.events.show', compact('event'));
    }
}
