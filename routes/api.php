<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StudentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('students', [App\Http\Controllers\API\StudentController::class, 'index']);

Route::post('student', [App\Http\Controllers\API\StudentController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('student/{phone}', [App\Http\Controllers\API\StudentController::class, 'selectOne']);
Route::post('student/{phone}/update', [App\Http\Controllers\API\StudentController::class, 'update']);
Route::delete('student/{phone}/delete', [App\Http\Controllers\API\StudentController::class, 'delete']);