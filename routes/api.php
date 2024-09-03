<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoController;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::get('todo-list', [TodoController::class, 'index'])->name('todo-list.index');
// Route::get('todo-list/{todoList}', [TodoController::class, 'show'])->name('todo-list.show');
// Route::post('todo-list', [TodoController::class, 'store'])->name('todo-list.store');
// Route::delete('todo-list/{todoList}', [TodoController::class, 'destroy'])->name('todo-list.destroy');
// Route::put('todo-list/{todoList}', [TodoController::class, 'update'])->name('todo-list.update');
Route::apiResource('todo-list', TodoController::class);
// Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
// Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
// Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
// Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::apiResource('todo-list.task', TaskController::class)->except('show')->shallow();
