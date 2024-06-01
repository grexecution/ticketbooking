<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CustomerDataRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function showStep1() : View
    {
        return view('site.checkout.step1');
    }

    public function showStep2(CustomerDataRequest $request) : View
    {
        $validatedData = $request->validated();
        Session::put('customer_data', $validatedData);

        return view('site.checkout.step2');
    }

    public function showStep3(Request $request) : View
    {
        $order = Order::query()
            ->with(['event.venue', 'tickets'])
            ->findOrFail($request->order_id);

        return view('site.checkout.step3', compact('order'));
    }
}
