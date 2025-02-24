<?php

namespace App\Http\Requests\ItemInStock;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemInStockRequest extends FormRequest
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
            'sku_code' => ['required', 'string', 'min:8', 'max:20'],
            'barcode' => ['required', 'string', 'min:12', 'max:50'],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'min:3', 'max:500'],
            'unity_type' => ['required', 'string'],
            'current_quantity' => ['required', 'decimal:2', 'digits_between:1,10'],
            'maximum_quantity' => ['nullable', 'decimal:2', 'digits_between:1,10'],
            'cost_price' => ['nullable', 'decimal:2', 'digits_between:1,10'],
            'sell_price' => ['nullable', 'decimal:2', 'digits_between:1,10'],
            'picture' => ['nullable', 'image', 'max:2048'], // 2MB.
            'location' => ['nullable', 'string', 'min:3', 'max:255'],
            'is_active' => ['boolean', 'nullable'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return back()->withErrors($validator->errors()->toArray())->withInput();
    }
}
