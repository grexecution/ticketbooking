<?php

namespace App\Http\Requests\Events;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string short_desc
 * @property string description
 * @property int venue_id
 * @property int program_id
 * @property array artist_ids
 * @property array discount_ids
 * @property string start_date
 * @property string start_time
 * @property string doors_open_time
 * @property float price
 * @property string logo
 * @property array logo_origin_names
 * @property array logo_sizes
 * @property array partners
 * @property array partners_origin_names
 * @property array partners_sizes
 */
class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('event_access');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'short_desc' => 'sometimes|nullable|string|max:256',
            'description' => 'sometimes|nullable|string|max:4096',
            'venue_id' => 'sometimes|nullable|exists:venues,id',
            'program_id' => 'sometimes|nullable',
            'artist_ids' => 'sometimes|nullable|array',
            'discount_ids' => 'sometimes|nullable|array',
            'start_date' => 'sometimes|nullable|date',
            'start_time' => 'sometimes|nullable|string',
            'doors_open_time' => 'sometimes|nullable|string',
            'price' => 'sometimes|nullable|numeric',
            'logo' => 'sometimes|nullable|string',
            'logo_origin_names' => 'sometimes|nullable|array',
            'logo_sizes' => 'sometimes|nullable|array',
            'partners' => 'sometimes|nullable|array',
            'partners_origin_names' => 'sometimes|nullable|array',
            'partners_sizes' => 'sometimes|nullable|array',
        ];
    }
}
