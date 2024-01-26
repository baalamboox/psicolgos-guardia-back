<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RecoverAccountController;
use App\Http\Controllers\Api\Location\LocationController;
use App\Http\Controllers\Api\Location\PsychologistLocationsController;
use App\Http\Controllers\Api\Patient\PsychologistInfoMapController;


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

// Primera versión de la API Rest.
Route::prefix('v1.0')->group(function() {

    /*
    |--------------------------------------------------------------------------------------------
    | Auth tiene los siguientes EndPoints:
    |--------------------------------------------------------------------------------------------
    | 1. Registrar (Pacientes ó Psicólogos).
    | 2. Autenticar (Pacientes ó Psicólogos).
    | 3. Verificar si existen (Pacientes ó Psicólogos) registrados.
    | 4. Enviar código de verificación por correo electrónico (Recuperación de contraseña).
    | 5. Verificar el código de verificación.
    | 6. Registrar nueva contraseña para recuperar cuenta.
    */
    Route::prefix('auth')->group(function() {
        Route::post('sign-up', [AuthController::class, 'signUp']);
        Route::post('sign-in', [AuthController::class, 'signIn']);
        Route::get('verify-user', [AuthController::class, 'verifyUser']);
        Route::post('send-verification-code', [RecoverAccountController::class, 'sendVerificationCode']);
        Route::post('check-verification-code', [RecoverAccountController::class, 'checkVerificationCode']);

        // El siguiente EndPoint hace uso de un Middleware creado para verificar si el código de veridicación ha sido verificado.
        Route::put('reset-password', [RecoverAccountController::class, 'resetPassword'])->middleware('verification.code.is.checked');
    });

    Route::middleware('auth:sanctum')->group(function() {

        // EndPoint para cerrar sesión.
        Route::get('/auth/sign-out', [AuthController::class, 'signOut']);

        /*
        |-----------------------------------------------------------------
        | Location tiene los siguientes EndPoints:
        |-----------------------------------------------------------------
        | 1.- Almacenar ubicación (Paciente o psicólogo).
        | 2.- Actualizar ubicación (Paciente o psicólogo).
        */
        Route::prefix('location')->group(function() {
            Route::post('store', [LocationController::class, 'store']);
            Route::put('update', [LocationController::class, 'update']);
        });

        /*
        |-----------------------------------------------------------------
        | Appointment tiene los siguientes EndPoints:
        |-----------------------------------------------------------------
        | 1.- Almacenar ubicación (Paciente o psicólogo).
        | 2.- Actualizar ubicación (Paciente o psicólogo).
        */

        Route::prefix('patient')->group(function() {
        });
        Route::prefix('psychologist')->group(function() {
        });
    });

    // EndPoint para obtener las ubicaciones de Psicólogos por zona.
    Route::get('location/psychologists', PsychologistLocationsController::class);

    // EndPoint para obtener la información breve del psicólogo.
    Route::get('patient/psychologistInfoMap/{userId}', PsychologistInfoMapController::class);
});
