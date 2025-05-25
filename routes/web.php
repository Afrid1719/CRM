<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\AppUsersController;
use App\Http\Controllers\AttachmentsController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
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
    Route::post('tasks/{task}', [TasksController::class, 'update'])->name('tasks.update');
    Route::resources([
        'users' => AppUsersController::class,
        'projects' => ProjectsController::class,
        'tasks' => TasksController::class,
        'clients' => ClientsController::class
    ]);
    Route::put('tasks/{task}/update-status', [TasksController::class, 'updateStatus'])->name('tasks.update-status');
    Route::put('clients/{client}/activation', [ClientsController::class, 'activation'])->name('clients.activation');
    Route::delete('attachments/{attachment}', [AttachmentsController::class, 'destroy'])->name('attachments.destroy');
});

// This is only for testing purpose, it can be removed later
Route::get('send-mail', function () {
    Mail::to('aliatif908@gmail.com')->send(new TestMail('test'));
    return 'Email sent!';
});

require __DIR__ . '/auth.php';
