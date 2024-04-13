<?php

namespace App\Http\Requests\Tenants;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 * @property string name
 * @property string company
 * @property string logo
 * @property string logo_origin_names
 * @property string logo_sizes
 * @property string stripe_key
 * @property string stripe_secret
 * @property float stripe_fee
 */
class UpdateTenantBySuperAdminRequest extends FormRequest
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
            'id' => 'required|integer|exists:tenants,id',
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'stripe_key' => 'sometimes|nullable|string|max:255',
            'stripe_secret' => 'sometimes|nullable|string|max:255',
            'stripe_fee' => 'sometimes|nullable|int|min:0|max:100',
            'logo' => 'sometimes|nullable|string',
            'logo_origin_names' => 'sometimes|nullable|array',
            'logo_sizes' => 'sometimes|nullable|array',
        ];
    }
}
