<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'title' => 'nullable|string|min:2|max:100',
            'description' => 'nullable|string|min:5|max:500',
            'bio' => 'nullable|string|min:5|max:500',
            'cover' => 'nullable|mimes:png,jpg,jpeg,webp',
            'published_at'=>'nullable|date'
        ];
    }
}
