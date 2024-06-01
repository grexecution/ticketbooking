<?php

namespace App\Http\Controllers;

use App\Models\SeatPlan\SeatPlan;
use Illuminate\Http\Request;

class SeatPlanController extends Controller
{
    public function show(SeatPlan $seatPlan, $id)
    {
        return response()->json($seatPlan->getSeatPlanWithCategories($id));
    }
}
