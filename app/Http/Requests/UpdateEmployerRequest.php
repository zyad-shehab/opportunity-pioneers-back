<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployerRequest extends FormRequest
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
            'company_name' => 'sometimes|required|max:255|unique:employers,company_name',
            'description' => 'sometimes|required|min:50',
            'location' => 'sometimes|required|max:255',
            'found_at' => 'sometimes|required|integer',
            'company_size' => 'sometimes|required|max:255',
            'about' => 'sometimes|required',
            'website' => 'sometimes|nullable|url|max:255',
            'linkedin' => 'sometimes|nullable|url|max:255',
        ];
    }
}
