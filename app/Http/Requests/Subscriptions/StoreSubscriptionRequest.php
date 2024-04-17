<?php

namespace App\Http\Requests\Subscriptions;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string short_desc
 * @property string description
 * @property float  price
 * @property string logo
 * @property string logo_origin_names
 * @property string logo_sizes
 */
class StoreSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('subscription_access');
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
            'price' => 'required|numeric|min:0',
            'logo' => 'sometimes|nullable|string',
            'logo_origin_names' => 'sometimes|nullable|array',
            'logo_sizes' => 'sometimes|nullable|array',
        ];
    }
}
