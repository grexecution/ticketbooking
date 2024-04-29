<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class TicketScannerController extends Controller
{
    public function show(Request $request) : Renderable
    {
        return view('scanner');
    }
}
