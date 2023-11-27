<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RecoverAccountController;
use App\Http\Controllers\Api\Patients\ListAllPatientsController;
use App\Http\Controllers\Api\Psychologists\ListAllPsychologistsController;

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

Route::prefix('v1.0')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('/sign-up', [AuthController::class, 'signUp']);
        Route::post('/sign-in', [AuthController::class, 'signIn']);
        Route::get('/verify-user', [AuthController::class, 'verifyUser']);
        Route::post('/send-verification-code', [RecoverAccountController::class, 'sendVerificationCode']);
        Route::post('/check-verification-code', [RecoverAccountController::class, 'checkVerificationCode']);
        Route::put('/reset-password', [RecoverAccountController::class, 'resetPassword'])->middleware('verification.code.is.checked');
    });

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('/auth/sign-out', [AuthController::class, 'signOut']);
    });

    Route::middleware(['web', 'auth'])->group(function() {
        Route::prefix('patients')->group(function() {
            Route::get('/list-all-patients', ListAllPatientsController::class);
        });
        Route::prefix('psychologists')->group(function() {
            Route::get('/list-all-psychologists', ListAllPsychologistsController::class);
        });
    });
});
