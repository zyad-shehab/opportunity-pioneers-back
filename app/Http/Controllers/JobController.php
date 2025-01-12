<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobRequest;

class JobController extends Controller
{
  //  View All Jobs
    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }

    // create new job
    public function store(StoreJobRequest $request)
    {
       // Create the function using the function in the Request
        $job = $request->saveJob();

       // Returns the generated function as JSON
        return response()->json($job, 201);
    }

    public function update(StoreJobRequest $request, $id)
    {
        //Update the function using the function in the Request
        $updatedJob = $request->saveJob($id);

     //   Returns the updated function as JSON
        return response()->json($updatedJob);
    }


//delete job
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return response()->json(null, 204);
    }
}
