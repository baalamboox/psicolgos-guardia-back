<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Admin\HomeController;
use App\Http\Controllers\Web\Admin\ProfileController;
use App\Http\Controllers\Web\Admin\NewAdminController;

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
    return redirect()->route('signin');
});
Route::prefix('admin')->group(function () {
    Route::get('/signin', [AuthController::class, 'showSignin'])->name('signin');
    Route::post('/auth/signin', [AuthController::class, 'signin'])->name('auth.signin');
    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [HomeController::class, 'home'])->name('home');
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
        Route::get('/profile/activity', [ProfileController::class, 'showActivity'])->name('activity');
        Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('/new-admin', [NewAdminController::class, 'showViewNewAdmin'])->name('new.admin');
        Route::post('/create-admin', [NewAdminController::class, 'createNewAdmin'])->name('create.admin');
    });
});






Route::get('/recuperar-clave', function () {
    return view('auth.forgot-password');
});
Route::get('/configuraciones', function () {
    return view('admin.config');
});

Route::get('/metricas', function () {
    return view('admin.metrics');
});

Route::get('/pacientes', function () {
    return view('admin.patients.patients');
});

Route::get('/psicologos', function () {
    return view('admin.psychologists.psychologists');
});

Route::get('/pacientes/datos-generales/{id}', function () {
    return view('admin.patients.general-data');
});

Route::get('/psicologos/datos-generales/{id}', function () {
    return view('admin.psychologists.general-data');
});

Route::get('/psicologos/historiales-clinicos/{id}', function () {
    return view('admin.psychologists.medical-histories');
});

Route::get('/pacientes/historial-medico/{id}', function () {
    return view('admin.patients.medical-history');
});

Route::get('/codigo-verificacion', function () {
    return view('auth.verification-code');
});

Route::get('/nueva-clave', function () {
    return view('auth.reset-password');
});
