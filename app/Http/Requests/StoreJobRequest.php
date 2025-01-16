<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'skills' => 'required',
            'salary' => 'required',
            'salary.monthly' => 'required|numeric',
            'salary.hourly' => 'required|numeric',
            'endDate' => 'nullable|date',
            'typeOfWork' => 'required|string|in:onSite,remote',
            'workTime' => 'required|string|in:fulltime,parttime',
            'description' => 'required|string',
        ];
    }
}