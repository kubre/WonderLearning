<?php

use App\Http\Controllers\SchoolLoginController;
use App\Models\ContactForm;
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
    $request->validate([
        'name' => ['required', 'max:191'],
        'email' => ['required', 'email', 'max:191'],
        'contact' => ['required', 'numeric'],
        'subject' => ['required', 'max:191'],
        'message' => ['required', 'max:500'],
    ], [
        'name.max' => 'Name is too long',
        'email.max' => 'Email is too long',
        'contact.numeric' => 'Only numbers are allowed!',
        'subject.max' => 'Subject is too long',
        'message.max' => 'Message is too long',
    ]);

    ContactForm::create($request->all());
    return redirect('contact-us')->with(
        'status',
        'We received your request, We will contact you back as soon as possible!'
    );
});

Route::view('/contact-us', 'website.contact');

Route::get('/login/{school:login_url}/', [SchoolLoginController::class, 'showLoginForm']);

Route::get('/logout/{school:login_url}', [SchoolLoginController::class, 'schoolLogout'])
    ->missing([SchoolLoginController::class, 'adminLogout'])
    ->name('auth.signout');
