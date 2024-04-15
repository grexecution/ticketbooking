<?php

namespace App\Http\Requests\Discounts;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string search
 */
class IndexDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('discount_access');
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
