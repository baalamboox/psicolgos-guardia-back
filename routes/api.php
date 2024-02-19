<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RecoverAccountController;
use App\Http\Controllers\Api\Location\LocationController;
use App\Http\Controllers\Api\Location\PsychologistLocationsController;
use App\Http\Controllers\Api\Patient\PsychologistInfoMapController;
use App\Http\Controllers\Api\Patient\EmergencyContactController;
use App\Http\Controllers\Api\Appointment\AppointmentController;
use App\Http\Controllers\Api\Psychologist\MedicalHistoryController;


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
Route::prefix('v1.0')->group(function () {

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
    Route::prefix('auth')->group(function () {
        Route::post('sign-up', [AuthController::class, 'signUp']);
        Route::post('sign-in', [AuthController::class, 'signIn']);
        Route::get('verify-user', [AuthController::class, 'verifyUser']);
        Route::post('send-verification-code', [RecoverAccountController::class, 'sendVerificationCode']);
        Route::post('check-verification-code', [RecoverAccountController::class, 'checkVerificationCode']);

        // El siguiente EndPoint hace uso de un Middleware creado para verificar si el código de veridicación ha sido verificado.
        Route::put('reset-password', [RecoverAccountController::class, 'resetPassword'])->middleware('verification.code.is.checked');
    });

    Route::middleware('auth:sanctum')->group(function () {

        // EndPoint para cerrar sesión.
        Route::get('auth/sign-out', [AuthController::class, 'signOut']);

        /*
        |-----------------------------------------------------------------
        | Location tiene los siguientes EndPoints:
        |-----------------------------------------------------------------
        | 1. Almacenar ubicación (Paciente o psicólogo).
        | 2. Actualizar ubicación (Paciente o psicólogo).
        */
        Route::prefix('location')->group(function () {
            Route::post('store', [LocationController::class, 'store']);
            Route::put('update', [LocationController::class, 'update']);
        });

        // Grupo de EndPoints para pacientes.
        Route::prefix('patient')->group(function () {

            /*
            |-----------------------------------------------------------------
            | Emergency contact Api Resource tiene los siguientes EndPoints:
            |-----------------------------------------------------------------
            | 1. Crear contacto de emergencia (Solo paciente).
            | 2. Editar contacto de emergencia (Solo paciente).
            | 3. Eliminar contacto de emergencia (Solo paciente).
            | 4. Mostrar contactos de emergencia por paciente.
            | 5. Mostrar contacto de emergencia (Solo paciente).
            */
            Route::apiResource('emergency-contact', EmergencyContactController::class);

            /*
            |-----------------------------------------------------------------
            | Appointment para paciente tiene los siguientes EndPoints:
            |-----------------------------------------------------------------
            | 1. Crear citas (Solo paciente).
            */
            Route::prefix('appointment')->group(function () {
                Route::post('create', [AppointmentController::class, 'create'])->middleware('check.pending.or.scheduled');
                Route::patch('{id}/cancel', [AppointmentController::class, 'cancel']);
            });

            // Route::get('my-medical-history');
        });

        // Grupo de EndPoints para psicólogos.
        Route::prefix('psychologist')->group(function () {
            Route::prefix('appointment')->group(function () {
                Route::patch('{id}/schedule', [AppointmentController::class, 'schedule']);
                Route::patch('{id}/reject', [AppointmentController::class, 'reject']);
                Route::patch('{id}/attend', [AppointmentController::class, 'attend']);
            });
            Route::prefix('medical-history')->group(function () {
                Route::post('{idPatient}/create', [MedicalHistoryController::class, 'create']);
                Route::get('{idPatient}/show', [MedicalHistoryController::class, 'show']);
            });
        });
    });

    // EndPoint para obtener las ubicaciones de Psicólogos por zona.
    Route::get('location/psychologists', PsychologistLocationsController::class);

    // EndPoint para obtener la información breve del psicólogo.
    Route::get('patient/psychologist-info-map/{userId}', PsychologistInfoMapController::class);
});
