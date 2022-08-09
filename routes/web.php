<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\VisitorModelController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\contactController;

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
Route::post('/CourseAdd',[CoursesController::class, 'CourseAdd']);
Route::post('/CourseDetails',[CoursesController::class, 'CourseDetails']);
Route::post('/CoursesUpdate',[CoursesController::class, 'CoursesUpdate']);
//Projects Controller 
Route::get('/projectsAdmin',[ProjectsController::class, 'index']);
Route::get('/ProjectsList',[ProjectsController::class, 'getProjectData']);
Route::post('/projectsDelete',[ProjectsController::class, 'projectsDelete']);
Route::post('/projectsAdd',[ProjectsController::class, 'projectsAdd']);
Route::post('/projectsDetails',[ProjectsController::class, 'projectDetails']);
Route::post('/projectsUpdate',[ProjectsController::class, 'projectsUpdate']);
//contact list 
Route::get('/contacts',[contactController::class, 'index']);
Route::post('/contacts',[contactController::class, 'getAllContactInfo']);
Route::post('/contactsDelete',[contactController::class, 'contactsDelete']);