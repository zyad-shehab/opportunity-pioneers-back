<?php
namespace App\Http\Requests;

use App\Models\Job;
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
            'title' => 'required|string',
            'skills' => 'required|array',
            'salary' => 'required|array',
            'salary.monthly' => 'required|numeric',
            'salary.hourly' => 'required|numeric',
            'endDate' => 'nullable|date',
            'typeOfWork' => 'required|string',
            'workTime' => 'required|string',
            'description' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
       // Convert salary to separate fields
        $this->merge([
            'salary_monthly' => $this->salary['monthly'],
            'salary_hourly' => $this->salary['hourly'],
        ]);
    }

    protected function passedValidation()
    {
      //  Remove the Salary field after converting it
        unset($this->salary);
    }

    public function saveJob($id = null)
    {
       // If the id is passed, we look for the desired function and update
        if ($id) {
            $job = Job::findOrFail($id);
            $job->update($this->validated());
        } else {
          //  If the id is not passed, we create a new function
            $job = Job::create($this->validated());
        }

      //  Return the updated or created job
        return $job;
    }
}