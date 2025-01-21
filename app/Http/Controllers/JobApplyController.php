<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobCollection;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobApplyController extends Controller
{
    public function apply($jobId)
    {
        $user = Auth::user();
        $job = Job::findOrFail($jobId);

        // Check if user is a job-seeker
        if (!$user->jobSeeker()->exists()) {
            return response()->json([
                'message' => 'Only job seekers are allowed to apply for jobs!',
            ], 403);
        }

        $jobSeeker = $user->jobSeeker;

        // Check if user has already applied for this job
        if ($jobSeeker->jobs()->where('job_id', $job->id)->exists()) {
            return response()->json([
                'message' => 'You have already applied for this job!',
            ]);
        }

        $jobSeeker->jobs()->syncWithoutDetaching($job->id);

        return response()->json([
            'message' => 'Applied successfully.',
        ], 201);
    }
    public function inapply($jobId)
    {
        $user = Auth::user();
        $job = Job::findOrFail($jobId);

        // Check if user is a job-seeker
        if (!$user->jobSeeker()->exists()) {
            return response()->json([
                'message' => 'Only job seekers are allowed to do this action!',
            ], 403);
        }

        $jobSeeker = $user->jobSeeker;

        // Check if user has already applied to this job
        if (!$jobSeeker->jobs()->where('job_id', $job->id)->exists()) {
            return response()->json([
                'message' => 'You have not applied for this job yet!',
            ], 404);
        }

        $jobSeeker->jobs()->detach($job->id);

        return response()->json([
            'message' => 'Application removed successfully.',
        ]);

    }
    public function index()
    {
        $user = Auth::user();

        // Check if user is a job-seeker
        if (!$user->jobSeeker()->exists()) {
            return response()->json([
                'message' => 'Only job seekers are allowed to view thire applications!',
            ], 403);
        }

        $jobSeeker = $user->jobSeeker;

        $applications = $jobSeeker->jobs;
        return new JobCollection($applications);
    }
}
