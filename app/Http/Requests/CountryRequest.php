<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if (!isset($this->is_eu)) {
            $this->merge([
                'is_eu' => false
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'is_eu' => 'boolean',
            'name' => 'required',
            'full_name' => 'nullable',
            'capital' => 'nullable',
            'code' => 'nullable|max:4',
            'code_alpha3' => 'nullable|max:6',
            'currency_code' => 'nullable|max:3',
            'currency_name' => 'nullable|max:128',
            'tld' => 'nullable|max:8',
            'callingcode' => 'nullable|max:8',
        ];
    }
}
