<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string',
            'store_id' => 'required',
            'description' => 'sometimes',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0'
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'The name of the product.',
                'example' => 'No-example',
            ],
            'store_id' => [
                'description' => 'The id of the store.',
                'example' => 'No-example',
            ],
            'description' => [
                'description' => 'The description of the product.',
                'example' => 'No-example',
            ],
            'price' => [
                'description' => 'The price of the product.',
                'example' => 'No-example',
            ],
            'quantity' => [
                'description' => 'The quantity of the product.',
                'example' => 'No-example',
            ],
        ];
    }
}
