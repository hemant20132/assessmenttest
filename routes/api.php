<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Middleware\WithAuthorization;


Route::middleware([WithAuthorization::class])->group(function () {

	Route::post('create_user', [UserController::class, 'UserCreate']);
	Route::post('create_project', [ProjectController::class, 'CreateProject']);
	Route::post('create_timesheet', [TimeSheetController::class, 'CreateTimeSheet']);
	
	Route::get('get_user/{id}',[UserController::class, 'GetSingleUser']);
	Route::get('get_project/{id}', [ProjectController::class, 'GetSingleProject']);
	Route::get('get_timesheet/{id}',[TimeSheetController::class, 'GetSingleTimeSheet']);
	
	Route::get('get_user_all',[UserController::class, 'GetAll']);
	Route::get('get_project_all',[ProjectController::class, 'GetAll']);
	Route::get('get_timesheet_all',[TimeSheetController::class, 'GetAll']);

	Route::post('update_user/{id}', [UserController::class ,'Update']);
	Route::post('update_project/{id}', [ProjectController::class, 'Update']);
	Route::post('update_timesheet/{id}', [TimeSheetController::class, 'Update']);

	Route::post('delete_user/{id}', [UserController::class ,'Delete']);
	Route::post('delete_project/{id}', [ProjectController::class, 'Delete']);
	Route::post('delete_timesheet/{id}', [TimeSheetController::class, 'Delete']);

});

