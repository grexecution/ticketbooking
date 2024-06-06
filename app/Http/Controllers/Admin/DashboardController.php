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
        $orders = Order::all();

        return view('admin.dashboard', compact('totalEvents', 'totalSum', 'totalOrders', 'orders'));
    }
}
