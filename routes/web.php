<?php

use App\Http\Controllers\StudentController;
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


Route::get('/', [StudentController::class, 'login']);

Route::prefix('/admin/student')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [StudentController::class, 'index']);
    Route::get('/add', [StudentController::class, 'create']);
    Route::get('/view', [StudentController::class, 'view']);
    Route::post('/status', [StudentController::class, 'student_status']);
    Route::get('/delete/{id}', [StudentController::class, 'destroy']);
    Route::get('/activate/{id}', [StudentController::class, 'activate']);
    Route::get('/deactivate/{id}', [StudentController::class, 'deactivate']);
});

Route::resource('student', StudentController::class);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/test', [StudentController::class, 'test']);
