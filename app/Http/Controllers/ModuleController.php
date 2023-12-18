<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $module = Modules::all();

            if ($module && $module->count() >= 1) {
                return $this->successResponse($module, 'get module data success', 200);
            } else {
                return $this->notFoundResponse('modules');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to get modules', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
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
            $module = Modules::create($input);

            return $this->successResponse($module, 'module added successfully!', 200);
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to add module', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modules $module)
    {
        try {

            $validator = $this->getValidationFactory()->make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->validateErrorResponse($validator->errors(), 400);
            }

            $selectedModule = Modules::find($module->id);
            $selectedModule->name = $request->name;
            $selectedModule->save();

            return $this->successResponse(null, "Success to update module");

        } catch (\Throwable $th) {
            return $this->errorResponse('failed to update module', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modules $module)
    {
        try {
            $selectedModule=Modules::find($module->id);
            $selectedModule->delete();

            return $this->successResponse(null, "Success to delete module");
        } catch (\Throwable $th) {
            return $this->errorResponse('failed to delete module', 500);
        }
    }
}
