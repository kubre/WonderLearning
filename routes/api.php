<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/getSyllabus', [AdminController::class, 'get']);

// API for mobile app
Route::get('/login', LoginController::class);
Route::get('/attendances/{admission}', AttendanceController::class);
