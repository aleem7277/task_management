<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [AdminController::class, 'index']);
    Route::get('/user/{id}', [AdminController::class, 'show']);
    Route::delete('/user/{id}', [AdminController::class, 'destroy']);
    Route::get('/user/{id}/tasks', [AdminController::class, 'userTasks']);
});

Route::middleware('auth:sanctum', 'user')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/task/create', [TaskController::class, 'store']);
    Route::post('/task/update/{id}', [TaskController::class, 'update']);
    Route::post('/task/delete/{id}', [TaskController::class, 'destroy']);
});
