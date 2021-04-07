<?php

use App\Models\School;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/', 'website.home');
Route::view('/home', 'website.home');
Route::view('/programs', 'website.programs');
Route::view('/services', 'website.services');
Route::view('/testimonials', 'website.testimonials');
Route::view('/awards', 'website.awards');
Route::view('/gallery', 'website.gallery');
// Route::view('/clients', 'website.clients');
Route::view('/franchise', 'website.franchise');
Route::post('/contact-us', function (Request $request) {
    dd($request);
});
Route::view('/contact-us', 'website.contact');

Route::get('/login/{school:login_url}/', function (School $school) {
    session(['school' => $school]);
    return view('platform::auth.login');
});

Route::get('/logout/{school:login_url}', function (School $school) {
    Auth::guard()->logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return request()->wantsJson()
        ? new JsonResponse([], 204)
        : redirect('/login/' . $school->login_url);
})->missing(function () {
    Auth::guard()->logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return request()->wantsJson()
        ? new JsonResponse([], 204)
        : redirect('/admin/');
})
    ->name('auth.signout');
