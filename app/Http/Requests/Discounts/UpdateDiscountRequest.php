<?php

namespace App\Http\Requests\Discounts;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string description
 * @property string type
 * @property float discount
 */
class UpdateDiscountRequest extends FormRequest
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
            'id' => 'required|integer|exists:discounts,id',
            'name' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string|max:4096',
            'type' => 'required|in:fixed,percentage',
            'discount' => 'required|nullable|int|min:0',
        ];
    }
}
