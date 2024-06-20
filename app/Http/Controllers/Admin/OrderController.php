<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order) : View
    {
        $order->load(['event', 'tickets']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Display the specified resource.
     */
    public function showInvoice(string $orderId) : View
    {
        $order = Order::query()->with(['tickets'])->findOrFail($orderId);

        return view('admin.orders.invoice', compact('order'));
    }

    public function showTickets(string $orderId) : View
    {
        $order = Order::query()->with(['tickets', 'event.venue'])->findOrFail($orderId);
        abort_if($order->order_status !== 'succeeded', 403);

        return  view('admin.orders.tickets', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
