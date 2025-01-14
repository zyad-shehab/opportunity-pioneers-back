<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobPreferenceController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::apiResource('employer/informations', EmployerController::class)->only([
    'store',
    'update',
    'show',
]);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('job-seeker')->group(function () {
    Route::apiResource('roles', RoleController::class)
        ->only(['index', 'store', 'destroy']);
});

Route::post('/job-preferences', [JobPreferenceController::class, 'store']);
Route::put('/job-preferences/{jobPreference}', [JobPreferenceController::class, 'update']);
