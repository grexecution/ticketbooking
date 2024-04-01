<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Session;

class UpdatePasswordRequest extends FormRequest
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
            'password' => 'required|current_password',
            'newPassword' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'password.current_password' => 'The current password is incorrect.',
        ];
    }

    protected function failedValidation($validator): void
    {
        foreach ($validator->errors()->all() as $error) {
            Session::flash('error', $error);
        }

        parent::failedValidation($validator);
    }
}
