<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\JobPreferenceRequest;
use App\Models\JobPreference;

class JobPreferenceController extends Controller
{
    public function store(JobPreferenceRequest $request)
    {
        $validated = $request->validated();

        $jobPreference = JobPreference::create($validated);

        return response()->json($jobPreference, 201);
    }

    public function update(JobPreferenceRequest $request, $id)
    {
        $validated = $request->validated();

        $jobPreference = JobPreference::findOrFail($id);
        $jobPreference->update($validated);

        return response()->json($jobPreference, 200);
    }
}
