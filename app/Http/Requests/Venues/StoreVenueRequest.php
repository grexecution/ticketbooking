<?php

namespace App\Http\Requests\Venues;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string address
 * @property string zipcode
 * @property string city
 * @property string country
 * @property string email
 * @property string phone
 * @property string website
 * @property string description
 * @property string logo
 * @property string logo_origin_names
 * @property string logo_sizes
 */
class StoreVenueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('venue_access');
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
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:20',
            'website' => 'required|string|url|max:255',
            'description' => 'required|string|max:4096',
            'logo' => 'required|string',
            'logo_origin_names' => 'required|array',
            'logo_sizes' => 'required|array',
        ];
    }
}
