<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DeliverableController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'admin')->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'admin'])
        ->name('admin.dashboard');
    Route::controller(ProjectController::class)->group(function () {
        Route::get('admin/projects', 'index')->name('admin.projects.index');
        Route::get('admin/projects/create', 'create')->name('admin.projects.create');
        Route::post('projects', 'store')->name('admin.projects.store');
        Route::put('admin/projects/{id}', 'update')->name('admin.projects.update');
    });
    Route::controller(ActivityController::class)->group(function () {
        Route::put('admin/activities/{id}', 'update')->name('admin.activities.update');
    });
});

Route::middleware('auth', 'manager')->group(function () {
    Route::controller(ActivityController::class)->group(function () {
        Route::get('manager/activities', 'index')->name('manager.index');
    });
    Route::controller(DeliverableController::class)->group(function () {
        Route::put('manager/deliverables/{id}', 'update')->name('manager.deliverable.update');
    });
});

require __DIR__ . '/auth.php';
