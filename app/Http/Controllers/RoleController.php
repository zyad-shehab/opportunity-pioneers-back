<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        return response()->json(['roles' => RoleResource::collection($roles)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|min:5|max:255|unique:roles,role'
        ]);

        $role = Role::create(request()->all());

        return response()->json(['role' => new RoleResource($role)]);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        response()->noContent();
    }
}
