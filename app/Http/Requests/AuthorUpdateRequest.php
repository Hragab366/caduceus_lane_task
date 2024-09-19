<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
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
        $user = $this->route('user');
        return [
            'name' => 'required|string|min:2|max:100',
            'email' => "required|email|string|min:3|max:50|unique:users,email,{$user->id}",
            'password' => [
                'nullable',
                'string',
                'confirmed',
                'min:6',
                'max:50',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).+$/', // Ensure upper, lower case, and special characters
            ],        ];
    }
    public function messages(): array
    {
        return [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one special character.',
        ];
    }
}
