<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [AuthController::class, 'Login'])->middleware(['guest']);

Route::middleware(['auth.cookie', 'auth:api', 'cors'])->group(function () {
    // Route::post('register', [AuthController::class, 'Register'])->middleware(['cek.module:1']);
    Route::resource('role', RoleController::class)->only([
        'index'
    ])->middleware(['cek.module:2']);
    Route::resource('role', RoleController::class)->only([
        'store', 'update', 'destroy'
    ])->middleware(['cek.module:3,4,5']);
    Route::resource('employee', EmployeeController::class)->only([
        'index', 'store', 'update'
    ])->middleware(['cek.module:14,15,16']);
    Route::resource('employee', EmployeeController::class)->only([
        'destroy'
    ])->middleware(['cek.module:17']);
    // Route::resource('module', ModuleController::class)->only([
    //     'index', 'store', 'update', 'destroy'
    // ])->middleware(['cek.module:6,7,8,9']);
    // Route::resource('permission', PermissionController::class)->only([
    //     'index', 'store', 'update', 'destroy'
    // ])->middleware(['cek.module:10,11,12,13']);
});
