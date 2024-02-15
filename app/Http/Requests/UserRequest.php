<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => [
                'nullable',
                Password::defaults()
            ],
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'name' => 'required|max:100',
            'language'=>'nullable|in:es,en'
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => __('email'),
            'password' => __('password'),
            'roles' => __('roles'),
            'name' => __('name'),
        ];
    }
}
