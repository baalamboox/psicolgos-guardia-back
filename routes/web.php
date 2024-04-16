<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Auth\RecoverAccountController;
use App\Http\Controllers\Web\Admin\HomeController;
use App\Http\Controllers\Web\Admin\ProfileController;
use App\Http\Controllers\Web\Admin\NewAdminController;
use App\Http\Controllers\Web\Admin\ConfigController;
use App\Http\Controllers\Web\Admin\Patients\GeneralDataController;
use App\Http\Controllers\Web\Admin\Patients\MedicalHistoryController;
use App\Http\Controllers\Web\Admin\MetricsLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return redirect()->route('sign.in');
});
Route::prefix('admin')->group(function() {
    Route::get('/sign-in', [AuthController::class, 'showViewSignIn'])->name('sign.in');
    Route::prefix('auth')->group(function() {
        Route::post('/sign-in', [AuthController::class, 'signIn'])->name('auth.sign.in');
        Route::post('/send-verification-code', [RecoverAccountController::class, 'sendVerificationCode'])->name('auth.send.verification.code');
        Route::post('/check-verification-code', [RecoverAccountController::class, 'checkVerificationCode'])->name('auth.check.verification.code');
        Route::post('/reset-password', [RecoverAccountController::class, 'resetPassword'])->name('auth.reset.password');
    });
    Route::middleware(['auth'])->group(function() {
        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::get('/profile', [ProfileController::class, 'showViewProfile'])->name('profile');
        Route::get('/profile/activity', [ProfileController::class, 'showViewActivity'])->name('activity');
        Route::get('/profile/config', [ConfigController::class, 'showViewConfig'])->name('config');
        Route::post('/profile/config/update-profile-photo', [ConfigController::class, 'updateProfilePhoto'])->name('update.profile.photo');
        Route::post('/profile/config/update-personal-contact-data', [ConfigController::class, 'updatePersonalContactData'])->name('update.personal.contact.data');
        Route::post('/profile/config/update-password', [ConfigController::class, 'updatePassword'])->name('update.password');
        Route::get('/auth/sign-out', [AuthController::class, 'signOut'])->name('auth.sign.out');
        Route::get('/new-admin', [NewAdminController::class, 'showViewNewAdmin'])->name('new.admin');
        Route::post('/create-admin', [NewAdminController::class, 'createNewAdmin'])->name('create.admin');
        Route::prefix('patients')->group(function() {
            Route::get('/patient-list', function() {
                return view('admin.patients.patients');
            })->name('patients');
            Route::get('/general-data/{id}', GeneralDataController::class);
            Route::get('/medical-history/{id}', MedicalHistoryController::class);
        });
        Route::prefix('psychologists')->group(function() {
            Route::get('/psychologist-list', function() {
                return view('admin.psychologists.psychologists');
            })->name('psychologists');
            Route::get('/general-data/{id}', GeneralDataController::class);
        });
        Route::prefix('metrics')->group(function() {
            Route::get('/graphs', function() {
                return view('admin.metrics');
            })->name('graphs');
        });
        Route::get('metrics-login', MetricsLoginController::class);
        Route::get('recent-users', [HomeController::class, 'recentUsers']);
        Route::get('list-all-patients', function () {
            return response()->json([
                'data' => 'hola',
            ], 200);
        });
    });
    Route::get('/forgot-password', [RecoverAccountController::class, 'showViewForgotPassword'])->name('forgot.password');
    Route::get('/verification-code', [RecoverAccountController::class, 'ShowViewVerificationCode'])->middleware('validate.email.in.sesion')->name('verification.code');
    Route::get('/reset-password', [RecoverAccountController::class, 'showViewResetPassword'])->middleware('verification.code.is.checked')->name('reset.password');
});
