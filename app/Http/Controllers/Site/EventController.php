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

    public function show(Request $request, string $slug) : Renderable
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $isPreview = false;
        $isUnavailable = false;

        if ($event->status === Event::STATUS_PREVIEW && request()->input('preview')) {
            $isPreview = true;
        } elseif ($event->status !== Event::STATUS_LIVE) {
            $isUnavailable = true;
        }

        return view('site.events.show', compact('event', 'isPreview', 'isUnavailable'));
    }
}
