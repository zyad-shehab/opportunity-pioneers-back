<?php

namespace App\Http\Controllers;

use App\Models\JobPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobPreferenceController extends Controller
{
    public function store(Request $request)
    {
        //check at least one of filled
        if (!$request->filled('fulltime') && !$request->filled('parttime')) {
            return response()->json(['error' => 'Either fulltime or parttime must be provided.'], 422);
        }

        //Role_id must be exist
        if (!$request->has('role_id')) {
            return response()->json(['error' => 'Role ID is required.'], 422);
        }

        //if conditions is true
        $jobPreference = JobPreference::create($request->all());

        return response()->json($jobPreference, 201);
    }


    public function update(Request $request, $id)
    {
        // check at least one filled
        if (!$request->filled('fulltime') && !$request->filled('parttime')) {
            return response()->json(['error' => 'Either fulltime or parttime must be provided.'], 422);
        }

        //Role_id must be exist
        if (!$request->has('role_id')) {
            return response()->json(['error' => 'Role ID is required.'], 422);


            $jobPreference = JobPreference::findOrFail($id);

            //update date if the conditions is true
            $jobPreference->fulltime = $request->fulltime;
            $jobPreference->parttime = $request->parttime;
            $jobPreference->role_id = $request->role_id;

            $jobPreference->save();

            return response()->json($jobPreference, 200);
        }
    }
}
