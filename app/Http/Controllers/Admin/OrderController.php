<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Dompdf\Dompdf;
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
    public function showInvoice(string $orderId)
    {
        $order = Order::query()->with(['tickets'])->findOrFail($orderId);

//        $html = view('admin.orders.invoice', compact('order'))->render();

//        $dompdf = new Dompdf();
//        $dompdf->loadHtml($html);
//        $customPaper = [0,0,675,800];
//        $dompdf->setPaper($customPaper, 'portrait');
//        $dompdf->render();
//
//        $output = $dompdf->output();
//
//        $headers = [
//            'Content-Type' => 'application/pdf',
//            'Content-Length' => strlen($output),
//            'Cache-Control' => 'private, max-age=0, must-revalidate',
//            'Pragma' => 'public',
//            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
//            'Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT',
//        ];
//
//        return response($output, 200, $headers);

        return view('admin.orders.invoice', compact('order'));
    }

    public function showTickets(string $orderId)
    {
        $data = [
            'orderId' => $orderId,
        ];

        $html = view('admin.orders.ticket', $data)->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $customPaper = [0,0,675,800];
        $dompdf->setPaper($customPaper, 'portrait');
        $dompdf->render();

        $output = $dompdf->output();

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Length' => strlen($output),
            'Cache-Control' => 'private, max-age=0, must-revalidate',
            'Pragma' => 'public',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
            'Last-Modified' => gmdate('D, d M Y H:i:s') . ' GMT',
        ];

        return response($output, 200, $headers);
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
