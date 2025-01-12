<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobRequest;

class JobController extends Controller
{
    // عرض جميع الوظائف
    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }

    // إنشاء وظيفة جديدة
    public function store(StoreJobRequest $request)
    {

        $validated = $request->validated();
        $validated['salary_monthly'] = $validated['salary']['monthly'];
        $validated['salary_hourly'] = $validated['salary']['hourly'];
        unset($validated['salary']);
        $validated['skills'] = json_encode($validated['skills']);

        //dd($validated);
        $job = Job::create($validated);
        return response()->json($job, 201);
    }


    // تحديث وظيفة محددة
    public function update(StoreJobRequest $request, $id)
    {
        $job = Job::findOrFail($id);
        $validated = $request->validated();
        $job->update($validated);
        return response()->json($job);
    }

    // حذف وظيفة محددة
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return response()->json(null, 204);
    }
}
