<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\PreferenceController;

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

Route::middleware(['auth'])->group(function () {
    //Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
    Route::get('/task/{id}/edit', [TaskController::class, 'edit'])->name('task.edit');
    Route::get('/task/{id}/delete', [TaskController::class, 'delete'])->name('task.delete');
    Route::get('/task/{id}/toggleCompletionStatus', [TaskController::class, 'toggleCompletionStatus'])->name('task.toggleCompletionStatus');

    Route::get('/folder/create', [FolderController::class, 'create'])->name('folder.create');
    Route::get('/folder/{id}/edit', [FolderController::class, 'edit'])->name('folder.edit');
    Route::get('/folder/{id}/delete/', [FolderController::class, 'delete'])->name('folder.delete');

    Route::get('/preference/{name}/reset', [PreferenceController::class, 'delete'])->name('preference.reset');
    Route::get('/preference/{name}/{value}', [PreferenceController::class, 'createOrUpdate'])->name('preference.set');
    Route::get('/preference/{name}', [PreferenceController::class, 'read'])->name('preference.get');
});

Route::get('/', function () {
    return view('index');
})->name('root');


Route::get('/dashboard', function () {
    //return view('dashboard');
    return redirect()->route('task.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
