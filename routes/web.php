<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isTeacher()) {
        return redirect()->route('teacher.dashboard');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

// Leaderboard - accessible to all authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

// Teacher routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');

    // Tasks
    Route::get('/tasks', [TeacherController::class, 'tasks'])->name('tasks.index');
    Route::get('/tasks/create', [TeacherController::class, 'createTask'])->name('tasks.create');
    Route::post('/tasks', [TeacherController::class, 'storeTask'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TeacherController::class, 'editTask'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TeacherController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TeacherController::class, 'deleteTask'])->name('tasks.delete');

    // Submissions
    Route::get('/submissions', [TeacherController::class, 'submissions'])->name('submissions');
    Route::get('/submissions/{submission}/grade', [TeacherController::class, 'gradeSubmission'])->name('submissions.grade');
    Route::post('/submissions/{submission}/grade', [TeacherController::class, 'storeGrade'])->name('submissions.store-grade');
});

// Student routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/tasks', [StudentController::class, 'tasks'])->name('tasks');
    Route::get('/tasks/{task}', [StudentController::class, 'showTask'])->name('tasks.show');
    Route::post('/tasks/{task}/submit', [StudentController::class, 'submitTask'])->name('tasks.submit');
    Route::get('/submissions', [StudentController::class, 'submissions'])->name('submissions');
    Route::get('/progress', [StudentController::class, 'progress'])->name('progress');
});

require __DIR__.'/auth.php';
