<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showStep1()
    {
        return view('site.checkout.step1');
    }

    public function postStep1(Request $request)
    {
//        $request->validate([
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'address' => 'required',
//            'email' => 'required|email',
//            'phone' => 'required',
//        ]);

        // Save data to session or database

        return redirect('/checkout/step2');
    }

    public function showStep2()
    {
        return view('site.checkout.step2');
    }

    public function postStep2(Request $request)
    {
        // Handle payment method

        return redirect('/checkout/step3');
    }

    public function showStep3()
    {
        return view('site.checkout.step3');
    }

    public function postStep3(Request $request)
    {
        // Finalize order

        return redirect('/checkout/confirmation');
    }
}
