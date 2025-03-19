<?php

use App\Http\Controllers\CalendarApiController;
use App\Http\Controllers\EquipmentApiController;
use App\Http\Controllers\MaintenanceApiController;
use App\Http\Controllers\PriorityApiController;
use App\Http\Controllers\ProjectApiController;
use App\Http\Controllers\RolesPermissionsController;
use App\Http\Controllers\TaskApiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\TeamApiController;
use App\Http\Controllers\CategoryApiController;
use App\Http\Controllers\InstructionApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('roles', RolesPermissionsController::class);
Route::get('/rolesPermissions', [RolesPermissionsController::class, 'index2']);
Route::get('/permissions', [RolesPermissionsController::class, 'index4']);
Route::apiResources ([
    'users'=>UserApiController::class,
    'tasks'=>TaskApiController::class,
    'projects'=>ProjectApiController::class,
    'equipments'=>EquipmentApiController::class,
    'calendars'=>CalendarApiController::class,
    'maintenances'=>MaintenanceApiController::class,
    'teams'=>TeamApiController::class,
    'priority'=>PriorityApiController::class,
    'categories'=>CategoryApiController::class,
    'instructions'=>InstructionApiController::class,

]);
