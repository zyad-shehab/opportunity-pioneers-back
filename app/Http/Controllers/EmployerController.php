<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Http\Resources\EmployerResource;
use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function store(StoreEmployerRequest $request)
    {
        $validated = $request->validated();
        $employer = Employer::create($validated);
        return response()->json([
            'message' => "Employer created successfully.",
        ], 201);
    }
    public function update(UpdateEmployerRequest $request, $id)
    {
        $validated = $request->validated();
        $employer = Employer::findOrFail($id);
        $employer->update($validated);
        return new EmployerResource($employer);
    }
    public function show($id)
    {
        $employer = Employer::findOrFail($id);
        return new EmployerResource($employer);
    }
}
