<?php

use App\Http\Controllers\Api\V1\Common\GroupController;
use App\Http\Controllers\Api\V1\Common\CourseController;
use App\Http\Controllers\Api\V1\Common\ShowController;

use App\Http\Controllers\Api\V1\Faux\GroupsController;
use App\Http\Controllers\Api\V1\Faux\StudentsController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Api\V1\Admin\Faux\StudentsController as AdminStudentsController;
use App\Http\Controllers\Api\V1\Admin\Faux\CoursesController as AdminCoursesController;
use App\Http\Controllers\Api\V1\Admin\Faux\GroupsController as AdminGroupsController;
use App\Http\Controllers\Api\V1\Admin\Faux\EditController as AdminEditController;
use App\Http\Controllers\Api\V1\Admin\Faux\CreateController as AdminCreateController;
use App\Http\Controllers\Api\V1\Admin\Faux\DeleteController as AdminDeleteController;

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

// Get Token
Route::prefix('auth')->middleware('api')->group(function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
});

// Common part. Not needs token
Route::namespace('App\Http\Controllers\Api\V1')->group(function () {
    Route::as('common.')->namespace('Common')->group(function () {
        Route::get('/courses/{course}', CourseController::class)->name('course');
        Route::get('/groups/{group}', GroupController::class)->name('group');
        Route::get('/students/{student}', ShowController::class)->name('student');
    });

    Route::as('faux.')->namespace('Faux')->group(function () {
        Route::get('/filter/groups', GroupsController::class)->name('groups');
        Route::get('/filter/students', StudentsController::class)->name('students');
    });
});

// Need authorization. Need token
Route::as('admin.')->middleware('jwt.auth')->namespace('App\Http\Controllers\Api\V1\Admin')->group(function () {
    Route::get('/students', AdminStudentsController::class)->name('students');
    Route::get('/courses', AdminCoursesController::class)->name('courses');
    Route::get('/groups', AdminGroupsController::class)->name('groups');

    Route::prefix('students')->as('student.')->namespace('Faux')->group(function () {
        Route::patch('/{student}', AdminEditController::class)->name('edit');
        Route::post('/', AdminCreateController::class)->name('create');
        Route::delete('/{student}', AdminDeleteController::class)->name('delete');
    });
});
