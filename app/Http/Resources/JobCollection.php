<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Applications' => $this->collection->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'skills' => $job->skills,
                    'salary' => $job->salary,
                    'endDate' => $job->endDate,
                    'typeOfWork' => $job->typeOfWork,
                    'workTime' => $job->workTime,
                    'applied_at' => $job->jobSeekers->where('user_id', Auth::user()->id)->first()->pivot->created_at,
                ];
            }),
        ];
    }
}
