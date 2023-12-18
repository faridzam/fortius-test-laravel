<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Get Roles
     *
     * get roles data
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "get role data success",
     *      "data": [
     *           {
     *               "id": 1,
     *               "name": "Software Engineer",
     *               "created_at": null,
     *               "updated_at": null
     *           },
     *           {
     *               "id": 2,
     *               "name": "HR Manager",
     *               "created_at": null,
     *               "updated_at": null
     *           },
     *           {
     *               "id": 3,
     *               "name": "HR Staff",
     *               "created_at": null,
     *               "updated_at": "2023-12-18T08:04:41.000000Z"
     *           }
     *       ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $role = Role::all();

            if ($role && $role->count() >= 1) {
                return $this->successResponse($role, 'get role data success', 200);
            } else {
                return $this->notFoundResponse('roles');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to get roles', 500);
        }
    }

    /**
     * Create Role
     *
     * Add a new item on the role.
     *
     * @bodyParam name string required
     * The name of the role. Example: "Software Engineer"
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "role added successfully!",
     *      "data": {
     *           "name": "Software Engineer",
     *           "updated_at": "2023-12-18T09:29:14.000000Z",
     *           "created_at": "2023-12-18T09:29:14.000000Z",
     *           "id": 6
     *       }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidationFactory()->make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $input = $request->all();
            $role = Role::create($input);

            return $this->successResponse($role, 'role added successfully!', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to add role', 500);
        }
    }

    /**
     * Update Role
     *
     * Update item on the employee.
     *
     * @bodyParam name string required
     * The name of the role. Example: "Software Engineer"
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "Success to update role",
     *      "data": null
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        try {

            $validator = $this->getValidationFactory()->make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $selectedRole = Role::find($role->id);
            $selectedRole->name = $request->name;
            $selectedRole->save();

            return $this->successResponse(null, "Success to update role");

        } catch (\Throwable $th) {
            return $this->errorResponse('failed to update role', 500);
        }
    }

    /**
     * Delete Role
     *
     * Delete item on the role.
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "Success to delete role",
     *      "data": null
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try {
            $selectedRole=Role::find($role->id);
            $selectedRole->delete();

            return $this->successResponse(null, "Success to delete role");
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to delete role', 500);
        }
    }
}
