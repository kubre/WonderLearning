<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ClassworkController;
use App\Http\Controllers\Api\FeesController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\HomeworkController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\ObservationController;
use App\Http\Controllers\TeacherController;
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
        'data' => 4,
    ];
});

// API for mobile app
Route::get('/login', LoginController::class);

Route::get('/logout/{student}/{contact}', LogoutController::class);

Route::get('/attendances/{admission}', AttendanceController::class);

Route::get('/classwork/{admission}', ClassworkController::class);

Route::get('/fees/{admission}', FeesController::class);

Route::get('/homework/{division}', HomeworkController::class);

Route::get('/holidays', HolidayController::class);

Route::get('/gallery/{division}', GalleryController::class);

Route::get('/notices/{division}', NoticeController::class);

Route::get('/chats', [ChatController::class, 'get']);

Route::post('/chats', [ChatController::class, 'create']);

Route::get('/observations/{admission_id}', ObservationController::class);
