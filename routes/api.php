<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ClassworkController;
use App\Http\Controllers\Api\FeesController;
use App\Http\Controllers\Api\HomeworkController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
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

Route::get('/version', function () {
    return [
        'data' => 1,
    ];
});

// API for mobile app
Route::get('/login', LoginController::class);

Route::get('/logout/{student}/{contact}', LogoutController::class);

Route::get('/attendances/{admission}', AttendanceController::class);

Route::get('/classwork/{admission}', ClassworkController::class);

Route::get('/fees/{admission}', FeesController::class);

Route::get('/homework/{division}', HomeworkController::class);
