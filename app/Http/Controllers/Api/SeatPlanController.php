<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SeatPlan\SeatPlan;
use Illuminate\Http\Request;

class SeatPlanController extends Controller
{
    public function getSeatPlanCategories($seatPlanId)
    {
        $seatPlan = SeatPlan::with('seatPlanCategories')->find($seatPlanId);

        if (!$seatPlan) {
            return response()->json(['message' => 'Seat plan not found'], 404);
        }

        return response()->json($seatPlan->seatPlanCategories);
    }
}
