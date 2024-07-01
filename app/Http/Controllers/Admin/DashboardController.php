<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Event;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $totalOrders = 0;
        if ($user->tenant) {
            $userIds = User::query()->where('tenant_id', $user->tenant->id)->pluck('id')->toArray();
            $totalOrders = Order::succeeded()->whereIn('user_id', $userIds)->count();
        }

        $totalEvents = Event::count();
        $totalSum = Order::succeeded()->sum('total');

        // Filter orders based on selected event
        $orders = Order::query();
        if ($request->has('event')) {
            $orders->where('event_id', $request->event);
        }
        $orders = $orders->get();

        $events = Event::all();

        return view('admin.dashboard', compact('totalEvents', 'totalSum', 'totalOrders', 'orders', 'events'));
    }
}
