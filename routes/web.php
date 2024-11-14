<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CourseController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/course/{tab?}', [CourseController::class, 'index'])
    ->name('course.index')
    ->where('tab', 'ongoing|completed');

Route::get('/course/create', [CourseController::class, 'create']);
Route::post('/course/', [CourseController::class, 'store']);
Route::get('/course/{course}/{tab?}', [CourseController::class, 'show'])->name('course.show');

Route::get('/assignment/{tab?}', [AssignmentController::class, 'index'])
    ->name('assignment.index')
    ->where('tab', 'remaining|results');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/course', [CourseController::class, 'index'])->name('course.index');
});
