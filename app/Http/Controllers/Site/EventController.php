<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index(Request $request) : Renderable
    {
        $events = [];
        return view('site.events.index', compact('events'));
    }

    public function show(string $id) : Renderable
    {
        $event = new \stdClass();
        return view('site.events.show', compact('event'));
    }
}
