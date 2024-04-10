<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SupportRequestMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
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

    public function supportRequest(Request $request): RedirectResponse
    {
        try {
            Mail::to(config('mail.admin.address'))->send(new SupportRequestMail(auth()->user(), $request->all()));
        } catch (\Exception $e) {
            return redirect()->route('website')->with('error', 'Operation failed!');
        }

        return redirect()->route('settings')->with('success', 'Operation successful!');
    }

}
