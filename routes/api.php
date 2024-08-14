<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('onboard', [TenantController::class, 'onboard']);



Route::post('/upload', [FileUploadController::class, 'uploadFile'])->middleware('auth:sanctum');
Route::post('/tenant/settings/google-drive', [TenantController::class, 'updateGoogleDriveSettings'])->middleware('auth:sanctum');
Route::post('/upload', [FileUploadController::class, 'uploadFile'])->middleware('auth:sanctum');
Route::get('/google/drive/authorize', [TenantController::class, 'authorizeGoogleDrive'])->middleware('auth:sanctum');
Route::get('/google/drive/callback', [TenantController::class, 'handleCallback']); // No auth middleware here
