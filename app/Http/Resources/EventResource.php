<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'seat_type' => $this->seat_type,
            'discounts' => $this->discounts,
            'categories' => SeatCategoryResource::collection($this->seat_plan_categories),
        ];
    }
}
