<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'type' => 'required|in:job-seeker,employer,supporting-initiative',
            'new_password' => 'required|string|min:8',
        ];
    }
}
