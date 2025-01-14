<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerRequest extends FormRequest
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
            'company_name' => 'required|max:255|unique:employers,company_name',
            'description' => 'required|min:50',
            'location' => 'required|max:255',
            'found_at' => 'required|integer',
            'company_size' => 'required|max:255',
            'about' => 'required',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
        ];
    }
}
