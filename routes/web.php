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
use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route Middleware untuk memeriksa peran pengguna
Route::middleware(['auth'])->group(function () {

    // Route untuk halaman dashboard 
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['role:*']);
    Route::get('/dashboard/presence', [DashboardController::class, 'presence'])->middleware(['role:*']);

    // Route untuk resource controller EmployeeController & middleware hanya untuk role HR yang bisa mengakses halaman ini
    Route::resource('/employees', EmployeeController::class) ->middleware(['role:HR']);

    // Route untuk resource controller DepartmentController & middleware hanya untuk role HR yang bisa mengakses halaman ini
    Route::resource('/departments', DepartmentController::class) ->middleware(['role:HR']);

    // Route untuk resource controller RoleController & middleware hanya untuk role HR yang bisa mengakses halaman ini
    Route::resource('/roles', RoleController::class) ->middleware(['role:HR']);

    // Route untuk resource controller PayrollController & middleware semua role bisa mengakses halaman ini
    Route::resource('/payrolls', PayrollController::class) ->middleware(['role:*']);

    // Route untuk resource controller LeaveRequestController & middleware semua role bisa mengakses halaman ini
    Route::resource('/leave-requests', LeaveRequestController::class)->middleware(['role:*']);
    // Route untuk mengonfirmasi dan menolak permintaan cuti dengan middleware hanya untuk role HR
    Route::get('/leave-requests/confirm/{id}', [LeaveRequestController::class, 'confirm'])->name('leave-requests.confirm')->middleware(['role:HR']);
    Route::get('/leave-requests/reject/{id}', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject')->middleware(['role:HR']);

    // Route untuk resource controller PresenceController & middleware semua role bisa mengakses halaman ini
    Route::resource('/presences', PresenceController::class)->middleware(['role:*']);

    // Route untuk resource controller TaskController
    Route::resource('/tasks', TaskController::class)->middleware(['role:*']);
    Route::get('/tasks/done/{id}', [TaskController::class, 'done'])->name('tasks.done')->middleware(['role:*']);
    Route::get('/tasks/pending/{id}', [TaskController::class, 'pending'])->name('tasks.pending')->middleware(['role:*']);
    Route::get('/tasks/in-progress/{id}', [TaskController::class, 'inProgress'])->name('tasks.in-progress')->middleware(['role:*']);

});

// Route untuk halaman profil pengguna ( bawaan dari Laravel Breeze )
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
