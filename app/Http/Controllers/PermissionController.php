<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $permission = Permission::all();

            if ($permission && $permission->count() >= 1) {
                return $this->successResponse($permission, 'get permission data success', 200);
            } else {
                return $this->notFoundResponse('permission');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to get permissions', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidationFactory()->make($request->all(), [
                'role' => 'required|integer|min:1|exists:App\Models\Role,id',
                'module' => 'required|integer|min:1|exists:App\Models\Modules,id',
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $input = $request->all();
            $input['name'] = Role::find($request->role)->name.' - '.Modules::find($request->module)->name;
            $permission = Permission::create($input);

            return $this->successResponse($permission, 'permission added successfully!', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to add permission', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        try {

            $validator = $this->getValidationFactory()->make($request->all(), [
                'role' => 'required|integer|min:1|exists:App\Models\Role,id',
                'module' => 'required|integer|min:1|exists:App\Models\Modules,id',
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $selectedPermission = Permission::find($permission->id);
            $selectedPermission->role = $request->role;
            $selectedPermission->module = $request->module;
            $selectedPermission->name = Role::find($request->role)->name.' - '.Modules::find($request->module)->name;
            $selectedPermission->save();

            return $this->successResponse(null, "Success to update permission");

        } catch (\Throwable $th) {
            return $this->errorResponse('failed to update permission', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        try {
            $selectedPermission=Permission::find($permission->id);
            $selectedPermission->delete();

            return $this->successResponse(null, "Success to delete permission");
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to delete permission', 500);
        }
    }
}
