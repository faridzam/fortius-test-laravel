<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Get Employee
     *
     * get employees data
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "get employees data success",
     *      "data": [
     *          {
     *              "id": 29,
     *              "role": 1,
     *              "name": "Farid Zamani",
     *              "salary": "15000000",
     *              "created_at": "2023-12-18T09:00:32.000000Z",
     *              "updated_at": "2023-12-18T09:00:32.000000Z"
     *          },
     *          {
     *              "id": 1,
     *              "role": 1,
     *              "name": "Farid Zamani",
     *              "salary": "15000000",
     *              "created_at": "2023-12-16T10:07:39.000000Z",
     *              "updated_at": "2023-12-18T06:28:43.000000Z"
     *          }
     *      ]
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $employees = Employee::with('role')->get();

            if ($employees && $employees->count() >= 1) {
                return $this->successResponse($employees, 'get employees data success', 200);
            } else {
                return $this->notFoundResponse('employees');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to get employee', 500);
        }
    }

    /**
     * Create Employee
     *
     * Add a new item to the employee.
     *
     * @bodyParam role number required
     * The role of the employee. Example: 1
     *
     * @bodyParam name string required
     * The name of the employee. Example: Farid Zamani
     *
     * @bodyParam salary number required
     * The salary of the employee. Example: 15000000
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "employee added successfully!",
     *      "data": {
     *          "role": 1,
     *          "name": "Farid Zamani",
     *          "salary": 15000000,
     *          "updated_at": "2023-12-18T09:00:32.000000Z",
     *          "created_at": "2023-12-18T09:00:32.000000Z",
     *          "id": 1
     *      }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->getValidationFactory()->make($request->all(), [
                'role' => 'required|integer|min:1|exists:App\Models\Role,id',
                'name' => 'required|string',
                'salary' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $input = $request->all();
            $employee = Employee::create($input);

            return $this->successResponse($employee, 'employee added successfully!', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to add employee', 500);
        }
    }

    /**
     * Update Employee
     *
     * Update item on the employee.
     *
     * @bodyParam role number required
     * The role of the employee. Example: 1
     *
     * @bodyParam name string required
     * The name of the employee. Example: Farid Zamani
     *
     * @bodyParam salary number required
     * The salary of the employee. Example: 15000000
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "employee updated successfully!",
     *      "data": null
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        try {

            $validator = $this->getValidationFactory()->make($request->all(), [
                'role' => 'required|integer|min:1|exists:App\Models\Role,id',
                'name' => 'required|string',
                'salary' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $selectedEmployee = Employee::find($employee->id);
            $selectedEmployee->role = $request->role;
            $selectedEmployee->name = $request->name;
            $selectedEmployee->salary = $request->salary;
            $selectedEmployee->save();

            return $this->successResponse(null, "Success to update employee");

        } catch (\Throwable $th) {
            return $this->errorResponse('failed to update employee', 500);
        }
    }

    /**
     * Delete Employee
     *
     * Delete item on the employee.
     *
     * @authenticated
     * @response {
     *      "status": "success",
     *      "success": true,
     *      "message": "Success to delete employee",
     *      "data": null
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        try {
            $selectedEmployee=Employee::find($employee->id);
            $selectedEmployee->delete();

            return $this->successResponse(null, "Success to delete employee");
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to delete employee', 500);
        }
    }
}
