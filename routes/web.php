<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/iniciar-sesion', function () {
    return view('auth.signin');
});

Route::get('/recuperar-clave', function () {
    return view('auth.forgot-password');
});

Route::get('/nuevo-administrador', function () {
    return view('admin.new-admin');
});

Route::get('/perfil', function () {
    return view('admin.profile');
});

Route::get('/configuraciones', function () {
    return view('admin.config');
});

Route::get('/metricas', function () {
    return view('admin.metrics');
});

Route::get('/perfil/actividad', function () {
    return view('admin.logs');
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

Route::get('/saludar', function () {
    return 'Hola';
});
