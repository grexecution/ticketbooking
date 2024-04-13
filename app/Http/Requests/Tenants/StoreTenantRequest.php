<?php

namespace App\Http\Requests\Tenants;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string company
 * @property string stripe_key
 * @property string stripe_secret
 * @property float stripe_fee
 * @property string logo
 * @property string logo_origin_names
 * @property string logo_sizes
 */
class StoreTenantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('tenant_access');
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
            'company' => 'required|string|max:255',
            'stripe_key' => 'sometimes|string|max:255',
            'stripe_secret' => 'sometimes|string|max:255',
            'stripe_fee' => 'required|int|min:0|max:100',
            'logo' => 'sometimes|string',
            'logo_origin_names' => 'sometimes|array',
            'logo_sizes' => 'sometimes|array',
        ];
    }
}
