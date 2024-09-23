<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\AppUsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard')->middleware(['auth']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/protected', function () {});
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', AppUsersController::class);
    Route::resource('projects', ProjectsController::class)->names([
        'index' => 'projects',
        'create' => 'projects.create',
        'edit' => 'projects.edit',
        'delete' => 'projects.delete'
    ]);
    Route::resource('clients', ClientsController::class)->names([
        'index' => 'clients'
    ]);
    Route::resource('tasks', TasksController::class)->names([
        'index' => 'tasks'
    ]);
});

require __DIR__ . '/auth.php';
