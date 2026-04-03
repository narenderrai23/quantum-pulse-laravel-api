<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/leads', [LeadController::class, 'store']);
Route::post('/chat', [ChatController::class, 'chat']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/settings/public', [SettingController::class, 'public']);

// Protected routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/logout', [AuthController::class, 'logout']);
    Route::get('/admin/me', [AuthController::class, 'me']);

    // Leads management (admin only)
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{id}', [LeadController::class, 'show']);
    Route::patch('/leads/{id}', [LeadController::class, 'update']);
    Route::delete('/leads/{id}', [LeadController::class, 'destroy']);

    // Settings management (admin only)
    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'update']);
    Route::post('/settings/upload', [SettingController::class, 'upload']);
});
