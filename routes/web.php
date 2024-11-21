<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuizController;
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


Route::get('/courses/{tab?}', [CourseController::class, 'index'])
    ->name('course.index')
    ->where('tab', 'ongoing|completed');

Route::get('/courses/create', [CourseController::class, 'create']);

Route::get('/courses/{course}/{tab?}', [CourseController::class, 'show'])->name('course.show');

Route::get('/assignment/{tab?}', [AssignmentController::class, 'index'])
    ->name('assignment.index')
    ->where('tab', 'remaining|results');

Route::get('/quiz/{tab?}', [QuizController::class, 'index'])
    ->name('quiz.index')
    ->where('tab', 'remaining|results');




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/courses', [CourseController::class, 'index'])->name('course.index');
    Route::resource('post', PostController::class);
    Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/post/{post}/comment', [CommentController::class, 'index'])->name('comment.index');
});
