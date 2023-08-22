<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'sometimes|string',
            'address' => 'sometimes|string',
            'opening_time' => 'sometimes|date_format:H:i:s',
            'closing_time' => 'sometimes|date_format:H:i:s',
            'full_week' => 'sometimes',
            'working_days' => 'sometimes|array',
            'working_days.*' => 'integer',
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'The name of the store.',
                'example' => 'No-example',
            ],
            'description' => [
                'description' => 'The description of the store.',
                'example' => 'No-example',
            ],
            'address' => [
                'description' => 'The address of the store.',
                'example' => 'No-example',
            ],
            'full_week' => [
                'description' => 'The full week of the store.',
                'example' => 'No-example',
            ],
            'closing_time' => [
                'description' => 'The closing time of the store.',
                'example' => 'No-example',
            ],
            'working_days' => [
                'description' => 'The working days of the store.',
                'example' => 'No-example',
            ],
            'opening_time' => [
                'description' => 'The opening time of the store.',
                'example' => 'No-example',
            ],
        ];
    }
}
