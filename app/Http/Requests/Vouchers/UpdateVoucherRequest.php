<?php

namespace App\Http\Requests\Vouchers;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property string type
 * @property float discount
 * @property int max_usage
 * @property string expired_at
 * @property array event_ids
 * @property array event_except_ids
 */
class UpdateVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('voucher_access');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:vouchers,id',
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9_-]+$/'],
            'description' => 'sometimes|nullable|string|max:4096',
            'type' => 'required|in:fixed,percentage',
            'discount' => 'required|int|min:0',
            'max_usage' => 'required|int|min:0',
            'expired_at' => 'sometimes|nullable|date',
            'event_ids' => 'sometimes|array',
            'event_except_ids' => 'sometimes|array',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.regex' => 'The name field must be a code containing only lowercase letters, numbers, hyphens, and underscores.',
        ];
    }
}
