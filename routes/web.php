<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\PayrollController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk resource controller EmployeeController
Route::resource('/employees', EmployeeController::class);

// Route untuk resource controller DepartmentController
Route::resource('/departments', DepartmentController::class);

// Route untuk resource controller RoleController
Route::resource('/roles', RoleController::class);

// Route untuk resource controller PayrollController
Route::resource('/payrolls', PayrollController::class);

// Route untuk resource controller PresenceController
Route::resource('/presences', PresenceController::class);

// Route untuk resource controller TaskController
Route::resource('/tasks', TaskController::class);
Route::get('/tasks/done/{id}', [TaskController::class, 'done'])->name('tasks.done');
Route::get('/tasks/pending/{id}', [TaskController::class, 'pending'])->name('tasks.pending');
Route::get('/tasks/in-progress/{id}', [TaskController::class, 'inProgress'])->name('tasks.in-progress');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
