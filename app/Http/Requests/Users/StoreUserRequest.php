<?php

namespace App\Http\Requests\Users;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int tenant_id
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string password
 * @property bool google2fa_enable
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('user_access');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tenant_id' => 'required|integer|exists:tenants,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|max:255',
            'google2fa_enable' => 'required|boolean',
        ];
    }
}
