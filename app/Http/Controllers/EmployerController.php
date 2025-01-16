<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerRequest;
use App\Http\Requests\UpdateEmployerRequest;
use App\Http\Resources\EmployerResource;
use App\Models\Employer;

class EmployerController extends Controller
{
    public function store(StoreEmployerRequest $request)
    {
        $validated = $request->validated();
        $employer = Employer::create($validated);

        return new EmployerResource([
            'id' => $employer->id,
            'company_name' => $employer->company_name,
            'location' => $employer->location,
            'found_at' => $employer->found_at,
            'company_size' => $employer->company_size,
            'about' => $employer->about,
            'website' => $employer->website,
            'linkedin' => $employer->linkedin,
            'created_at' => $employer->created_at,
            'updated_at' => $employer->updated_at,
        ]);
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
