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
        $events = Event::all();
        return view('site.events.index', compact('events'));
    }

    public function show(string $id) : Renderable
    {
        $event = Event::findOrFail($id);
        return view('site.events.show', compact('event'));
    }
}
