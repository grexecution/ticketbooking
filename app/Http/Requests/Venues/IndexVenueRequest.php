<?php

namespace App\Http\Requests\Venues;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string search
 */
class IndexVenueRequest extends FormRequest
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
            'search' => 'sometimes|max:255',
        ];
    }
}
