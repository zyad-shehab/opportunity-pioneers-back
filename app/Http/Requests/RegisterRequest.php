<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'full_name' => 'required|string|min:3|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('type', $this->input('type'));
                }),
            ],
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string|min:8',
            'type' => 'required|string|in:job-seeker,employer,supporting-initiative',
            'country' => [
                Rule::requiredIf(function () {
                    return in_array($this->input('type'), ['employer', 'supporting-initiative']);
                }),
                'exists:countries,name_en',
            ],
        ];
    }
}
