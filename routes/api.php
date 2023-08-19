<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(UserController::class)->prefix('user')->group(
    function () {
        Route::post('/signup', 'signup');
        Route::post('/login', 'login');
        Route::post('/forget-password', 'forget');
        Route::post('/socialSignup', 'socialSignup');
        Route::post('/socialLogin', 'socialLogin');
        Route::post('/profile/setup', 'profileSetup');
        Route::post('/update/profile', 'profileUpdate');
        Route::get('/listing', 'listing');
        Route::get('/attendee/detail/{id}', 'userDetail');
        Route::get('/sponsor/detail/{id}', 'sponsorDetail');
        Route::get('/speaker/detail/{id}', 'speakerDetail');
        Route::get('/favourite/{id}', 'userFavourite');
        Route::get('/skills', 'skillsListing');
        Route::get('/verticals', 'verticalsListing');
        Route::post('/upload-file', 'uploadFile');
        Route::get('/discover', 'discoverListing');
    }
);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
