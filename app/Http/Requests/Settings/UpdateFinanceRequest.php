<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 * @property string stripe_key
 * @property string stripe_secret
 */
class UpdateFinanceRequest extends FormRequest
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
            'id' => 'required|exists:tenants,id',
            'stripe_key' => 'required|string|max:255',
            'stripe_secret' => 'required|string|max:255',
        ];
    }
}
