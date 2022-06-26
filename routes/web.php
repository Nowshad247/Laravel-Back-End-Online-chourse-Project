<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\VisitorModelController;
use App\Http\Controllers\CoursesController;

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

Route::get('/',[HomeController::class, 'HomeIndex']);
Route::get('/analytic',[VisitorModelController::class, 'index']);
Route::get('/services',[ServicesController::class, 'index']);
Route::get('/getServiceData',[ServicesController::class, 'getServiceData']);
Route::post('/deleteServices',[ServicesController::class, 'deleteServices']);
Route::post('/ServiceAdd',[ServicesController::class, 'ServiceAdd']);
Route::post('/ServiceDetails',[ServicesController::class, 'ServiceDetails']);
Route::post('/ServiceUpdate',[ServicesController::class, 'ServiceUpdate']);

//CoursesController
Route::get('/CoursesAdmin',[CoursesController::class, 'HomeIndex']);
Route::get('/CoursesList',[CoursesController::class, 'getCoursesData']);
Route::post('/ChourseDelete',[CoursesController::class, 'ChourseDelete']);
