<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:45',
            'code' => 'nullable|max:3',
            'num' => 'nullable|max:3',
            'symbol' => 'nullable|max:5',
            'symbol_native' => 'nullable|max:5',
            'num_decimals' => 'required|max:10|numeric',
        ];
    }
}
