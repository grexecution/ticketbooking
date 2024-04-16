<?php

namespace App\Http\Requests\Vouchers;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string description
 * @property string type
 * @property float discount
 * @property int max_usage
 * @property string expired_at
 * @property array event_ids
 * @property array event_except_ids
 */
class StoreVoucherRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'sometimes|nullable|string|max:4096',
            'type' => 'required|in:fixed,percentage',
            'discount' => 'required|int|min:0',
            'max_usage' => 'required|int|min:0',
            'expired_at' => 'sometimes|nullable|date',
            'event_ids' => 'sometimes|array',
            'event_except_ids' => 'sometimes|array',
        ];
    }
}
