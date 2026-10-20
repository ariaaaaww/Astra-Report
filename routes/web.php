<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskReviewController;
use App\Http\Controllers\TaskSubmissionController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.submit');
Route::get('/register', [AuthController::class, 'registerView'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Area Routes
Route::prefix('area')->middleware(['role:Supervisor, Admin', 'auth'])->name('area.')->group(function () {
    Route::get('/', [AreaController::class, 'index'])->name('index');
    Route::get('/create', [AreaController::class, 'create'])->name('create');
    Route::post('/store', [AreaController::class, 'store'])->name('store');
    Route::get('/{area}/edit', [AreaController::class, 'edit'])->name('edit');
    Route::put('/{area}', [AreaController::class, 'update'])->name('update');
    Route::get('/{area}', [AreaController::class, 'show'])->name('show');
    Route::delete('/{area}', [AreaController::class, 'destroy'])->name('delete');
});

// Dealer Routes
Route::prefix('dealer')->middleware(['role:Supervisor, Admin', 'auth'])->name('dealer.')->group(function () {
    Route::get('/', [DealerController::class, 'index'])->name('index');
    Route::get('/create', [DealerController::class, 'create'])->name('create');
    Route::post('/store', [DealerController::class, 'store'])->name('store');
    Route::get('/{dealer}/edit', [DealerController::class, 'edit'])->name('edit');
    Route::put('/{dealer}', [DealerController::class, 'update'])->name('update');
    Route::get('/{dealer}', [DealerController::class, 'show'])->name('show');
    Route::delete('/{dealer}', [DealerController::class, 'destroy'])->name('delete');
});

// Department Routes
Route::prefix('department')->middleware(['role:Supervisor, Admin', 'auth'])->name('department.')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('index');
    Route::get('/create', [DepartmentController::class, 'create'])->name('create');
    Route::post('/store', [DepartmentController::class, 'store'])->name('store');
    Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
    Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
    Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
    Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('delete');
});

// Task Routes
Route::prefix('task')->middleware(['role:Supervisor, Admin', 'auth'])->name('tasks.')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/store', [TaskController::class, 'store'])->name('store');
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
    Route::get('/{task}', [TaskController::class, 'show'])->name('show');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('delete');
});

// Task Review Routes
Route::prefix('task-reviews')->middleware(['role:Supervisor, Admin', 'auth'])->group(function () {
    Route::get('/', [TaskReviewController::class, 'index'])->name('task-reviews.index');
    Route::get('/{id}', [TaskReviewController::class, 'show'])->name('task-reviews.show');
    Route::put('/{id}', [TaskReviewController::class, 'update'])->name('task-reviews.update');
    Route::post('/{id}/approve', [TaskReviewController::class, 'approve'])->name('task-reviews.approve');
    Route::post('/{id}/reject', [TaskReviewController::class, 'reject'])->name('task-reviews.reject');
});

// Task Submission Routes
Route::middleware(['auth', 'role:Dealer, Admin'])->group(function () {
    Route::get('/task-submissions', [TaskSubmissionController::class, 'index'])->name('task-submissions.index');

    Route::get('/tasks/{task}/task-submissions/create', [TaskSubmissionController::class, 'create'])
        ->name('task-submissions.create');
    Route::post('/tasks/{task}/task-submissions', [TaskSubmissionController::class, 'store'])
        ->name('task-submissions.store');

    Route::get('/task-submissions/{submission}', [TaskSubmissionController::class, 'show'])->name('task-submissions.show');
    Route::get('/task-submissions/{submission}/edit', [TaskSubmissionController::class, 'edit'])->name('task-submissions.edit');
    Route::put('/task-submissions/{submission}', [TaskSubmissionController::class, 'update'])->name('task-submissions.update');
    Route::delete('/task-submissions/{submission}', [TaskSubmissionController::class, 'destroy'])->name('task-submissions.delete');

});

// Admin Route
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

