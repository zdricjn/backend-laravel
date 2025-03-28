<?php 

// routes/api.php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // Project Routes
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    
    // Project Tasks Routes
    Route::get('/projects/{projectId}/tasks', [ProjectController::class, 'tasks']);
    Route::post('/projects/{projectId}/tasks', [TaskController::class, 'store']);
    Route::put('/projects/{projectId}/tasks/{taskId}', [TaskController::class, 'update']);
    Route::delete('/projects/{projectId}/tasks/{taskId}', [TaskController::class, 'destroy']);
});