<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplyController;
use App\Http\Controllers\JobPreferenceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendVerificationCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\verifyCodeController;

use App\Http\Controllers\JobController;
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

Route::controller(JobApplyController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('apply-jobs/{jobId}', 'apply')->name('apply');
    Route::delete('apply-jobs/{jobId}', 'inapply')->name('inapply');
    Route::get('apply-jobs', 'index')->name('applications.index');
});

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


Route::apiResource('jobs', JobController::class);

Route::prefix('job-seeker')->group(function () {
    Route::apiResource('roles', RoleController::class)
        ->only(['index', 'store', 'destroy']);
});

Route::post('/job-preferences', [JobPreferenceController::class, 'store']);
Route::put('/job-preferences/{jobPreference}', [JobPreferenceController::class, 'update']);

Route::post('/verify-code', [AuthController::class, 'verifyCode']);
