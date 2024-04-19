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
            // ToDo need to replace after implementation event categories
            'categories' => SeatCategoryResource::collection([
                ['id' => 1, 'name' => 'Category A',],
                ['id' => 2, 'name' => 'Category VIP',],
            ]),
//            'categories' => SeatCategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
