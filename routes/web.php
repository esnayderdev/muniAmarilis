<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [HomeController::class, 'manager'])
    ->middleware(['auth', 'manager'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'admin')->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'admin'])
        ->name('admin.dashboard');
});

Route::controller(ProjectController::class)->group(function () {
    Route::get('admin/projects', 'index')->name('admin.projects');
    Route::get('admin/projects/create', 'create')->name('admin.projects.create');
    Route::post('projects', 'store')->name('admin.projects.store');
})->middleware('auth');

require __DIR__ . '/auth.php';
