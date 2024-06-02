<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Show the subscription page.
     *
     * @param Request $request
     * @param string $id
     * @return Renderable
     */
    public function show(Request $request, string $id) : Renderable
    {
        $subscription = Subscription::with('events')->find($id);

        return view('site.events.subscription', compact('subscription'));
    }
}
