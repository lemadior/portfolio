<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Main\IndexController as HomeController;

use App\Http\Controllers\Faux\GroupsController;
use App\Http\Controllers\Faux\StudentsController;
use App\Http\Controllers\Faux\ShowController;
use App\Http\Controllers\Faux\CourseController;
use App\Http\Controllers\Faux\GroupController;

use App\Http\Controllers\Admin\Faux\IndexController as AdminIndexController;
use App\Http\Controllers\Admin\Faux\EditController as AdminEditController;
use App\Http\Controllers\Admin\Faux\CreateController as AdminCreateController;
use App\Http\Controllers\Admin\Faux\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\Faux\ShowController as AdminShowController;
use App\Http\Controllers\Admin\Faux\UpdateController as AdminUpdateController;
use App\Http\Controllers\Admin\Faux\DeleteController as AdminDeleteController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main page
Route::namespace('App\Http\Controllers\Main')->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('main.index');
});

// Common pages. Not need log in
Route::prefix('faux')->as('faux.')->namespace('App\Http\Controllers\Faux')->group(function() {
    Route::get('/filter/groups', [GroupsController::class, 'showFilteredGroups'])->name('groups');
    Route::post('/filter/groups', [GroupsController::class, 'showFilteredGroups'])->name('groups.post');
    Route::get('/filter/students', [StudentsController::class, 'showFilteredStudents'])->name('students');
    Route::post('/filter/students', [StudentsController::class, 'showFilteredStudents'])->name('students.post');
    Route::get('/students/{student}', [ShowController::class, 'showStudentData'])->name('show');
    Route::get('/courses/{course}', [CourseController::class, 'showCourseData'])->name('course');
    Route::get('/groups/{group}', [GroupController::class, 'showGroupData'])->name('group');
});

// Admin dashboard. Need log in
Route::prefix('admin')->as('admin.')->namespace('App\Http\Controllers\Admin')->middleware('auth')->group(function() {
    Route::prefix('faux')->as('faux.')->namespace('Faux')->group(function() {
        Route::get('/', [AdminIndexController::class, 'index'])->name('index');
        Route::get('/create', [AdminCreateController::class, 'create'])->name('create');
        Route::get('/students/{student}/edit', [AdminEditController::class, 'edit'])->name('edit');

        Route::post('/store', [AdminStoreController::class, 'store'])->name('store');
        Route::patch('/students/{student}', [AdminUpdateController::class, 'update'])->name('update');
        Route::delete('/students/{student}', [AdminDeleteController::class, 'delete'])->name('delete');
    });
});

// Authentication pages
Route::prefix('auth')->as('auth.')->namespace('App\Http\Controllers\Auth')->group(function() {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'loginPost'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'registerPost'])->name('register.post');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});
