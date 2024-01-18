<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RecoverAccountController;
use App\Http\Controllers\Api\Patients\ListAllPatientsController;
use App\Http\Controllers\Api\Psychologists\ListAllPsychologistsController;
use App\Http\Controllers\Api\Location\SetLocationController;
use App\Http\Controllers\Api\Location\UpdateLocationController;
use App\Http\Controllers\Api\Location\GetLocationsController;
use App\Http\Controllers\Web\Admin\HomeController;
use App\Http\Controllers\Api\Appointments\AppointmentsController;
use App\Http\Controllers\Api\Psychologists\MedicalHistoryController;
use App\Http\Controllers\Api\Patients\EmergencyContactController;

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
        Route::prefix('patients')->group(function() {
            /*
            |-------------------------------------------------------------
            | Emergency Contacts ApiResource tiene las siguientes acciones:
            |-------------------------------------------------------------
            | 1.- Crear contacto de emergencia.
            | 2.- Actualizar contacto de emergencia.
            | 3.- Mostrar todos los contactos de emergencia.
            | 4.- Eliminar contacto de emergencia.
            */
            Route::apiResource('emergency-contacts', EmergencyContactController::class);
            /*
            |-------------------------------------------------------------
            | Appointments ApiResource tiene las siguientes acciones:
            |-------------------------------------------------------------
            | 1.- Crear cita.
            | 2.- Actualizar cita.
            | 3.- Mostrar todas las citas.
            | 4.- Eliminar cita.
            | 5.- Mostrar cita.
            */
            Route::apiResource('appointments', AppointmentsController::class);
        });
        Route::prefix('psychologists')->group(function() {
            /*
            |-------------------------------------------------------------
            | Medical histories ApiResource tiene las siguientes acciones:
            |-------------------------------------------------------------
            | 1.- Crear historiales clínicos.
            | 2.- Actualizar historial clínico.
            | 3.- Mostrar todos los historiales clínicos.
            | 4.- Eliminar historial clínico.
            | 5.- Mostrar historial clínico.
            */
            Route::apiResource('medical-histories', MedicalHistoryController::class);
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
        Route::get('/recent-users', [HomeController::class, 'recentUsers']);
        Route::get('/logins', [HomeController::class, 'logins']);
    });
    Route::prefix('location')->group(function() {
        Route::post('/set-location', SetLocationController::class);
        Route::put('/update-location', UpdateLocationController::class);
        Route::get('/psychologists/locations', [GetLocationsController::class, 'getLocationsPsychologists']);
    });
});
