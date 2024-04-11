<?php

namespace App\Http\Requests\Tenants;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 * @property string name
 * @property string company
 * @property string logo
 * @property string logo_origin_names
 * @property string logo_sizes
 */
class UpdateTenantByAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
            'logo' => 'sometimes|string',
            'logo_origin_names' => 'sometimes|array',
            'logo_sizes' => 'sometimes|array',
        ];
    }
}
