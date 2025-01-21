<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgetPasswordRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'type' => 'required|in:job-seeker,employer,supporting-initiative',
        ];
    }
}
