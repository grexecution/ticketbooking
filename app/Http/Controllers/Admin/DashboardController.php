<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $tenant = $user->tenant; // Assuming the user has a tenant relationship

        // Calculate the total number of orders for the tenant
        $totalOrders = Order::count();
        if ($tenant) {
            foreach ($tenant->events as $event) {
                $totalOrders += $event->orders->count();
            }
        }

        // Calculate the total number of events
        $totalEvents = Event::count();

        // Calculate the total sum of "total" from orders
        $totalSum = Order::sum('total');

        $orders = Order::all();
        return view('admin.dashboard', ['totalOrders' => $totalOrders, 'totalEvents' => $totalEvents, 'totalSum' => $totalSum, 'orders' => $orders]);
    }
}
