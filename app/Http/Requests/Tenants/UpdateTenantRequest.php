<?php

namespace App\Http\Requests\Tenants;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\File;

/**
 * @property int id
 * @property string name
 * @property string company
 * @property File logo
 * @property string stripe_key
 * @property string stripe_secret
 * @property float stripe_fee
 */
class UpdateTenantRequest extends FormRequest
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
//            'logo' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'stripe_key' => 'required|string|max:255',
            'stripe_secret' => 'required|string|max:255',
            'stripe_fee' => 'required|int|min:0|max:100',
        ];
    }
}
