<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPreferenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'is_fulltime' => 'boolean',
            'is_parttime' => 'boolean',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'The role ID field is required.',
            'role_id.exists' => 'The selected role ID does not exist.',
            'fulltime_or_parttime' => 'Either is_fulltime or is_parttime must be provided.', 
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->filled('is_fulltime') && !$this->filled('is_parttime')) {
                $validator->errors()->add('fulltime_or_parttime', $this->message('fulltime_or_parttime')); 
            }
        });
    }
}