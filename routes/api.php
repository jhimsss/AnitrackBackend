<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\HarvestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
    
    // Program Routes (existing)
    Route::post('/programs', [ProgramController::class, 'store']);
    Route::get('programs', [ProgramController::class, 'index']);
    Route::get('programs/{id}', [ProgramController::class, 'show']);
    Route::put('programs/{id}', [ProgramController::class, 'update']);
    Route::delete('programs/{id}', [ProgramController::class, 'destroy']);
    
    // Farmer Routes
    Route::post('/farmers', [FarmerController::class, 'store']);
    Route::get('farmers', [FarmerController::class, 'index']);
    Route::get('farmers/{id}', [FarmerController::class, 'show']);
    Route::put('farmers/{id}', [FarmerController::class, 'update']);
    Route::delete('farmers/{id}', [FarmerController::class, 'destroy']);
    
    // Harvest Routes
    Route::post('/harvests', [HarvestController::class, 'store']);
    Route::get('harvests', [HarvestController::class, 'index']);
    Route::get('harvests/{id}', [HarvestController::class, 'show']);
    Route::put('harvests/{id}', [HarvestController::class, 'update']);
    Route::delete('harvests/{id}', [HarvestController::class, 'destroy']);
    
    // Additional custom harvest routes
    Route::get('farmers/{farmerId}/harvests', [HarvestController::class, 'getByFarmer']);
    Route::get('harvests/season/{season}', [HarvestController::class, 'getBySeason']);
    
// });