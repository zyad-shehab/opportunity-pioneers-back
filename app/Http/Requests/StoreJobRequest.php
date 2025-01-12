<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // السماح للجميع بإرسال الطلب
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'skills' => 'required|array',
            'skills.*' => 'string',
            'salary.monthly' => 'nullable|numeric|min:0',
            'salary.hourly' => 'nullable|numeric|min:0',
            'endDate' => 'nullable|date|after_or_equal:today',
            'typeOfWork' => 'required|in:onSite,remote',
            'workTime' => 'required|in:fulltime,parttime',
            'description' => 'required|string|min:100',
        ];
    }
    /*
    * Handle a passed validation attempt.
    *
    * @return void
 
   */
  
}