<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'type' => 'required|string|in:job-seeker,employer,supporting-initiative',
            'code' => 'required|string|size:5',
        ];
    }
}
