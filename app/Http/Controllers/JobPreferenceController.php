<?php

namespace App\Http\Controllers;

use App\Models\JobPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobPreferenceController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'isfulltime' => 'boolean',
            'isparttime' => 'boolean',
            'role_id' => 'required|integer|exists:roles,id',
        ])->after(function ($validator) use ($request) {
            if (!$request->filled('isfulltime') && !$request->filled('isparttime')) {
                $validator->errors()->add('fulltime_or_parttime', 'Either fulltime or parttime must be provided.');
            }
        });

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jobPreference = JobPreference::create($request->all());

        return response()->json($jobPreference, 201);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'isfulltime' => 'boolean',
            'isparttime' => 'boolean',
            'role_id' => 'required|integer|exists:roles,id',
        ])->after(function ($validator) use ($request) {
            if (!$request->filled('isfulltime') && !$request->filled('isparttime')) {
                $validator->errors()->add('fulltime_or_parttime', 'Either fulltime or parttime must be provided.');
            }
        });

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jobPreference = JobPreference::findOrFail($id);

        $jobPreference->update($request->only(['isfulltime', 'isparttime', 'role_id']));

        return response()->json($jobPreference, 200);
    }
}
