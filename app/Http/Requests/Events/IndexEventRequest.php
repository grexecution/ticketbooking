<?php

namespace App\Http\Requests\Events;

use App\Models\Event;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string search
 * @property string status
 */
class IndexEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('event_access');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'sometimes|max:255',
            'status' => 'sometimes|nullable|in:' . implode(',', [
                Event::STATUS_LIVE,
                Event::STATUS_HIDDEN,
                Event::STATUS_PREVIEW,
            ])
        ];
    }
}
