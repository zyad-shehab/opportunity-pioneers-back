<?php
namespace App\Http\Controllers;

use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return Job::all();
    }

    public function store(StoreJobRequest $request)
    {
        $job = Job::create($request->validated());
        return response()->json($job, 201);
        $validated['salary_monthly'] = $validated['salary']['monthly'];
        $validated['hourly'] = $validated['salary']['hourly'];

    }

    public function show($id)
    {
        return Job::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $job->update($request->all());
        return response()->json($job, 200);
    }

    public function destroy($id)
    {
        Job::destroy($id);
        return response()->json(null, 204);
    }
}